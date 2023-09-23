<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Yajra\DataTables\DataTables;

class ReviewController extends Controller
{
    /**
     *   created by : Maaz Ansari
     *   Created On : 10-Aug-2022
     *   Uses :  To show review listing page
     */
    public function index()
    {
        if (!checkPermission('review')) {
            return redirect('/webadmin/dashboard');
        }
        // $data['data'] = Review::all();
        // $data['user'] = User::where('approval_status','accepted')->get();
        $data['review_edit'] = checkPermission('review_edit');
        $data['review_view'] = checkPermission('review_view');
        $data['review_status'] = checkPermission('review_status');
        return view('backend/review/index', ["data" => $data]);
    }
    /**
     *   created by : Maaz Ansari
     *   Created On : 10-Aug-2022
     *   Uses :  display dynamic data in datatable for review page      
     */
    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Review::with('user', 'product')->orderBy('updated_at', 'desc');
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_user']) && !is_null($request['search']['search_user'])) {
                            $query->where('user_id', $request['search']['search_user']);
                        }
                        $query->get();
                    })
                    ->editColumn('user_id', function ($event) {
                        return $event->user->name;
                    })
                    ->editColumn('product_name', function ($event) {
                        $product_name = json_decode($event->product->product_name, TRUE)['en'];
                        return $product_name;
                    })
                    ->editColumn('rating', function ($event) {
                        return $event->rating;
                    })
                    ->editColumn('status', function ($event) {
                        $review_status = checkPermission('review_status');
                        $status = '';
                        if ($review_status) {
                            if ($event->status == '1') {
                                $status .= ' <input type="checkbox" data-url="publishReview" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $status .= ' <input type="checkbox" data-url="publishReview" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            }
                        } else {
                            $db_status = $event->status;
                            $bg_class = 'bg-danger';
                            if ($db_status == '1') {
                                $bg_class = 'bg-success';
                            }
                            $displayStatus = displayStatus($db_status);
                            $status = '<span class="' . $bg_class . ' text-center rounded p-1 text-white">' . $displayStatus . '</span>';
                        }
                        return $status;
                    })
                    ->editColumn('review_date', function ($event) {
                        $displayDate = date('d-m-Y H:i A', strtotime($event->updated_at));
                        return $displayDate;
                    })
                    ->editColumn('action', function ($event) {
                        $review_edit = checkPermission('review_edit');
                        $review_view = checkPermission('review_view');
                        // $actions = '';
                        $actions = '<span style="white-space:nowrap;">';
                        if ($review_view) {
                            $actions .= '<a href="review_view/' . $event->id . '" class="btn btn-primary btn-sm modal_src_data" data-size="large" data-title="Review Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['user_id', 'product_name', 'rating', 'status', 'review_date', 'action'])->setRowId('id')->make(true);
            } catch (\Exception $e) {
                \Log::error("Something Went Wrong. Error: " . $e->getMessage());
                return response([
                    'draw'            => 0,
                    'recordsTotal'    => 0,
                    'recordsFiltered' => 0,
                    'data'            => [],
                    'error'           => 'Something went wrong',
                ]);
            }
        }
    }

    /**
     *   created by : Maaz Ansari
     *   Created On : 10-aug-2022
     *   Uses :  To publish or unpublish reviews 
     *   @param Request request
     *   @return Response
     */
    public function updateStatus(Request $request)
    {
        if (!checkPermission('review_status')) {
            return redirect('/webadmin/dashboard');
        }
        $msg_data = array();
        $recordData = Review::find($request->id);
        $recordData->status = $request->status;
        $recordData->save();
        if ($request->status == 1) {
            successMessage('Published', $msg_data);
        } else {
            successMessage('Unpublished', $msg_data);
        }
    }

    /**
     *   created by : Maaz Ansari
     *   Created On : 10-aug-2022
     *   Uses :  To view review  
     *   @param int $id
     *   @return Response
     */
    public function view($id)
    {
        if (!checkPermission('review_view')) {
            return redirect('/webadmin/dashboard');
        }
        $data['data'] = Review::with('user', 'product')->find($id);
        $data['product_data'] = json_decode($data['data']['product']->product_name, TRUE)['en'];
        if ($data['data']->image) {
            $data['data']->image_path = getFile($data['data']->image, 'review_image', true);
        } else {
            $data['data']->image_path = NULL;
        }
        // echo '<pre>';
        // print_r($data['data']);
        return view('backend/review/review_view', $data);
    }
}
