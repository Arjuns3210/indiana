<?php
/*
    *	Developed by : Maaz Ansari - Mypcot Infotech 
    *	Project Name : Indiana 
    *	File Name : CategoryController.php
    *	File Path : app\Http\Controllers\Backend\CategoryController.php
    *	Created On : 18-08-2022
    *	http ://www.mypcot.com
*/

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SuperCategory;
use App\Models\Attribute;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    /**
     *   created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses :  To show category listing page
     */
    public function index()
    {
        if (!checkPermission('category')) {
            return redirect('/webadmin/dashboard');
        }
        $data['category_add'] = checkPermission('category_add');
        $data['category_edit'] = checkPermission('category_edit');
        $data['category_view'] = checkPermission('category_view');
        $data['category_status'] = checkPermission('category_status');
        return view('backend/category/index', ["data" => $data]);
    }

    /**
     *   created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses :  display dynamic data in datatable for category page
     *   @param Request request
     *   @return Response
     */
    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Category::with('super_category')->orderBy('updated_at', 'desc');
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_category_name']) && !is_null($request['search']['search_category_name'])) {
                            $query->where('category_name', 'like', "%" . $request['search']['search_category_name'] . "%");
                        }
                        $query->get();
                    })
                    ->editColumn('super_category', function ($event) {
                        return $event->super_category->super_category_name;
                    })
                    ->editColumn('category_name', function ($event) {
                        return $event->category_name;
                    })
                    ->editColumn('category_image_url', function ($event) {
                        $imageUrl = ListingImageUrl('category', $event->category_thumb_image, 'thumb');
                        return ' <img src="' . $imageUrl . '" />';
                    })
                    ->editColumn('mark_featured', function ($event) {
                        $category_edit = checkPermission('category_edit');
                        $featured = '';
                        if ($category_edit) {
                            if ($event->is_featured == '1') {
                                $featured .= ' <input type="checkbox" data-url="featuredCategory" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $featured .= ' <input type="checkbox" data-url="featuredCategory" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            }
                        } else {
                            $db_featured = $event->is_featured;
                            $bg_class = 'bg-light-danger';
                            if ($db_featured == '1') {
                                $bg_class = 'bg-light-success';
                            }
                            $displayFeaturedStatus = displayFeatured($db_featured);
                            $featured = '<span class=" badge badge-pill ' . $bg_class . ' mb-2 mr-2">' . $displayFeaturedStatus . '</span>';
                        }
                        return $featured;
                    })
                    ->editColumn('action', function ($event) {
                        $category_view = checkPermission('category_view');
                        $category_edit = checkPermission('category_edit');
                        $category_status = checkPermission('category_status');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($category_view) {
                            $actions .= '<a href="category_view/' . $event->id . '" class="btn btn-primary btn-sm modal_src_data" data-size="large" data-title="View Category Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($category_edit) {
                            $actions .= ' <a href="category_edit/' . $event->id . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        if ($category_status) {
                            if ($event->status == '1') {
                                $actions .= ' <input type="checkbox" data-url="publishCategory" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $actions .= ' <input type="checkbox" data-url="publishCategory" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            }
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['super_category', 'category_name', 'category_image_url', 'mark_featured', 'action'])->setRowId('id')->make(true);
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
     *   Created On : 17-aug-2022
     *   Uses : To load Add category page
     */
    public function add()
    {
        if (!checkPermission('category_add')) {
            return redirect('/webadmin/dashboard');
        }
        $data['attribute'] = Attribute::all();
        $data['super_category'] = SuperCategory::all();
        return view('backend/category/category_add', $data);
    }

    /**
     *   Created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses :  
     *   @param int $id
     *   @return Response
     */
    public function edit($id)
    {
        if (!checkPermission('category_edit')) {
            return redirect('/webadmin/dashboard');
        }
        $data = Category::find($id);
        $data['super_category'] = SuperCategory::all();
        $att_val = json_decode($data->attribute_ids);
        $data['attribute'] = Attribute::all();
        // print_r($data->attribute_ids);exit;
        if ($data->attribute_ids) {
            $data['attribute_arr'] = $att_val;
            // echo '<pre>';
            // print_r($data['attribute_arr']);exit;
        }

        if ($data) {
            $data->image_path = getFile($data->category_image, 'category', true);
        }
        // return $data;
        return view('backend/category/category_edit', ["data" => $data]);
    }


    /**
     *   Created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses : to save add/edit category form data 
     *   @param Request request
     *   @return Response
     */
    public function saveFormData(Request $request)
    {
        $msg_data = array();
        $msg = "";
        if (isset($_GET['id'])) {
            $validationErrors = $this->validateRequest($request);
        } else {
            $validationErrors = $this->validateNewRequest($request);
        }
        if (count($validationErrors)) {
            \Log::error("Category Validation Exception: " . implode(", ", $validationErrors->all()));
            errorMessage(implode("\n", $validationErrors->all()), $msg_data);
        }
        $isEditFlow = false;
        if (isset($_GET['id'])) {
            $isEditFlow = true;
            $response = Category::where([['category_name', strtolower($request->category_name)], ['id', '<>', $_GET['id']]])->get()->toArray();
            if (isset($response[0])) {
                errorMessage('Category Already Exist', $msg_data);
            }
            $tableObject = Category::find($_GET['id']);
            $msg = "Data Updated Successfully";
        } else {
            $tableObject = new Category;
            $response = Category::where([['category_name', strtolower($request->category_name)]])->get()->toArray();
            if (isset($response[0])) {
                errorMessage('Category Already Exist', $msg_data);
            }
            $msg = "Data Saved Successfully";
        }
        if ($isEditFlow) {
            $tableObject->updated_by = session('data')['id'];
        } else {
            $tableObject->created_by = session('data')['id'];
        }
        if (!empty($request->attribute_id)) {
            $attribute_ids = implode(',', $request->attribute_id);
            $attribute_val = "[" . $attribute_ids . "]";
        } else {
            $attribute_val = "";
        }
        $tableObject->super_category_id = $request->super_category;
        $tableObject->category_name = $request->category_name;
        $tableObject->attribute_ids = $attribute_val;
        $tableObject->save();
        $last_inserted_id = $tableObject->id;
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $actualImage = saveSingleImage($image, 'category', $last_inserted_id);
            $thumbImage = createThumbnail($image, 'category', $last_inserted_id, 'category');
            $bannerObj = Category::find($last_inserted_id);
            $bannerObj->category_image = $actualImage;
            $bannerObj->category_thumb_image = $thumbImage;
            $bannerObj->save();
        }
        successMessage($msg, $msg_data);
    }

    /**
     *   Created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses :  to load category view
     *   @param int $id
     *   @return Response
     */
    public function view($id)
    {
        if (!checkPermission('category_view')) {
            return redirect('/webadmin/dashboard');
        }
        $data = Category::with('super_category')->find($id);
        if ($data) {
            $data->image_path = getFile($data->category_image, 'category', true);
        }
        return view('backend/category/category_view', ["data" => $data]);
    }

    /**
     *   Created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses :  To publish or unpublish category records
     *   @param Request request
     *   @return Response
     */
    public function updateStatus(Request $request)
    {
        if (!checkPermission('category_status')) {
            return redirect('/webadmin/dashboard');
        }
        $msg_data = array();
        $recordData = Category::find($request->id);
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
     *   Created On : 09-Aug-2022
     *   Uses :  To Mark Featured category
     *   @param Request request
     *   @return Response
     */
    public function markFeatured(Request $request)
    {
        if (!checkPermission('category_edit')) {
            return redirect('/webadmin/dashboard');
        }
        $msg_data = array();
        $recordData = Category::find($request->id);
        $recordData->is_featured = $request->status;
        $recordData->save();
        if ($request->status == 1) {
            successMessage(__('category.marked_as_featured'), $msg_data);
        } else {
            successMessage(__('category.unmarked_as_featured'), $msg_data);
        }
    }

    /**
     *   Created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses :  category Add|Edit Form Validation part will be handle by below function
     *   @param Request request
     *   @return Response
     */
    private function validateRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'super_category' => 'required|integer',
            'category_name' => 'required|string',
            'category_image' => 'mimes:jpeg,png,jpg|max:' . config('global.SIZE.CATEGORY'),
            'attribute_id' => 'required|array'
        ])->errors();
    }

    /**
     *   Created by : Maaz Ansari
     *   Created On : 18-aug-2022
     *   Uses :  Banner Add|Edit Form Validation part will be handle by below function
     *   @param Request request
     *   @return Response
     */
    private function validateNewRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'super_category' => 'required|integer',
            'category_name' => 'required|string',
            'category_image' => 'required',
            'attribute_id' => 'required|array'
        ])->errors();
    }
}
