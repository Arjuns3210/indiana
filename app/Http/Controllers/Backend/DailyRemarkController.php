<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\DailyRemark;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DailyRemarkController extends Controller
{
    //
    public function index(){
        $data['data']['remark_add'] = checkPermission('remark_add');
        $data['data']['remark_status'] = checkPermission('remark_status');
        $data['data']['remark_edit'] = checkPermission('remark_edit');
        $data['data']['remark_delete'] = checkPermission('remark_delete');
        $data['data']['remark_view'] = checkPermission('remark_view');
        $data['roles'] = Role::all();
        $data['admins'] = Admin::all()->where('role_id',5   );
        return view('backend/daily_remarks/index',$data);
    
    }
    
    public function remarkData(Request $request)
    { 
        $role_id = session('data')['role_id'];
        $user_id = session('data')['id'];
        if ($request->ajax()) {
            try {
                $query = DailyRemark::with('admin')->orderBy('updated_at', 'desc');

                if ($role_id != 1) {
                    $query->where('status', 1);
                    $query->where('admin_id', $user_id);
                }
                
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_admin_id'] ) && !is_null($request['search']['search_admin_id'])) {
                            $query->where('admin_id', '=',$request['search']['search_admin_id']);
                        }
                        if ($request['search']['search_remark_date'] && !is_null($request['search']['search_remark_date'])) {
                            $remark_date = Carbon::parse($request['search']['search_remark_date'])->format('Y-m-d');
                            $query->where('remark_date', $remark_date);
                        }
                        $query->get();
                    })
                    ->editColumn('admin', function ($event) {
                        return $event->remark_date .' ('. $event->admin->nick_name.')';
                    })
                    ->editColumn('activity_remarks', function ($event) {
                        return '<div style="width: 170px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" >'.$event->activity_remarks .'</div>' ;
                    })
                    // ->editColumn('remark_date', function ($event) {
                    //     return $event->remark_date;
                    // })
                    ->editColumn('action', function ($event) {
                        $remark_view = checkPermission('remark_view');
                        $remark_edit = checkPermission('remark_edit');
                        $remark_delete = checkPermission('remark_delete');
                        $remark_status = checkPermission('remark_status');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($remark_view) {
                            $actions .= '<a href="remark_view/' . $event->id . '" class="btn btn-primary btn-sm modal_src_data" data-size="large" data-title="View Remark Details" title="View"><i class="fa fa-eye"></i></a>';
                            if ($remark_edit) {
                                $actions .= ' <a href="remark_edit/' . $event->id . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                            }
                            // if ($remark_delete) {
                            //     $actions .= ' <a  data-url="remark_delete/'  . $event->id . '"   class="btn btn-danger btn-sm delete-data" title="Delete"><i class="fa fa-trash"></i></a>';
                            // }
                            // if ($remark_status) {
                            //         $actions .= ' <input type="checkbox" data-url="publishRemark" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            // }else {
                            //         $actions .= ' <input type="checkbox" data-url="publishRemark" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            //     }
                            
                        }
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['admin_id', 'activity_remarks', 'remark_date','action'])->setRowId('id')->make(true);
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

    public function addRemark(Request $request)
    {
        $data['daily_remarks'] = DailyRemark::all();
        return view('backend/daily_remarks/remark_add');
    }

    public function saveRemark(Request $request)
    {
        $msg_data = array();
        
        $validationErrors = $this->validateRequest($request);

        if (count($validationErrors)) {
            \Log::error("Auth Exception: " . implode(", ", $validationErrors->all()));
            errorMessage(implode("\n", $validationErrors->all()), $msg_data);
        }
        if (isset($_GET['id'])) {
            $dailyremark = DailyRemark::find($request->id);
        } else {
            $dailyremark = new DailyRemark;
            $dailyremark->admin_id = session('data')['id'];
        }
        $dailyremark->activity_remarks = $request->activity_remarks;
        $dailyremark->remark_date = $request->remark_date;
        if (isset($_GET['id'])) {
            $dailyremark->updated_by = (session('data')['id']);
        } else {
            $dailyremark->created_by = session('data')['id'];
        }
        $dailyremark->save();
        successMessage('Data saved successfully', $msg_data);
    }
    private function validateRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'activity_remarks' => 'required',
            'remark_date' => 'required|date|',
            
        ])->errors();
    }


    public function view($id)
    {
        $data['data'] = DailyRemark::find($id);
        return view('backend/daily_remarks/remark_view', $data);
    }
    public function editRemark($id)
    {
        $data = DailyRemark::find($id);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die('Debug');
        return view('backend/daily_remarks/remark_edit', ["data" => $data]);
    }
    public function deleteremark($id)
    {
        $msg_data = array();
        $data = DailyRemark::find($id);
        $data->delete();
        successMessage('Data Deleted successfully', $msg_data);
    }
}
