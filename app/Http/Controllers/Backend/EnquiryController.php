<?php

namespace App\Http\Controllers\backend;

use App\Exports\EnggAchievementExport;
use App\Exports\EnquiryExport;
use App\Exports\MisReportExport;
use App\Exports\TypistAchievementExport;
use App\Http\Controllers\Controller;
use App\Imports\EnquiryImport;
use App\Models\Admin;
use App\Models\AllocationStatus;
use App\Models\Category;
use App\Models\EngineerStatus;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;
use App\Models\Enquiry;
use App\Models\Industry;
use App\Models\Product;
use App\Models\Region;
use App\Models\DailyRemark;
use App\Models\TypistStatus;
use Carbon\Carbon;
use DateTime;
use session;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class EnquiryController extends Controller
{

    /**
     *   created by : Prachi Sarnobat
     *   Created On : 18-aug-2022
     *   Uses :  To show  listing page
     */

    public function index()
    {
        if (!checkPermission('enquiry')) {
            return redirect('/webadmin/dashboard');
        }
        $data['enquiry_view'] = checkPermission('enquiry_view');
        $data['enquiry_add'] = checkPermission('enquiry_add');
        $data['enquiry_edit'] = checkPermission('enquiry_edit');
        $data['engineer_remark'] = checkPermission('engineer_remark');
        $data['enquiry_status'] = checkPermission('enquiry_status');
        $data['enquiry_import'] = checkPermission('enquiry_import');
        $data['products'] = Product::where([['status', 1]])->get();
        $data['categories'] = Category::where([['status', 1]])->get();
        $data['regions'] = Region::where([['status', 1]])->get();
        $data['engineer_statuses'] = EngineerStatus::where([['status', 1]])->get();
        $data['typist_statuses'] = TypistStatus::where([['status', 1]])->get();
        $data['role_id'] = session('data')['role_id'];
        return view('backend/enquiry/index', ["data" => $data]);
    }

    /**
     *   created by : Prachi Sarnobat
     *   Created On : 18-aug-2022
     *   Uses :  To retrive the data
     */
    public function fetch(Request $request)
    {
        $role_id = session('data')['role_id'];
        $user_id = session('data')['id'];
        if ($request->ajax()) {
            try {
               // $query = Enquiry::with('admin', 'region');
                $query = Enquiry::select('id', 'enq_no', 'has_revisions', 'region_id', 'enq_due_date', 'revision_no', 'enq_register_date', 'enq_reminder_date', 'client_name', 'project_name', 'engineer_id', 'typist_id', 'engineer_status', 'typist_status')->with('admin', 'region');
                if ($role_id != 1) {
                    $query->where('status', 1);
                }
                if ($role_id == 2) { //for sale
                    $query->where('sales_id', $user_id);
                } elseif ($role_id == 3) { //for case incharge
                    $query->where('case_incharge_id', $user_id);
                } elseif ($role_id == 4) { // for allocator
                    $query->where('category_id', '!=', 0);
                    $query->where('enq_due_date', '!=', NULL);
                } elseif ($role_id == 5) { //for engineer
                    $query->where('engineer_id', $user_id);
                } elseif ($role_id == 6) { //for typist
                    $query->where('typist_id', $user_id);
                    $query->whereIn('engineer_status', [1, 2]);
                }
                // $query->orderBy('enq_register_date', 'desc');
                $query->orderBy('id', 'desc');
                // $query->orderBy('updated_at', 'desc');
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_enq_no']) && !is_null($request['search']['search_enq_no'])) {
                            $query->where('enq_no', 'like', "%" . $request['search']['search_enq_no'] . "%");
                            // $query->where('enq_no', $request['search']['search_enq_no']);
                        }
                        if (isset($request['search']['search_enq_register_date']) && !is_null($request['search']['search_enq_register_date'])) {
                            $estimated_date = Carbon::parse($request['search']['search_enq_register_date'])->format('Y-m-d');
                            $query->where('enq_register_date', $estimated_date);
                        }
                        if (isset($request['search']['search_enq_due_date']) && !is_null($request['search']['search_enq_due_date'])) {
                            $search_enq_due_date = Carbon::parse($request['search']['search_enq_due_date'])->format('Y-m-d');
                            $query->where('enq_due_date', $search_enq_due_date);
                        }
                        if (isset($request['search']['search_engineer_status']) && !is_null($request['search']['search_engineer_status'])) {

                            if ($request['search']['search_engineer_status'] == 'blank') {
                                $query->whereNull('engineer_status');
                            } else {
                                $query->where('engineer_status', $request['search']['search_engineer_status']);
                            }
                        }
                        if (isset($request['search']['search_typist_status']) && !is_null($request['search']['search_typist_status'])) {
                            if ($request['search']['search_typist_status'] == 'blank') {
                                $query->whereNull('typist_status');
                            } else {
                                $query->where('typist_status', $request['search']['search_typist_status']);
                            }
                        }
                        if (isset($request['search']['search_allocation_date']) && !is_null($request['search']['search_allocation_date'])) {
                            $allocation_date = Carbon::parse($request['search']['search_allocation_date'])->format('Y-m-d');
                            $query->where('allocation_date', '>=', $allocation_date);
                        }
                        if (isset($request['search']['search_client_name']) && !is_null($request['search']['search_client_name'])) {
                            $query->where('client_name', 'like', "%" . $request['search']['search_client_name'] . "%");
                        }
                        if (isset($request['search']['search_region']) && !is_null($request['search']['search_region'])) {
                            // $query->where('region_id', 'like', "%" . $request['search']['search_region'] . "%");
                            $query->where('region_id', $request['search']['search_region']);
                        }
                        if (isset($request['search']['search_product']) && !is_null($request['search']['search_product'])) {
                            // $query->where('product_id', 'like', "%" . $request['search']['search_product'] . "%");
                            $query->where('product_id', $request['search']['search_product']);
                        }
                        if (isset($request['search']['search_category']) && !is_null($request['search']['search_category'])) {
                            // $query->where('category_id', 'like', "%" . $request['search']['search_category'] . "%");
                            $query->where('category_id', $request['search']['search_category']);
                        }
                        $query->get();
                    })
                    ->editColumn('enq_no', function ($event) {
                        return $event->enq_no;
                    })
                    ->editColumn('region_name', function ($event) {
                        return $event->region->region_name;
                    })
                    ->editColumn('revision_no', function ($event) {
                        return $event->revision_no;
                    })
                    ->editColumn('enq_register_date', function ($event) {
                        return date('d-m-Y', strtotime($event->enq_register_date));
                    })
                    ->editColumn('enq_due_date', function ($event) {
                        return date('d-m-Y', strtotime($event->enq_due_date));
                    })
                    ->editColumn('client_name', function ($event) {
                        return $event->client_name;
                    })
                    ->editColumn('project_name', function ($event) {
                        return $event->project_name;
                    })
                    ->editColumn('action', function ($event) {
                        $enquiry_view = checkPermission('enquiry_view');
                        $enquiry_remark = checkPermission('enquiry_remark');
                        $enquiry_edit = checkPermission('enquiry_edit');

                        //added by Vikas to disable edit only for typist users : start
                        $role_id = session('data')['role_id'];
                        if ($role_id == 6 && !(is_null($event->typist_status)))
                            $enquiry_edit = false;
                        //added by Vikas to disable edit only for typist users : end
                        $enquiry_revision = checkPermission('enquiry_revision');
                        $transfer_engineer = checkPermission('transfer_engineer');
                        $transfer_typist = checkPermission('transfer_typist');
                        $enquiry_delete = checkPermission('enquiry_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($enquiry_view) {
                            $actions .= '<a href="enquiry_view/' . $event->id . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Enquiry Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($event->has_revisions == 0) {
                            if ($enquiry_edit) {
                                $actions .= ' <a href="enquiry_form/' . $event->id . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                            }
                            if ($enquiry_remark) {
                                $actions .= ' <a href="enquiry_remark/' . $event->id . '" class="btn btn-info btn-sm src_data" title="Engineer Remark"><i class="fa fa-plus"></i></a>';
                            }
                            if ($enquiry_revision) {
                                if ($event->typist_status == '1' || $event->typist_status == '2') { // for QTD and REV-QTD
                                    $actions .= ' <a href="enquiry_revision/' . $event->id . '" class="btn btn-warning btn-sm src_data" title="Revision"><i class="fa fa-copy"></i></a>';
                                }
                            }
                            if ($transfer_engineer) {
                                if ($event->engineer_id != 0) {
                                    $actions .= ' <a href="transfer_engineer/' . $event->id . '" class="btn btn-info btn-sm src_data" title="Transfer Engineer"><i class="fa fa-share"></i></a>';
                                }
                            }
                            if ($transfer_typist) {
                                if ($event->typist_id != 0) {
                                    $actions .= ' <a href="transfer_typist/' . $event->id . '" class="btn btn-secondary btn-sm src_data" title="Transfer Typist"><i class="ft-edit-1"></i></a>';
                                }
                            }
                        }
                        if ($enquiry_delete) {
                            //added by arjun
                            $dataUrl = '#' . $event->enq_no . ' / ' . $event->region->region_name . ' / ' . $event->revision_no;
                            $actions .= ' <a data-option="' . $dataUrl . '" data-url="enquiry_delete/' . $event->id . '" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['enq_no', 'region_name', 'enq_no', 'enq_register_date', 'enq_due_date', 'client_name', 'project_name', 'action'])->setRowId('id')->make(true);
            } catch (\Exception $e) {
                \Log::error("Something Went Wrong. Error: " . $e->getMessage());
                return response([
                    'draw' => 0,
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => 'Something went wrong',
                ]);
            }
        }
    }
    /**
     *   created by : Maaz
     *   Created On : 17-aug-2022
     *   Uses :  To view the data
     */
    public function view($id)
    {
        if (!checkPermission('enquiry_view')) {
            return redirect('/webadmin/dashboard');
        }



        $data['enquiries'] = getEnquiryData()->where('enquiries.id', $id)->first();

        $today = now();
        $enq_register_date = $data['enquiries']->enq_register_date;
        $datetime1 = new DateTime($today);
        $datetime2 = new DateTime($enq_register_date);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');
        $data['old_days'] = $days;

        // print($data['enquiries']);
        // die;

        return view('backend/enquiry/enquiry_view', $data);
    }

    /**
     *   created by : Maaz
     *   Created On : 17-aug-2022
     *   Uses :  To view the data
     */
    public function viewEmail($id)
    {
        $msg_data = array();
        if (!checkPermission('enquiry_view')) {
            return redirect('/webadmin/dashboard');
        }
        $id = Crypt::decrypt($id);

        $keyName = 'case_incharge_id';
        $role_id = session('data')['role_id'];
        $user_id = session('data')['id'];
        if ($role_id == 2) {
            $keyName = 'sales_id';
        } else if ($role_id == 5) {
            $keyName = 'engineer_id';
        } else if ($role_id == 6) {
            $keyName = 'typist_id';
        }

        $data['enquiries'] = getEnquiryData()->where('enquiries.id', $id)->first(); //getSingleEnquiryData($id);

        //no check applicable for admin and allocator
        if ($role_id != 1 || $role_id != 4) {
            if ($data['enquiries']->$keyName != $user_id) {
                //throw Data NOT access error
                return redirect('/webadmin/dashboard');
            }
        }

        $today = now();
        $enq_register_date = $data['enquiries']->enq_register_date;
        $datetime1 = new DateTime($today);
        $datetime2 = new DateTime($enq_register_date);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');
        $data['old_days'] = $days;

        // print($data['enquiries']);
        // die;

        return view('backend/enquiry/enquiry_email_view', $data);
    }


    public function enquiryForm($id)
    {
        if (!checkPermission('enquiry_add') && !checkPermission('enquiry_edit') && !checkPermission('enquiry_remark') && !checkPermission('enquiry_revision')) {
            return redirect('/webadmin/dashboard');
        }

        $data['products'] = Product::where([['status', 1]])->get();
        $data['regions'] = Region::where([['status', 1]])->get();
        $data['case_incharge'] = Admin::where([['role_id', 3], ['status', 1]])->get();
        $data['engineers'] = Admin::where([['role_id', 5], ['status', 1]])->get();
        $data['typist'] = Admin::where([['role_id', 6], ['status', 1]])->get();
        $data['engineer_status'] = EngineerStatus::where([['status', 1]])->get();
        $data['typist_status'] = TypistStatus::where([['status', 1]])->get();
        $data['allocation_status'] = AllocationStatus::where([['status', 1]])->get();
        $data['categories'] = Category::where([['status', 1]])->get();
        $data['industry'] = Industry::where([['status', 1]])->get();

        if ($id != -1) {
            $data['enq_details'] = getEnquiryData()->where('enquiries.id', $id)->first();
        }

        if (session('data')['role_id'] == 1) // for admin
        {
            $data['role'] = 'Admin';
            return view('backend/enquiry/add_enquiry', $data);
        }
        if (session('data')['role_id'] == 2) // for sale export
        {
            $data['role'] = 'Sale Export';
            return view('backend/enquiry/sale_export_enquiry_form', $data);
        }

        if (session('data')['role_id'] == 3) // for case incharge
        {
            $data['role'] = 'Case Incharge';
            return view('backend/enquiry/case_incharge_enquiry_form', $data);
        }

        if (session('data')['role_id'] == 4) // for allocation
        {
            $data['role'] = 'Allocation';
            return view('backend/enquiry/alocation_enquiry_form', $data);
        }

        if (session('data')['role_id'] == 5) //for engineer
        {
            $data['role'] = 'Engineer';
            return view('backend/enquiry/engineer_enquiry_form', $data);
        }
        if (session('data')['role_id'] == 6) // for typist
        {
            $data['role'] = 'Typist';
            return view('backend/enquiry/typist_enquiry_form', $data);
        }
    }


    public function enquiryRevision($id)
    {
        if (!checkPermission('enquiry_revision')) {
            return redirect('/webadmin/dashboard');
        }

        $data['products'] = Product::all();
        $data['regions'] = Region::all();
        $data['case_incharge'] = Admin::where('role_id', 3)->get();
        $data['engineers'] = Admin::where('role_id', 5)->get();
        $data['typist'] = Admin::where('role_id', 6)->get();
        $data['engineer_status'] = EngineerStatus::all();
        $data['typist_status'] = TypistStatus::all();
        $data['allocation_status'] = AllocationStatus::all();
        $data['categories'] = Category::all();
        $data['industry'] = Industry::all();
        $data['is_revision'] = true;

        if ($id != -1) {
            $data['enq_details'] = getEnquiryData()->where('enquiries.id', $id)->first();
            $today = Carbon::parse(now())->format('Y-m-d');
            $enq_due_date = Carbon::parse(now())->addDays(2)->format('Y-m-d');

            $data['enq_details']->enq_due_date = $enq_due_date;
            $enq_reminder_date = Carbon::parse($enq_due_date)->subDays(3)->format('Y-m-d');

            if ($enq_reminder_date < $today) {
                $enq_reminder_date = $enq_due_date;
            }
            $data['enq_details']->enq_reminder_date = $enq_reminder_date;
            $data['revision'] = $data['enq_details']->revision_no + 1;
        }

        if (session('data')['role_id'] == 1) // for admin
        {
            $data['role'] = 'Admin';
            return view('backend/enquiry/add_enquiry', $data);
        }
        if (session('data')['role_id'] == 2) // for sale export
        {
            $data['role'] = 'Sale Export';
            return view('backend/enquiry/sale_export_enquiry_form', $data);
        }

        if (session('data')['role_id'] == 3) // for case incharge
        {
            $data['role'] = 'Case Incharge';
            return view('backend/enquiry/case_incharge_enquiry_form', $data);
        }

        if (session('data')['role_id'] == 4) // for allocation
        {
            $data['role'] = 'Allocation';
            return view('backend/enquiry/alocation_enquiry_form', $data);
        }

        if (session('data')['role_id'] == 5) //for engineer
        {
            $data['role'] = 'Engineer';
            return view('backend/enquiry/engineer_enquiry_form', $data);
        }
        if (session('data')['role_id'] == 6) // for typist
        {
            $data['role'] = 'Typist';
            return view('backend/enquiry/typist_enquiry_form', $data);
        }
    }


    public function transferEngineer($id)
    {
        if (!checkPermission('transfer_engineer')) {
            return redirect('/webadmin/dashboard');
        }
        $data['enquiries'] = getEnquiryData()->where('enquiries.id', $id)->first();
        $data['engineers'] = Admin::where('role_id', 5)->get();
        return view('backend/enquiry/transfer_engineer_form', $data);
    }

    public function engineerRemark($id)
    {
        if (!checkPermission('enquiry_remark')) {
            return redirect('/webadmin/dashboard');
        }
        if ($id != -1) {
            $data['enq_details'] = getEnquiryData()->where('enquiries.id', $id)->first();
        }
        $data['user_id'] = session('data')['id'];
        $data['role_id'] = session('data')['role_id'];

        return view('backend/enquiry/engineer_enquiry_remark', $data);
    }

    public function enquiryRemark(Request $request)
    {

        $msg_data = array();
        $msg = "Remark saved Successfully";

        $validateEnquiryRemarkError = $this->validateEnquiryRemark($request);

        if (count($validateEnquiryRemarkError)) {
            \Log::error("Category Validation Exception: " . implode(", ", $validateEnquiryRemarkError->all()));
            errorMessage(implode("\n", $validateEnquiryRemarkError->all()), $msg_data);
        }
        $enqId = $request->id;
        $enquiryData = Enquiry::find($enqId);

        if (!empty($enquiryData)) {
            $enquiryData->engineer_remark = $request->editiorData;
            $enquiryData->save();
        }
        successMessage($msg, $msg_data);
    }


    //added by arjun
    public function autoData(Request $request)
    {
  
        $engineerStatusIds = DB::table('engineer_statuses')
            ->whereIn('engineer_status_name', ['RGT', 'DRP'])
            ->pluck('id')->toArray();

        $categoryIds = DB::table('categories')
            ->whereIn('category_name', ['G', 'H', 'I'])
            ->pluck('id')->toArray();

        if ($request->get('query')) {
            $output = '';
            $query = $request->get('query');
            $data = DB::table('enquiries')
                ->where('client_name', 'LIKE', "{$query}%");

            if ($request->get('client_for_mipo') == 'true') {
                $data = $data->whereNotIn('engineer_status',$engineerStatusIds)
                ->whereNotIn('category_id', $categoryIds);
            }
            $data = $data->groupBy('client_name')
                ->pluck('client_name')
                ->toArray();

            if (!empty($data)) {
                $output = '<ul class="autoData">';

                foreach ($data as $row) {
                    $output .= '<li id="clientData">' . $row . '</li>';
                }
                $output .= '</ul>';
            }
            echo $output;
        }
    }

    public function adminDelete($id)
    {
        $msg_data = array();
        $data = Enquiry::select('id', 'enq_no', 'region_id', 'product_id', 'has_revisions')->where('id', $id);
        $enq = $data->first();
        $enq_data = Enquiry::where('enq_no', $enq->enq_no)->get();

        if (count($enq_data) > 1) {
            $data1 = Enquiry::where([
                ['enq_no', $enq->enq_no],
                ['region_id', $enq->region_id],
                ['product_id', $enq->product_id],
                ['id', '!=', $id]
            ])->orderBy('created_at', 'desc')->first();

            if (!empty($data1)) {
                $data1->has_revisions = '0';
                $data1->save();
            }
        }
        $this->setStatus($id);
        $data->delete();
        successMessage('Data Deleted successfully', $msg_data);
    }
    private function setStatus($id)
    {

        $dataModal = Enquiry::find($id);
        $dataModal->status = '0';
        $dataModal->save();
    }

    public function saveTransferEngineer(Request $request)
    {
        $msg_data = array();
        $msg = "Engineer Transfered Successfully";

        $validateTransferEngineerError = $this->validateTransferEngineer($request);

        if (count($validateTransferEngineerError)) {
            \Log::error("Category Validation Exception: " . implode(", ", $validateTransferEngineerError->all()));
            errorMessage(implode("\n", $validateTransferEngineerError->all()), $msg_data);
        }

        $engg_transfer_date = Carbon::parse(now())->format('Y-m-d');
        $engg_transfer_time = Carbon::parse(now())->format('H:i:s');
        $enqId = $request->id;
        $enquiryData = Enquiry::find($enqId);
        $old_engineer_id = $enquiryData->engineer_id;
        $enquiryData->old_engineer_id = $old_engineer_id;
        $enquiryData->engineer_id = $request->engineer_id;
        $enquiryData->engg_transfer_date = $engg_transfer_date;
        $enquiryData->engg_transfer_time = $engg_transfer_time;
        $enquiryData->save();

        //send engineer transferred email notification
        $engineerData = Admin::find($request->engineer_id);
        $email = strtolower($engineerData['email']);
        $id = $enqId;

        $action_link = URL::to('/webadmin/email_enquiry_view/' . Crypt::encrypt($id));

        $emailData = EmailNotification::where([['mail_key', 'ENGINEER_TRANSFERRED'], ['user_type', 'engineer'], ['status', 1]])->first();

        $subject = $emailData['subject'] ?? '';
        $admin_name = $engineerData['admin_name'];
        $url = $action_link;
        $from_name = $emailData['from_name'] ?? '';

        $enquiryData = Enquiry::select('enq_reminder_date', 'enq_no')->find($id);
        $enq_reminder_date = $enquiryData->enq_reminder_date;
        $enq_no = '#' . $enquiryData->enq_no;

        // print_r($enq_no);exit;
        $emailData['content'] = str_replace('$$admin_name$$', $admin_name, $emailData['content'] ?? '');
        $emailData['content'] = str_replace('$$enq_no$$', $enq_no, $emailData['content']);
        $emailData['content'] = str_replace('$$enq_reminder_date$$', $enq_reminder_date, $emailData['content']);
        $emailData['content'] = str_replace('$$url$$', $url, $emailData['content']);
        $emailData['content'] = str_replace('$$from_name$$', $from_name, $emailData['content']);

        if (config('global.TRIGGER_CUSTOM_EMAIL'))
            Mail::send('backend/auth/email-forgot', ['body' => $emailData['content']], function ($message) use ($email, $subject) {
                $message->from('crm2@mypcot.com', 'Indiana Team');
                $message->to($email, 'Indiana Team')->subject($subject);
            });
        \Log::info("Emgineer transferred email triggered!");

        successMessage($msg, $msg_data);
    }

    public function transferTypist($id)
    {
        if (!checkPermission('transfer_typist')) {
            return redirect('/webadmin/dashboard');
        }
        $data['enquiries'] = getEnquiryData()->where('enquiries.id', $id)->first();
        $data['typist'] = Admin::where('role_id', 6)->get();

        return view('backend/enquiry/transfer_typist_form', $data);
    }


    public function saveTransferTypist(Request $request)
    {
        $msg_data = array();
        $msg = "Typist Transfered Successfully";

        $validateTransferTypistError = $this->validateTransferTypist($request);

        if (count($validateTransferTypistError)) {
            \Log::error("Category Validation Exception: " . implode(", ", $validateTransferTypistError->all()));
            errorMessage(implode("\n", $validateTransferTypistError->all()), $msg_data);
        }

        $typist_transfer_date = Carbon::parse(now())->format('Y-m-d');
        $typist_transfer_time = Carbon::parse(now())->format('H:i:s');
        $enqId = $request->id;
        $enquiryData = Enquiry::find($enqId);
        $old_typist_id = $enquiryData->typist_id;
        $enquiryData->old_typist_id = $old_typist_id;
        $enquiryData->typist_id = $request->typist_id;
        $enquiryData->typist_transfer_date = $typist_transfer_date;
        $enquiryData->typist_transfer_time = $typist_transfer_time;
        $enquiryData->save();

        // send typist transferred email notification
        $typistData = Admin::find($request->typist_id);
        $email = strtolower($typistData['email']);
        $id = $enqId;
        $action_link = URL::to('/webadmin/email_enquiry_view/' . Crypt::encrypt($id));

        $emailData = EmailNotification::where([['mail_key', 'TYPIST_TRANSFERRED'], ['user_type', 'typist'], ['status', 1]])->first();

        $subject = $emailData['subject'] ?? '';
        $admin_name = $typistData['admin_name'];
        $url = $action_link;
        $from_name = $emailData['from_name'] ?? '';

        $enquiryData = Enquiry::select('enq_due_date', 'engineer_status', 'enq_no')->find($id);
        $enq_due_date = $enquiryData->enq_due_date;
        $enq_no = '#' . $enquiryData->enq_no;

        $engineerStatusData = EngineerStatus::select('engineer_status_name')->find($enquiryData->engineer_status);
        $engineer_status_name = $engineerStatusData->engineer_status_name ?? '';

        $emailData['content'] = str_replace('$$admin_name$$', $admin_name, $emailData['content'] ?? '');
        $emailData['content'] = str_replace('$$enq_no$$', $enq_no, $emailData['content']);
        $emailData['content'] = str_replace('$$enq_due_date$$', $enq_due_date, $emailData['content']);
        $emailData['content'] = str_replace('$$engineer_status_name$$', $engineer_status_name, $emailData['content']);
        $emailData['content'] = str_replace('$$url$$', $url, $emailData['content']);
        $emailData['content'] = str_replace('$$from_name$$', $from_name, $emailData['content']);

        if (config('global.TRIGGER_CUSTOM_EMAIL'))
            Mail::send('backend/auth/email-forgot', ['body' => $emailData['content']], function ($message) use ($email, $subject) {
                $message->from('crm2@mypcot.com', 'Indiana Team');
                $message->to($email, 'Indiana Team')->subject($subject);
            });
        \Log::info("Typist transferred email triggered!");

        successMessage($msg, $msg_data);
    }

    /**
     *   Created by : Maaz 
     *   Created On : 17-aug-2022
     *   Uses : to save add/edit Enquiry Details form data 
     *   @param Request request
     *   @return Response
     */
    public function saveEnquiryDetails(Request $request)
    {
        $sale_can_edit = false;
        $ci_can_edit = false;
        $allocation_can_edit = false;
        $engineer_can_edit = false;
        $typist_can_edit = false;
        $role_id = session('data')['role_id'];
        $user_id = session('data')['id'];
        $msg_data = array();
        $msg = "";
        $sales_id = 0;
        $allocator_id = 0;

        if ($role_id == 2 || $role_id == 1 || isset($request->revision)) { // for sale
            $sale_can_edit = true;
        }
        if ($role_id == 3 || $role_id == 1 || isset($request->revision)) { // for case incharge
            $ci_can_edit = true;
        }

        if ($role_id == 4 || $role_id == 1 || isset($request->revision)) { // for allocation
            $allocation_can_edit = true;
        }
        if ($role_id == 5 || $role_id == 1 || isset($request->revision)) { // for engineer
            $engineer_can_edit = true;
        }
        if ($role_id == 6 || $role_id == 1) { // for typist
            $typist_can_edit = true;
        }

        if ($role_id == 2) {
            $sales_id = $user_id;
        }
        if ($role_id == 4) {
            $allocator_id = $user_id;
        }
        $validationErrors = $this->validateEnquiryDetails($request, $role_id);

        if (count($validationErrors)) {
            \Log::error("Enquiry Validation Exception: " . implode(", ", $validationErrors->all()));
            errorMessage(implode("\n", $validationErrors->all()), $msg_data);
        }
        $isEditFlow = false;
        $id = $request->id;

        if ($id != '-1') {
            $isEditFlow = true;
            $enquiryModel = Enquiry::find($id);
            $msg = "Data Updated Successfully";
        } else {
            $enquiryModel = new Enquiry();
            $msg = "Data Saved Successfully";
        }
        if ($isEditFlow) {
            $enquiryModel->updated_by = session('data')['id'];
        } else {
            $enquiryModel->created_by = session('data')['id'];
        }
        $enq_recv_date = !empty($request->enq_recv_date) ? Carbon::parse($request->enq_recv_date)->format('Y-m-d') : NULL;
        $enq_register_date = !empty($request->enq_register_date) ? Carbon::parse($request->enq_register_date)->format('Y-m-d') : NULL;
        $enq_due_date = !empty($request->enq_due_date) ? Carbon::parse($request->enq_due_date)->format('Y-m-d') : NULL;
        $enq_reminder_date = !empty($request->enq_reminder_date) ? Carbon::parse($request->enq_reminder_date)->format('Y-m-d') : NULL;
        // $estimated_date = !empty($request->estimated_date) ? Carbon::parse($request->estimated_date)->format('Y-m-d') : NULL;

        //categgory mapped date
        $category_mapped_date = NULL;
        //category_mapped_time added by arjun
        $category_mapped_time = NULL;
        if (!empty($request->category_id)) {
            if ($id != '-1') {
                $existing_category_mapped_date = $enquiryModel->category_mapped_date ?? NULL;
                //added by arjun
                $existing_category_mapped_time = $enquiryModel->category_mapped_time ?? NULL;

                if ($existing_category_mapped_date == NULL && $existing_category_mapped_time == NULL) {
                    $category_mapped_date = Carbon::parse(now())->format('Y-m-d');
                    //added by arjun
                    $category_mapped_time = Carbon::parse(now())->format('H:i:s');

                } else {
                    $category_mapped_date = $existing_category_mapped_date;
                    //added by arjun
                    $category_mapped_time = $existing_category_mapped_time;
                }
            } else {
                $category_mapped_date = Carbon::parse(now())->format('Y-m-d');
                //added by arjun
                $category_mapped_time = Carbon::parse(now())->format('H:i:s');

            }
        }

        //allocation date
        $allocation_date = NULL;
        //allocation_time added by arjun
        $allocation_time = NULL;
        if (!empty($request->engineer_id) || (!empty($request->allocation_status) && $request->allocation_status == 1)) {
            if ($id != '-1') {
                $existing_allocation_date = $enquiryModel->allocation_date ?? NULL;
                $existing_allocation_time = $enquiryModel->allocation_time ?? NULL;

                if ($existing_allocation_date == NULL && $existing_allocation_time == NULL) {
                    $allocation_date = Carbon::parse(now())->format('Y-m-d');
                    $allocation_time = Carbon::parse(now())->format('H:i:s');
                } else {
                    $allocation_date = $existing_allocation_date;
                    $allocation_time = $existing_allocation_time;
                }
            } else {
                $allocation_date = Carbon::parse(now())->format('Y-m-d');
                $allocation_time = Carbon::parse(now())->format('H:i:s');
            }
        }

        //typist completed date
        $typist_completed_date = NULL;
        //typist_completed_time added by arjun
        $typist_completed_time = NULL;
        if (!empty($request->typist_status)) {
            if ($id != '-1') {
                $existing_typist_status = $enquiryModel->typist_status ?? 0;
                $existing_typist_completed_date = $enquiryModel->typist_completed_date ?? NULL;
                $existing_typist_completed_time = $enquiryModel->typist_completed_time ?? NULL;
                if ($existing_typist_status == $request->typist_status) {
                    $typist_completed_date = $existing_typist_completed_date;
                    $typist_completed_time = $existing_typist_completed_time;
                } else {
                    $typist_completed_date = Carbon::parse(now())->format('Y-m-d');
                    $typist_completed_time = Carbon::parse(now())->format('H:i:s');
                }
            } else {
                $typist_completed_date = Carbon::parse(now())->format('Y-m-d');
                $typist_completed_time = Carbon::parse(now())->format('H:i:s');
            }
        }

        //estimated date
        $estimated_date = NULL;
        //estimated_time added by arjun
        $estimated_time = NULL;
        if (!empty($request->engineer_status) || (!empty($request->allocation_status) && $request->allocation_status == 1)) {
            if ($id != '-1') {
                $existing_engineer_status = $enquiryModel->engineer_status ?? 0;
                $existing_estimated_date = $enquiryModel->estimated_date ?? NULL;
                $existing_estimated_time = $enquiryModel->estimated_time ?? NULL;
                if ($existing_engineer_status == $request->engineer_status) {
                    $estimated_date = $existing_estimated_date;
                    $estimated_time = $existing_estimated_time;
                } else {
                    $estimated_date = Carbon::parse(now())->format('Y-m-d');
                    $estimated_time = Carbon::parse(now())->format('H:i:s');
                }
            } else {
                $estimated_date = Carbon::parse(now())->format('Y-m-d');
                $estimated_time = Carbon::parse(now())->format('H:i:s');
            }
        }

        if ($sale_can_edit) {
            $enquiryModel->enq_recv_date = $enq_recv_date;
            $enquiryModel->enq_register_date = $enq_register_date;
            $enquiryModel->enq_due_date = $enq_due_date;
            $enquiryModel->enq_reminder_date = $enq_reminder_date;
            $enquiryModel->client_name = $request->client_name;
            $enquiryModel->revision_no = $request->revision_no ?? 0;
            $enquiryModel->project_name = $request->project_name;
            $enquiryModel->product_id = $request->product_id;
            $enquiryModel->region_id = $request->region_id;
            $enquiryModel->case_incharge_id = $request->case_incharge_id;
            $enquiryModel->sales_remark = $request->sales_remark ?? NULL;
            $enquiryModel->category_id = $request->category_id ?? 0;
            $enquiryModel->category_mapped_date = $category_mapped_date;
            $enquiryModel->category_mapped_time = $category_mapped_time;

            //below added by arjun
            $enquiryModel->category_mapped_time = $category_mapped_time;

            $enquiryModel->sales_id = $sales_id;
        }
        if ($ci_can_edit) {
            $enquiryModel->enq_due_date = $enq_due_date;
            $enquiryModel->enq_reminder_date = $enq_reminder_date;
            $enquiryModel->category_id = $request->category_id ?? 0;
            $enquiryModel->industry_id = $request->industry_id ?? 0;
            $enquiryModel->actual_client = $request->actual_client ?? NULL;
            $enquiryModel->category_mapped_date = $category_mapped_date;
            //below added by arjun
            $enquiryModel->category_mapped_time = $category_mapped_time;
            $enquiryModel->case_incharge_remark = $request->case_incharge_remark ?? NULL;
        }

        if ($allocation_can_edit) {
            $enquiryModel->allocation_status = $request->allocation_status ?? '';
            $enquiryModel->engineer_id = $request->engineer_id ?? 0;
            $enquiryModel->allocation_date = $allocation_date;
            //below added by arjun
            $enquiryModel->allocation_time = $allocation_time;
            $enquiryModel->typist_id = $request->typist_id ?? 0;
            $enquiryModel->allocation_remark = $request->allocation_remark ?? NULL;
            $enquiryModel->allocator_id = $allocator_id;

            if (!empty($request->allocation_status) && $request->allocation_status == 1) {
                $enquiryModel->engineer_status = 7;
                //below line is commented by Ritesh and then updated for allocator RGT estimated_date update : Start
                //$enquiryModel->estimated_date = $estimated_date;
                $enquiryModel->estimated_date = $allocation_date;
                //below added by arjun
                $enquiryModel->estimated_time = $allocation_time;
                //below line is commented by Ritesh and then updated for allocator RGT estimated_date update : End

            }
        }

        if ($engineer_can_edit) {
            $enquiryModel->engineer_status = $request->engineer_status ?? '';
            $enquiryModel->engineer_remark = $request->editiorData ?? NULL;
            $enquiryModel->estimated_date = $estimated_date;
            $enquiryModel->estimated_time = $estimated_time;

            if ($request->is_revision) {
                $enquiryModel->engineer_status = '';
                $enquiryModel->engineer_remark = NULL;
                $enquiryModel->estimated_date = NULL;
                $enquiryModel->estimated_time = NULL;
            }
        }

        if ($typist_can_edit) {
            $enquiryModel->typist_status = $request->typist_status ?? '';
            $enquiryModel->typist_completed_date = $typist_completed_date;
            //below added by arjun
            $enquiryModel->typist_completed_time = $typist_completed_time;
            $enquiryModel->amount = $request->amount ?? 0.00;
            $enquiryModel->typist_remark = $request->typist_remark ?? NULL;
        }

        $enquiryModel->save();

        $last_inserted_id = $enquiryModel->id;
        $region_id = $enquiryModel->region_id;
        $updateEnquiryModel = Enquiry::find($last_inserted_id);
        if (isset($request->enq_no)) {
            $updateEnquiryModel->enq_no = $request->enq_no;
        } else {

            // get finacial year start and end date from webhelper function 
            $financial_year = get_finacial_year_range();

            //get max enq_no from db as per region and date
            $maxEnqNo = get_max_enq_no($request->region_id, $financial_year);
            $newEnqNo = $maxEnqNo + 1;
            $updateEnquiryModel->enq_no = getFormatid($newEnqNo);
        }
        if ($request->is_revision) {
            $this->hasRevisions($request->lastId);
        }
        $updateEnquiryModel->save();

        $id = $updateEnquiryModel->id;

        // print_r($id);exit;

        //email notification section START

        if ($sale_can_edit) {
            //trigger email to case incharge for mapped enquiry
            $caseInchargeData = Admin::find($request->case_incharge_id);

            $email = strtolower($caseInchargeData['email']);

            $action_link = URL::to('/webadmin/email_enquiry_view/' . Crypt::encrypt($id));

            // print_r($action_link);exit;
            if (!empty($request->category_id)) {
                $emailData = EmailNotification::where([['mail_key', 'CASEINCHARGE_MAPPED'], ['user_type', 'case_incharge'], ['status', 1]])->first();
                $categoryData = Category::select('category_name')->find($request->category_id);

                $enquiryData = Enquiry::select('enq_no')->find($id);
                // print_r($enquiryData);exit;
                $enq_no = '#' . $enquiryData['enq_no'];

                $subject = $emailData['subject'] ?? '';
                $admin_name = $caseInchargeData['admin_name'];
                $url = $action_link;
                $from_name = $emailData['from_name'] ?? '';

                $emailData['content'] = str_replace('$$admin_name$$', $admin_name, $emailData['content'] ?? '');
                $emailData['content'] = str_replace('$$enq_no$$', $enq_no, $emailData['content']);
                $emailData['content'] = str_replace('$$category_name$$', $categoryData->category_name, $emailData['content']);
                $emailData['content'] = str_replace('$$url$$', $url, $emailData['content']);
                $emailData['content'] = str_replace('$$from_name$$', $from_name, $emailData['content']);
            } else {
                $emailData = EmailNotification::where([['mail_key', 'CASEINCHARGE_MAPPED_CATEGORY_MISSING'], ['user_type', 'case_incharge'], ['status', 1]])->first();
                // print_r($emailData['subject']);exit;
                $subject = $emailData['subject'] ?? '';
                $admin_name = $caseInchargeData['admin_name'];
                $url = $action_link;
                $from_name = $emailData['from_name'] ?? '';
                $enquiryData = Enquiry::select('enq_no')->find($id);
                $enq_no = '#' . $enquiryData->enq_no;

                $emailData['content'] = str_replace('$$admin_name$$', $admin_name, $emailData['content'] ?? '');
                $emailData['content'] = str_replace('$$enq_no$$', $enq_no, $emailData['content']);
                $emailData['content'] = str_replace('$$url$$', $url, $emailData['content']);
                $emailData['content'] = str_replace('$$from_name$$', $from_name, $emailData['content']);
            }

            // print_r($subject);exit;
            if (config('global.TRIGGER_CUSTOM_EMAIL'))
                Mail::send('backend/auth/email-forgot', ['body' => $emailData['content']], function ($message) use ($email, $subject) {
                    $message->from('crm2@mypcot.com', 'Indiana Team');
                    $message->to($email, 'Indiana Team')->subject($subject);
                });
            \Log::info("Case incharge mapped email triggered!");
        }
        if ($allocation_can_edit) {

            // trigger email notification to engineer for mapped enquiry
            if (!empty($request->engineer_id)) {
                $engineerData = Admin::find($request->engineer_id);

                $email = strtolower($engineerData['email']);

                $action_link = URL::to('/webadmin/email_enquiry_view/' . Crypt::encrypt($id));

                $emailData = EmailNotification::where([['mail_key', 'ENGINEER_MAPPED'], ['user_type', 'engineer'], ['status', 1]])->first();

                $subject = $emailData['subject'] ?? '';
                $admin_name = $engineerData['admin_name'];
                $url = $action_link;
                $from_name = $emailData['from_name'] ?? '';

                $enquiryData = Enquiry::select('enq_reminder_date', 'enq_no')->find($id);
                $enq_reminder_date = $enquiryData->enq_reminder_date;
                $enq_no = '#' . $enquiryData->enq_no;

                $emailData['content'] = str_replace('$$admin_name$$', $admin_name, $emailData['content'] ?? '');
                $emailData['content'] = str_replace('$$enq_no$$', $enq_no, $emailData['content']);
                $emailData['content'] = str_replace('$$enq_reminder_date$$', $enq_reminder_date, $emailData['content']);
                $emailData['content'] = str_replace('$$url$$', $url, $emailData['content']);
                $emailData['content'] = str_replace('$$from_name$$', $from_name, $emailData['content']);

                if (config('global.TRIGGER_CUSTOM_EMAIL'))
                    Mail::send('backend/auth/email-forgot', ['body' => $emailData['content']], function ($message) use ($email, $subject) {
                        $message->from('crm2@mypcot.com', 'Indiana Team');
                        $message->to($email, 'Indiana Team')->subject($subject);
                    });
                \Log::info("Emgineer mapped email triggered!");
            }

            // trigger email notification to typist for mapped enquiry
            if (!empty($request->typist_id) && isset($request->engineer_status)) {
                $typistData = Admin::find($request->typist_id);

                $email = strtolower($typistData['email']);

                $action_link = URL::to('/webadmin/email_enquiry_view/' . Crypt::encrypt($id));

                $emailData = EmailNotification::where([['mail_key', 'TYPIST_MAPPED'], ['user_type', 'typist'], ['status', 1]])->first();

                $subject = $emailData['subject'] ?? '';
                $admin_name = $typistData['admin_name'];
                $url = $action_link;
                $from_name = $emailData['from_name'] ?? '';

                $enquiryData = Enquiry::select('enq_due_date', 'engineer_status', 'enq_no')->find($id);
                $enq_due_date = $enquiryData->enq_due_date;
                $enq_no = '#' . $enquiryData->enq_no;

                $engineerStatusData = EngineerStatus::select('engineer_status_name')->find($enquiryData->engineer_status);
                $engineer_status_name = $engineerStatusData->engineer_status_name ?? '';

                $emailData['content'] = str_replace('$$admin_name$$', $admin_name, $emailData['content'] ?? '');
                $emailData['content'] = str_replace('$$enq_no$$', $enq_no, $emailData['content']);
                $emailData['content'] = str_replace('$$enq_due_date$$', $enq_due_date, $emailData['content']);
                $emailData['content'] = str_replace('$$engineer_status_name$$', $engineer_status_name, $emailData['content']);
                $emailData['content'] = str_replace('$$url$$', $url, $emailData['content']);
                $emailData['content'] = str_replace('$$from_name$$', $from_name, $emailData['content']);

                if (config('global.TRIGGER_CUSTOM_EMAIL'))
                    Mail::send('backend/auth/email-forgot', ['body' => $emailData['content']], function ($message) use ($email, $subject) {
                        $message->from('crm2@mypcot.com', 'Indiana Team');
                        $message->to($email, 'Indiana Team')->subject($subject);
                    });
                \Log::info("Typist mapped email triggered!");
            }
        }

        if ($typist_can_edit) {
            // send email notification of updated typist status to Sale export, Case Incharge, Allocation, Engineer and Typist
            if (!empty($id) && !empty($request->typist_status)) {
                $typistStatusData = TypistStatus::select('typist_status_name')->find($request->typist_status);
                $typist_status_name = $typistStatusData->typist_status_name;
                $enquiryData = Enquiry::select('case_incharge_id', 'engineer_id')->find($id)->toArray();
                $enqDueDatedata = Enquiry::select('enq_due_date', 'enq_no')->find($id);
                foreach ($enquiryData as $value) {
                    $adminsData = Admin::find($value);
                    $email = strtolower($adminsData['email']);

                    $action_link = URL::to('/webadmin/email_enquiry_view/' . Crypt::encrypt($id));

                    $emailData = EmailNotification::where([['mail_key', 'TYPIST_STATUS_UPDATE'], ['user_type', 'all'], ['status', 1]])->first();

                    $subject = $emailData['subject'] ?? '';
                    $enq_due_date = $enqDueDatedata->enq_due_date;
                    $enq_no = '#' . $enqDueDatedata->enq_no;
                    $url = $action_link;
                    $from_name = $emailData['from_name'] ?? '';

                    $emailData['content'] = str_replace('$$enq_no$$', $enq_no, $emailData['content'] ?? '');
                    $emailData['content'] = str_replace('$$enq_due_date$$', $enq_due_date, $emailData['content']);
                    $emailData['content'] = str_replace('$$typist_status_name$$', $typist_status_name, $emailData['content']);
                    $emailData['content'] = str_replace('$$url$$', $url, $emailData['content']);
                    $emailData['content'] = str_replace('$$from_name$$', $from_name, $emailData['content']);

                    if (config('global.TRIGGER_CUSTOM_EMAIL'))
                        Mail::send('backend/auth/email-forgot', ['body' => $emailData['content']], function ($message) use ($email, $subject) {
                            $message->from('crm2@mypcot.com', 'Indiana Team');
                            $message->to($email, 'Indiana Team')->subject($subject);
                        });
                    \Log::info("Typist Status updated email triggered!");
                }
            }
        }


        successMessage($msg, $msg_data);
    }

    private function hasRevisions($id)
    {
        $dataModal = Enquiry::find($id);
        $dataModal->has_revisions = '1';
        $dataModal->save();
    }
    private function validateEnquiryDetails(Request $request, $role_id)
    {

        switch ($role_id) {
            case 1: //for admin
                return \Validator::make(
                    $request->all(),
                    [
                        'enq_recv_date' => 'required',
                        'enq_register_date' => 'required',
                        'enq_due_date' => 'required',
                        'enq_reminder_date' => 'required',
                        'client_name' => 'required',
                        'project_name' => 'required',
                        'product_id' => 'required',
                        'region_id' => 'required',
                        'case_incharge_id' => 'required',
                        'category_id' => 'required',
                        'engineer_id' => ($request->allocation_status != '1') ? 'required' : '',
                        'typist_id' => ($request->allocation_status != '1') ? 'required' : '',
                        'engineer_status' => ($request->allocation_status != '1') ? 'required' : '',
                        // 'estimated_date' => 'required',
                        'typist_status' => ($request->allocation_status != '1') ? 'required' : '',
                        'amount' => ($request->allocation_status != '1') ? 'required' : '',
                    ],
                    [
                        'enq_recv_date.required' => 'Received date is require',
                        'enq_register_date.required' => 'Register date is require',
                        'enq_due_date.required' => 'Due date is require',
                        'enq_reminder_date.required' => 'Reminder date is require',
                        'product_id.required' => 'Product is require',
                        'region_id.required' => 'Region is require',
                        'case_incharge_id.required' => 'Case incharge is require',
                        'category_id.required' => 'Category is require',
                        'engineer_id.required' => 'Engineer is require',
                        'typist_id.required' => 'Typist is require',
                        'engineer_status.required' => 'Engineer Status is require',
                        // 'estimated_date.required' => 'Estimated date is require',
                        'typist_status.required' => 'Typist Status is require',
                        'amount.required' => 'Amount is require',

                    ]
                )->errors();
                break;

            case 2: // for sale export
                return \Validator::make(
                    $request->all(),
                    [
                        'enq_recv_date' => 'required',
                        'enq_register_date' => 'required',
                        // 'enq_due_date' => 'required',
                        // 'enq_reminder_date' => 'required',
                        'client_name' => 'required',
                        'project_name' => 'required',
                        'product_id' => 'required',
                        'region_id' => 'required',
                        'case_incharge_id' => 'required',
                    ],
                    [
                        'enq_recv_date.required' => 'Received date is require',
                        'enq_register_date.required' => 'Register date is require',
                        // 'enq_due_date.required' => 'Due date is require',
                        // 'enq_reminder_date.required' => 'Reminder date is require',
                        'product_id.required' => 'Product is require',
                        'region_id.required' => 'Region is require',
                        'case_incharge_id.required' => 'Case incharge is require',

                    ]
                )->errors();
                break;

            case 3: //for case incharge
                return \Validator::make(
                    $request->all(),
                    [
                        'category_id' => 'required',
                    ],
                    [
                        'category_id.required' => 'Category is require',

                    ]
                )->errors();
                break;

            case 4: // for allocation
                return \Validator::make(
                    $request->all(),
                    [
                        'engineer_id' => ($request->allocation_status != '1') ? 'required' : '',
                        'typist_id' => ($request->allocation_status != '1') ? 'required' : '',
                    ],
                    [
                        'engineer_id.required' => 'Engineer is require',
                        'typist_id.required' => 'Typist is require',

                    ]
                )->errors();
                break;

            case 5: // for engineer
                return \Validator::make(
                    $request->all(),
                    [
                        'engineer_status' => 'required',
                        'editiorData' => 'required',
                        // 'estimated_date' => 'required',
                    ],
                    [
                        'engineer_status.required' => 'Engineer Status is require',
                        'editiorData.required' => 'Engineer Remark is require',
                        // 'estimated_date.required' => 'Estimated date is require',

                    ]
                )->errors();
                break;

            case 6: //for typist
                return \Validator::make(
                    $request->all(),
                    [
                        'engineer_id.required' => 'Engineer is require',
                        'typist_id.required' => 'Typist is require',
                    ],
                    [
                        'engineer_id.required' => 'Engineer is require',
                        'typist_id.required' => 'Typist is require',

                    ]
                )->errors();
                break;

            default:
                # code...
                break;
        }
    }


    /**
     * Created By :Maaz Ansari
     * Created On : 23 aug 2022
     * Uses : This will load mis report form.
     */
    public function misReportForm()
    {
        $data['typist_status'] = TypistStatus::all();
        $data['engineer_status'] = EngineerStatus::all();
        return view('backend/reports/mis_report_form', $data);
    }



    /**
     * Created By :Maaz Ansari
     * Created On : 23 aug 2022
     * Uses : This will load data report form.
     */
    public function dataReportForm()
    {
        $data['role_id'] = session::get('data')['role_id'];
        $data['regions'] = Region::all();
        $data['typist_status'] = TypistStatus::all();
        $data['engineer_status'] = EngineerStatus::all();
        return view('backend/reports/data_report_form', $data);
    }

    /**
     * Created By :Maaz Ansari
     * Created On : 23 aug 2022
     * Uses : This will load Engineer Achievement Report form.
     */
    public function engineerAchievementReportForm()
    {
        $data['categories'] = Category::all();
        $data['engineers'] = Admin::where([['role_id', 5]])->get();
        $data['engineer_status'] = EngineerStatus::all();
        return view('backend/reports/engineer_achievement_report_form', $data);
    }

    /**
     * Created By :Maaz Ansari
     * Created On : 23 aug 2022
     * Uses : This will load Typist Achievement Report form.
     */
    public function typistAchievementReportForm()
    {
        $data['categories'] = Category::all();
        $data['typist'] = Admin::where([['role_id', 6]])->get();
        $data['typist_status'] = TypistStatus::all();
        return view('backend/reports/typist_achievement_report_form', $data);
    }

    // generate mis report
    public function generateMISReport(Request $request)
    {

        ini_set('memory_limit', '512M');
        $role_id = session('data')['role_id'];
        $msg_data = array();
        $msg = "";
        $misReportData = array();
        $validationErrors = $this->validateReport($request, $role_id, 'mis');

        if (count($validationErrors)) {
            \Log::error("Export Mis Report Validation Exception: " . implode(", ", $validationErrors->all()));
            // errorMessage(implode("\n", $validationErrors->all()), $msg_data);
            return redirect()->route('mis_report')->with('status', implode("\n", $validationErrors->all()));
        }


        $misReportData['mis_date'] = $request->mis_date ? Carbon::createFromFormat('d/m/Y', trim($request->mis_date))->format('Y-m-d') : Carbon::parse(now())->format('Y-m-d');
        $misReportData['mis_date_to_display'] = $request->mis_date ? Carbon::createFromFormat('d/m/Y', trim($request->mis_date))->format('d - M - Y') : Carbon::parse(now())->format('d - M - Y');

        $misReportData['pending_for_categorization_from_case_incharge'] = Enquiry::where([['enq_register_date', $misReportData['mis_date']], ['status', 1]])
            // ->whereColumn('enq_register_date', '!=', 'category_mapped_date')
            ->where(function ($query) use ($misReportData) { // change as per client request
                $query->where('category_id', 0)
                    ->orWhere('category_mapped_date', '>', $misReportData['mis_date']);
            })
            ->count();
        $misReportData['regretted_ghi'] = Enquiry::where([['enq_register_date', $misReportData['mis_date']], ['status', 1]])
            ->whereColumn('enq_register_date', 'category_mapped_date')
            ->whereIn('category_id', [7, 8, 9])
            ->count();
        $misReportData['allocated_to_estimators_on_the_day_itself'] = Enquiry::where([['enq_register_date', $misReportData['mis_date']], ['allocation_status', '!=', 1], ['status', 1]])
            ->whereColumn('enq_register_date', 'allocation_date')
            // ->whereNull('allocation_status')
            ->count();
        $misReportData['awaiting_allocation_to_estimators_after_categorization'] = Enquiry::where([['enq_register_date', $misReportData['mis_date']], ['category_mapped_date', $misReportData['mis_date']], ['status', 1]])
            // ->whereColumn([['enq_register_date', 'category_mapped_date'], ['enq_register_date', '!=', 'allocation_date']])
            ->where([['engineer_id', 0]])
            ->whereIn('category_id', [1, 2, 3, 4, 5, 6])
            ->count();
        $misReportData['total'] = $misReportData['pending_for_categorization_from_case_incharge'] +
            $misReportData['regretted_ghi'] +
            $misReportData['allocated_to_estimators_on_the_day_itself'] +
            $misReportData['awaiting_allocation_to_estimators_after_categorization'];


        $financial_year = get_finacial_year_range($misReportData['mis_date']);
        $financial_year_start_date = Carbon::createFromFormat('d/m/Y', trim($financial_year['start_date']))->format('Y-m-d');
        $mis_date_minus_one = Carbon::parse($misReportData['mis_date'])->subDays(1)->format('Y-m-d');
        $misReportData['mis_date_minus_one'] = $mis_date_minus_one;
        $misReportData['categorization_pending_from_fy'] = Enquiry::where([['enq_register_date', '>=', $financial_year_start_date], ['enq_register_date', '<=', $mis_date_minus_one], ['status', 1]])
            // ->whereColumn('enq_register_date', '!=', 'category_mapped_date')
            // ->where('category_mapped_date', '>', $mis_date_minus_one)
            ->where([['category_id', 0]])
            ->whereNull('allocation_status')
            ->whereNull('allocation_date')
            ->count();
        $misReportData['regretted_ghi_from_fy'] = Enquiry::where([['enq_register_date', '>=', $financial_year_start_date], ['enq_register_date', '<=', $mis_date_minus_one], ['status', 1]])
            // ->whereColumn('enq_register_date', 'category_mapped_date')
            // ->where([['engineer_id', 0]])
            ->whereIn('category_id', [7, 8, 9])
            // ->where(function ($query) { // change as per client request
            //     $query->whereNotIn('allocation_status', [1])
            //         ->orwhereNull('allocation_status');
            // })
            ->whereNull('allocation_status')
            ->whereNull('allocation_date')
            ->count();
        $misReportData['dropped_from_fy'] = Enquiry::where([['enq_register_date', '>=', $financial_year_start_date], ['enq_register_date', '<=', $mis_date_minus_one], ['status', 1]])
            // ->whereColumn('enq_register_date', 'category_mapped_date')
            ->where([['engineer_id', '!=', 0], ['estimated_date', $misReportData['mis_date']]])
            ->whereIn('engineer_status', [8])
            ->count();
        $misReportData['allocated_from_previous_day_backlog'] = Enquiry::where([['enq_register_date', '>=', $financial_year_start_date], ['enq_register_date', '<=', $mis_date_minus_one], ['status', 1]])
            // ->whereColumn('enq_register_date', 'allocation_date')
            ->where('allocation_date', $misReportData['mis_date'])
            ->where(function ($query) { // change as per client request
                $query->whereNotIn('engineer_status', [2, 6, 7, 11])
                    ->orwhereNull('engineer_status');
            })
            ->count();
        $misReportData['not_yet_allocated'] = Enquiry::where([['enq_register_date', '>=', $financial_year_start_date], ['enq_register_date', '<=', $mis_date_minus_one], ['status', 1]])
            // ->whereColumn([['enq_register_date', 'category_mapped_date'], ['enq_register_date', '!=', 'allocation_date']])
            // ->where([['engineer_id', 0]])
            // ->whereIn('category_id', [1, 2, 3, 4, 5, 6])
            ->where([['category_id', 0]])
            ->whereNull('allocation_date')
            ->whereNull('allocation_status')
            ->count();


        $misReportData['previous_day_backlog_pending_for_allocation'] = Enquiry::where([['enq_register_date', '>=', $financial_year_start_date], ['enq_register_date', '<=', $mis_date_minus_one], ['status', 1]])
            // ->where([['engineer_id', 0]])
            ->whereIn('category_id', [1, 2, 3, 4, 5, 6])
            // ->where(function ($query) { // change as per client request
            //     $query->whereNotIn('allocation_status', [1])
            //         ->orwhereNull('allocation_status');
            // })
            ->whereNull('allocation_status')
            ->whereNull('allocation_date')
            // ->whereNotIn('allocation_status', [1])
            ->count();
        // $misReportData['previous_day_backlog_pending_for_allocation'] = $misReportData['categorization_pending_from_fy'] +
        //     $misReportData['regretted_ghi_from_fy'] +
        //     $misReportData['dropped_from_fy'] +
        //     $misReportData['allocated_from_previous_day_backlog'] +
        //     $misReportData['not_yet_allocated'];



        $misReportData['not_categorized_total'] = $misReportData['pending_for_categorization_from_case_incharge'] + $misReportData['categorization_pending_from_fy'];
        $misReportData['directly_regretted_total'] = $misReportData['regretted_ghi'] + $misReportData['regretted_ghi_from_fy'];
        $misReportData['dropped_total'] = $misReportData['dropped_from_fy'];
        $misReportData['pending_for_estimation_total'] = $misReportData['allocated_to_estimators_on_the_day_itself'] + $misReportData['allocated_from_previous_day_backlog'];
        $misReportData['not_allocated_total'] = $misReportData['awaiting_allocation_to_estimators_after_categorization'] + $misReportData['not_yet_allocated'];


        // $misReportData['estimator_data'] = Admin::where('role_id', 5)
        //     ->selectRaw(
        //         'count(enq_register_date >=' . $financial_year_start_date . '
        //                     AND enq_register_date <=' . $misReportData["mis_date"] . '
        //                     AND estimated_date > allocation_date
        //                     OR allocation_date = "NULL") as t
        //                   '
        //     )
        //     ->selectRaw(
        //         'count(enq_register_date >=' . $financial_year_start_date . '
        //                     AND enq_register_date <=' . $misReportData["mis_date"] . '
        //                     AND enq_register_date = allocation_date) as u
        //                   '
        //     )
        //     ->leftjoin('enquiries', 'admins.id', '=', 'enquiries.engineer_id')
        //     ->get()->toArray();


        // $previous_day_inquiry_pending_for_estimation = Admin::where([['role_id', 5], ['enq_register_date', '>=', $financial_year_start_date], ['enq_register_date', '<=', $mis_date_minus_one], ['enquiries.status', 1]])->groupBy('nick_name')
        //     ->whereColumn('estimated_date', '>', 'allocation_date')
        //     ->orWhereNull('estimated_date')
        //     // ->orWhere('estimated_date', '')
        //     ->selectRaw('count(enquiries.id) as count , admins.nick_name')
        //     ->leftjoin('enquiries', 'admins.id', '=', 'enquiries.engineer_id')
        //     ->pluck('count', 'nick_name');


        $previous_day_inquiry_pending_for_estimation_q1 = Enquiry::where([['enq_register_date', '>=', $financial_year_start_date], ['enq_register_date', '<=', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereNotNull('nick_name')
            ->where([['engineer_id', '!=', 0], ['allocation_date', '<', $misReportData['mis_date']]])
            ->whereIn('category_id', [1, 2, 3, 4, 5, 6])
            // ->whereNotIn('engineer_status', [1, 2, 6, 7, 8, 9, 10, 11])
            ->where(function ($query) { // change as per client request
                $query->whereIn('engineer_status', [3, 4, 5, 12, 14])
                    ->orWhereNull('engineer_status');
            })
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->orderBy('nick_name', 'asc')
            ->pluck('count', 'nick_name');
        // ->toSql();
        // print_r($previous_day_inquiry_pending_for_estimation_q1);
        // die;
        $admin = Admin::where([['role_id', 5], ['status', 1]])->selectRaw('0, nick_name')
            ->orderBy('nick_name', 'asc')
            ->pluck('0', 'nick_name');
        $misReportData['admin'] = $admin;


        $misReportData['previous_day_inquiry_pending_for_estimation'] = $previous_day_inquiry_pending_for_estimation_q1->union($admin)->toArray();
        ksort($misReportData['previous_day_inquiry_pending_for_estimation']);


        // print_r($misReportData['previous_day_inquiry_pending_for_estimation']);
        // die;

        $allocation_q1 = Enquiry::where([['role_id', 5], ['allocation_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereNotNull('nick_name')
            ->where(function ($query) { // change as per client request
                $query->whereNotIn('engineer_status', [6, 2]) // needs to add MIPO IN future
                    ->orWhereNull('engineer_status');
            })
            // ->WhereNull('engineer_status')
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();


        $misReportData['allocation'] = $allocation_q1->union($admin)->toArray();
        ksort($misReportData['allocation']);


        $transfer_from_the_estimator_q1 = Enquiry::where([['role_id', 5], ['engg_transfer_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereNotNull('nick_name')
            ->where('engineer_status', NULL)
            ->where('allocation_date', $misReportData['mis_date'])
            ->whereColumn([['admins.id', '!=', 'enquiries.old_engineer_id']])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');

        $misReportData['transfer_from_the_estimator'] = $transfer_from_the_estimator_q1->union($admin)->toArray();
        ksort($misReportData['transfer_from_the_estimator']);


        $transfer_to_the_estimator_q1 = Enquiry::where([['role_id', 5], ['engg_transfer_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereNotNull('nick_name')
            ->where('engineer_status', NULL)
            ->where('allocation_date', $misReportData['mis_date'])
            ->whereColumn([['admins.id', '!=', 'enquiries.engineer_id']])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.old_engineer_id')
            ->pluck('count', 'nick_name');

        $misReportData['transfer_to_the_estimator'] = $transfer_to_the_estimator_q1->union($admin)->toArray();
        ksort($misReportData['transfer_to_the_estimator']);


        $estimated_and_sent_to_typist_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            // ->whereNotIn('engineer_status', [7, 8])
            // ->whereNotNull('engineer_status')
            ->whereIn('engineer_status', [1])
            ->whereNotNull('nick_name')
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');

        $misReportData['estimated_and_sent_to_typist'] = $estimated_and_sent_to_typist_q1->union($admin)->toArray();
        ksort($misReportData['estimated_and_sent_to_typist']);
        // ->toSql();

        $estimated_and_sent_to_typist_p1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [1])
            ->whereIn('product_id', [1])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('products', 'products.id', '=', 'enquiries.product_id')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');

        $misReportData['estimated_and_sent_to_typist_p1'] = $estimated_and_sent_to_typist_p1->union($admin)->toArray();
        ksort($misReportData['estimated_and_sent_to_typist_p1']);
        // ->toSql();

        $estimated_and_sent_to_typist_p2 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [1])
            ->whereIn('product_id', [2])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('products', 'products.id', '=', 'enquiries.product_id')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');

        $misReportData['estimated_and_sent_to_typist_p2'] = $estimated_and_sent_to_typist_p2->union($admin)->toArray();
        ksort($misReportData['estimated_and_sent_to_typist_p2']);
        // ->toSql();

        $estimated_and_sent_to_typist_p3 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [1])
            ->whereIn('product_id', [3])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('products', 'products.id', '=', 'enquiries.product_id')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');

        $misReportData['estimated_and_sent_to_typist_p3'] = $estimated_and_sent_to_typist_p3->union($admin)->toArray();
        ksort($misReportData['estimated_and_sent_to_typist_p3']);
        // ->toSql();

        $estimated_and_sent_to_typist_p4 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [1])
            ->whereIn('product_id', [4])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('products', 'products.id', '=', 'enquiries.product_id')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');

        $misReportData['estimated_and_sent_to_typist_p4'] = $estimated_and_sent_to_typist_p4->union($admin)->toArray();
        ksort($misReportData['estimated_and_sent_to_typist_p4']);
        // ->toSql();

        $estimated_and_sent_to_typist_p5 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [1])
            ->whereIn('product_id', [5])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('products', 'products.id', '=', 'enquiries.product_id')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');

        $misReportData['estimated_and_sent_to_typist_p5'] = $estimated_and_sent_to_typist_p5->union($admin)->toArray();
        ksort($misReportData['estimated_and_sent_to_typist_p5']);
        // ->toSql();

        $estimated_and_sent_to_typist_p6 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [1])
            ->whereIn('product_id', [6])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('products', 'products.id', '=', 'enquiries.product_id')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');

        $misReportData['estimated_and_sent_to_typist_p6'] = $estimated_and_sent_to_typist_p6->union($admin)->toArray();
        ksort($misReportData['estimated_and_sent_to_typist_p6']);
        // ->toSql();

        $estimated_and_sent_to_typist_p7 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [1])
            ->whereIn('product_id', [7])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('products', 'products.id', '=', 'enquiries.product_id')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');

        $misReportData['estimated_and_sent_to_typist_p7'] = $estimated_and_sent_to_typist_p7->union($admin)->toArray();
        ksort($misReportData['estimated_and_sent_to_typist_p7']);
        // ->toSql();

        $estimated_and_sent_to_typist_p8 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [1])
            ->whereIn('product_id', [8])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('products', 'products.id', '=', 'enquiries.product_id')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');

        $misReportData['estimated_and_sent_to_typist_p8'] = $estimated_and_sent_to_typist_p8->union($admin)->toArray();
        ksort($misReportData['estimated_and_sent_to_typist_p8']);
        // ->toSql();

        $estimated_and_sent_to_typist_p9 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [1])
            ->whereIn('product_id', [9])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('products', 'products.id', '=', 'enquiries.product_id')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');

        $misReportData['estimated_and_sent_to_typist_p9'] = $estimated_and_sent_to_typist_p9->union($admin)->toArray();
        ksort($misReportData['estimated_and_sent_to_typist_p9']);
        // ->toSql();

        $dropped_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [8])
            ->whereNotNull('nick_name')
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['dropped'] = $dropped_q1->union($admin)->toArray();
        ksort($misReportData['dropped']);

        $regretted_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [7])
            ->whereNotNull('nick_name')
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();
        $misReportData['regretted'] = $regretted_q1->union($admin)->toArray();
        ksort($misReportData['regretted']);

        $new_additions_into_revision_pool_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [2])
            ->whereNotNull('nick_name')
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['new_additions_into_revision_pool'] = $new_additions_into_revision_pool_q1->union($admin)->toArray();
        ksort($misReportData['new_additions_into_revision_pool']);


        $revised_and_sent_to_typist_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [2])
            // ->whereIn('engineer_status', [10])
            ->whereNotNull('nick_name')
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['revised_and_sent_to_typist'] = $revised_and_sent_to_typist_q1->union($admin)->toArray();
        ksort($misReportData['revised_and_sent_to_typist']);


        $previous_day_estimates_pending_for_typing_q1 = Enquiry::where([['role_id', 5], ['estimated_date', '>=', $financial_year_start_date], ['estimated_date', '<=', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereNull('typist_status')
            ->whereIn('engineer_status', [1, 2])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['previous_day_estimates_pending_for_typing'] = $previous_day_estimates_pending_for_typing_q1->union($admin)->toArray();
        ksort($misReportData['previous_day_estimates_pending_for_typing']);

        $estimated_and_sent_to_typist_single_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [1, 2])
            // ->whereNull('typist_status')
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['estimated_and_sent_to_typist_single'] = $estimated_and_sent_to_typist_single_q1->union($admin)->toArray();
        ksort($misReportData['estimated_and_sent_to_typist_single']);

        $sent_to_client_q1 = Enquiry::where([['role_id', 5], ['typist_completed_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            // ->whereColumn('estimated_date', 'typist_completed_date')
            // ->whereIn('engineer_status', [9])
            ->whereIn('typist_status', [1, 2])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['sent_to_client'] = $sent_to_client_q1->union($admin)->toArray();
        ksort($misReportData['sent_to_client']);


        $pending_not_started_yet_q1 = Enquiry::where([['role_id', 5], ['enq_register_date', '>=', $financial_year_start_date], ['enq_register_date', '<=', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            // ->whereNotNull('engineer_id')
            ->whereNull('engineer_status')
            // ->orwhereNull('estimated_date')
            // ->orWhere('estimated_date', '>', $misReportData['mis_date'])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['pending_not_started_yet'] = $pending_not_started_yet_q1->union($admin)->toArray();
        ksort($misReportData['pending_not_started_yet']);


        $pending_work_started_but_not_complete_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [4, 12])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['pending_work_started_but_not_complete'] = $pending_work_started_but_not_complete_q1->union($admin)->toArray();
        ksort($misReportData['pending_work_started_but_not_complete']);



        $est_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [1])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['est'] = $est_q1->union($admin)->toArray();
        ksort($misReportData['est']);


        $rev_est_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [2])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['rev_est'] = $rev_est_q1->union($admin)->toArray();
        ksort($misReportData['rev_est']);

        $ig_brk_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [3])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['ig_brk'] = $ig_brk_q1->union($admin)->toArray();
        ksort($misReportData['ig_brk']);

        $voa_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [4])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['voa'] = $voa_q1->union($admin)->toArray();
        ksort($misReportData['voa']);

        $unc_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [5])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['unc'] = $unc_q1->union($admin)->toArray();
        ksort($misReportData['unc']);

        $po_cost_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [6])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['po_cost'] = $po_cost_q1->union($admin)->toArray();
        ksort($misReportData['po_cost']);

        $rgt_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [7])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['rgt'] = $rgt_q1->union($admin)->toArray();
        ksort($misReportData['rgt']);

        $drp_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [8])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['drp'] = $drp_q1->union($admin)->toArray();
        ksort($misReportData['drp']);

        $qtd_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [9])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['qtd'] = $qtd_q1->union($admin)->toArray();
        ksort($misReportData['qtd']);

        $rev_qtd_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [10])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['rev_qtd'] = $rev_qtd_q1->union($admin)->toArray();
        ksort($misReportData['rev_qtd']);

        $tq_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [11])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['tq'] = $tq_q1->union($admin)->toArray();
        ksort($misReportData['tq']);

        $wrk_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [12])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['wrk'] = $wrk_q1->union($admin)->toArray();
        ksort($misReportData['wrk']);



        $tds_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [13])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['tds'] = $tds_q1->union($admin)->toArray();
        ksort($misReportData['tds']);

        $rev_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [14])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['rev'] = $rev_q1->union($admin)->toArray();
        ksort($misReportData['rev']);

        $hold = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [15])
            ->selectRaw('count(enquiries.id) as count , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('count', 'nick_name');
        // ->toSql();

        $misReportData['hold'] = $hold->union($admin)->toArray();

        $oldest_register_date_q1 = Enquiry::where([['role_id', 5], ['estimated_date', $misReportData['mis_date']], ['enquiries.status', 1], ['admins.status', 1]])->groupBy('nick_name')
            ->whereIn('engineer_status', [5])
            ->selectRaw('MIN(enq_register_date) as date , admins.nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'enquiries.engineer_id')
            ->pluck('date', 'nick_name');
        // ->toSql();

        $misReportData['oldest_register_date'] = $oldest_register_date_q1->union($admin)->toArray();
        ksort($misReportData['oldest_register_date']);

        $remark_data = DailyRemark::where([['daily_remarks.status', 1], ['remark_date', $misReportData['mis_date']]])->groupBy('nick_name')
            ->leftjoin('admins', 'admins.id', '=', 'daily_remarks.admin_id')
            ->pluck('activity_remarks', 'nick_name');

        $misReportData['enquiry_remark'] = $remark_data->union($admin)->toArray();
        ksort($misReportData['enquiry_remark']);

        // print_r($misReportData['oldest_register_date']);
        // die;
        $enq = Enquiry::where('id', 1)->get();
        return Excel::download(new MisReportExport($misReportData), 'MIS Report - ' . Carbon::now() . '.xlsx');
    }




    //generate data report
    public function generateDataReport(Request $request)
    {

        ini_set('memory_limit', '1024M');
        $role_id = session('data')['role_id'];
        $msg_data = array();
        $msg = "";
        $validationErrors = $this->validateReport($request, $role_id, 'data');

        if (count($validationErrors)) {
            \Log::error("Category Validation Exception: " . implode(", ", $validationErrors->all()));
            // errorMessage(implode("\n", $validationErrors->all()), $msg_data);
            return redirect()->route('data_report')->with('status', implode("\n", $validationErrors->all()));
        }

        $start_date = Carbon::parse(now())->format('Y-m-d');
        $end_date = Carbon::parse(now())->format('Y-m-d');
        if (
            isset($request->daterange) && !empty($request->daterange)
        ) {
            $string = explode('-', $request->daterange);
            $start_date = Carbon::createFromFormat('d/m/Y', trim($string[0]))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($string[1]))->format('Y-m-d');
        }

        $datediff = strtotime($end_date) - strtotime($start_date);
        $days = round($datediff / (60 * 60 * 24));
        $report_max_days = config('global.MAX_DAYS.MAX_ENQ_REP_DAYS');

        if ($days > $report_max_days) {
            return redirect()->route('data_report')->with('status', __('report.days_count_exceed'));
        }
        return Excel::download(new EnquiryExport($request), 'Data Enquiry - ' . Carbon::now() . '.xlsx');
    }


    //generate generateEnggAchievementReport 
    public function generateEnggAchievementReport(Request $request)
    {

        ini_set('memory_limit', '512M');
        $role_id = session('data')['role_id'];
        $msg_data = array();
        $msg = "";
        $EnggAchievementReportData = array();

        $validationErrors = $this->validateReport($request, $role_id, 'engineer_achievement');

        if (count($validationErrors)) {
            \Log::error("Report Validation Exception: " . implode(", ", $validationErrors->all()));
            // errorMessage(implode("\n", $validationErrors->all()), $msg_data);
            return redirect()->route('engineer_achievement_report')->with('status', implode("\n", $validationErrors->all()));
        }

        $start_date = $end_date = Carbon::parse(now())->format('Y-m-d');
        $start_date_to_display = $end_date_to_display = Carbon::parse(now())->format('d-m-Y');
        if (isset($request->daterange) && !empty($request->daterange)) {
            $string = explode('-', $request->daterange);
            $start_date = Carbon::createFromFormat('d/m/Y', trim($string[0]))->format('Y-m-d');
            $start_date_to_display = Carbon::createFromFormat('d/m/Y', trim($string[0]))->format('d-m-Y');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($string[1]))->format('Y-m-d');
            $end_date_to_display = Carbon::createFromFormat('d/m/Y', trim($string[1]))->format('d-m-Y');
        }

        $datediff = strtotime($end_date) - strtotime($start_date);
        $days = round($datediff / (60 * 60 * 24));
        $report_max_days = config('global.MAX_DAYS.MAX_ENQ_REP_DAYS');

        if ($days > $report_max_days) {
            return redirect()->route('engineer_achievement_report')->with('status', __('report.days_count_exceed'));
        }
        $enggIds = array();
        $EnggAchievementReportData['engineer_name'] = array();
        $req_engineer_id = $request->engineer;


        if ($req_engineer_id == 'all') {
            $enggIds = Admin::where([['role_id', 5]])->pluck('id')->toArray();
            $EnggAchievementReportData['engineer_name'] = ['ALL'];
        } else {
            $enggIds[] = $req_engineer_id;
            $EnggAchievementReportData['engineer_name'] = Admin::where([['role_id', 5], ['id', $req_engineer_id]])->pluck('nick_name')->toArray();
        }

        $categoryArray = Category::pluck('id')->toArray();
        $EngineerStatusArray = EngineerStatus::pluck('id')->toArray();

        if (!empty($request->categories) && !in_array('all', $request->categories)) {
            $categoryArray = $request->categories;
        }

        if (!empty($request->engineer_status) && !in_array('all', $request->engineer_status)) {
            $EngineerStatusArray = $request->engineer_status;
        }


        $EnggAchievementReportData['start_date_to_display'] = $start_date_to_display;
        $EnggAchievementReportData['end_date_to_display'] = $end_date_to_display;


        $EnggAchievementReportData['category_name'] = Category::whereIn('id', $categoryArray)->pluck('category_name')->toArray();
        $EnggAchievementReportData['engineer_status_name'] = EngineerStatus::whereIn('id', $EngineerStatusArray)->pluck('engineer_status_name')->toArray();

        $EnggAchievementReportData['blank_count'] = Enquiry::where([['enq_register_date', '>=', $start_date], ['enq_register_date', '<=', $end_date], ['enquiries.status', 1]])
            ->whereIn('engineer_id', $enggIds)
            ->whereNotNull('allocation_date')
            ->whereNull('engineer_status')
            ->whereNull('estimated_date')
            ->whereIn('category_id', $categoryArray)
            ->count();

        $EnggAchievementReportData['delayed'] = Enquiry::where([['enq_register_date', '>=', $start_date], ['enq_register_date', '<=', $end_date], ['enquiries.status', 1]])
            ->whereIn('engineer_id', $enggIds)
            ->whereNotNull('allocation_date')
            ->whereNotNull('engineer_status')
            ->whereNotNull('estimated_date')
            ->whereColumn('enq_reminder_date', '<', 'estimated_date')
            ->whereIn('category_id', $categoryArray)
            ->whereIn('engineer_status', $EngineerStatusArray)
            ->count();


        $EnggAchievementReportData['acted_on_time'] = Enquiry::where([['enq_register_date', '>=', $start_date], ['enq_register_date', '<=', $end_date], ['enquiries.status', 1]])
            ->whereIn('engineer_id', $enggIds)
            ->whereNotNull('allocation_date')
            ->whereNotNull('engineer_status')
            ->whereNotNull('estimated_date')
            ->whereColumn('enq_reminder_date', '>=', 'estimated_date')
            ->whereIn('category_id', $categoryArray)
            ->whereIn('engineer_status', $EngineerStatusArray)
            ->count();

        $EnggAchievementReportData['grand_total'] = $EnggAchievementReportData['blank_count']
            + $EnggAchievementReportData['delayed']
            + $EnggAchievementReportData['acted_on_time'];

        if ($EnggAchievementReportData['grand_total'] != 0) {
            $EnggAchievementReportData['achievement_percent'] = round(($EnggAchievementReportData['acted_on_time'] * 100.00) / $EnggAchievementReportData['grand_total'], 2);
        } else {
            $EnggAchievementReportData['achievement_percent'] = 0;
        }

        $all_status_count_q1 = Enquiry::where([['enq_register_date', '>=', $start_date], ['enq_register_date', '<=', $end_date], ['enquiries.status', 1]])->groupBy('engineer_status')
            ->selectRaw('count(enquiries.id) as count, engineer_status_name')
            ->whereIn('engineer_id', $enggIds)
            ->whereIn('category_id', $categoryArray)
            ->whereIn('engineer_status', $EngineerStatusArray)
            ->leftjoin('engineer_statuses', 'engineer_statuses.id', '=', 'enquiries.engineer_status')
            ->pluck('count', 'engineer_status_name');

        $all_status_count_q2 = EngineerStatus::orderBy('engineer_status_name', 'asc')
            ->where([['status', 1]])->selectRaw('0, engineer_status_name')
            ->pluck('0', 'engineer_status_name');
        $EnggAchievementReportData['status_count'] = $all_status_count_q1->union($all_status_count_q2);
        // print_r($data);
        // die;

        return Excel::download(new EnggAchievementExport($EnggAchievementReportData), 'Engineer Achievement Report - ' . Carbon::now() . '.xlsx');
    }


    //generate generateTypistAchievementReport 
    public function generateTypistAchievementReport(Request $request)
    {
        ini_set('memory_limit', '512M');
        $role_id = session('data')['role_id'];
        $msg_data = array();
        $msg = "";
        $TypistAchievementReportData = array();

        $validationErrors = $this->validateReport($request, $role_id, 'typist_achievement');

        if (count($validationErrors)) {
            \Log::error("Report Validation Exception: " . implode(", ", $validationErrors->all()));
            // errorMessage(implode("\n", $validationErrors->all()), $msg_data);
            return redirect()->route('typist_achievement_report')->with('status', implode("\n", $validationErrors->all()));
        }

        $start_date = $end_date = Carbon::parse(now())->format('Y-m-d');
        $start_date_to_display = $end_date_to_display = Carbon::parse(now())->format('d-m-Y');
        if (isset($request->daterange) && !empty($request->daterange)) {
            $string = explode('-', $request->daterange);
            $start_date = Carbon::createFromFormat('d/m/Y', trim($string[0]))->format('Y-m-d');
            $start_date_to_display = Carbon::createFromFormat('d/m/Y', trim($string[0]))->format('d-m-Y');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($string[1]))->format('Y-m-d');
            $end_date_to_display = Carbon::createFromFormat('d/m/Y', trim($string[1]))->format('d-m-Y');
        }

        $datediff = strtotime($end_date) - strtotime($start_date);
        $days = round($datediff / (60 * 60 * 24));
        $report_max_days = config('global.MAX_DAYS.MAX_ENQ_REP_DAYS');

        if ($days > $report_max_days) {
            return redirect()->route('typist_achievement_report')->with('status', __('report.days_count_exceed'));
        }

        $typistIds = array();
        $TypistAchievementReportData['typist_name'] = array();
        $req_typist_id = $request->typist;


        if ($req_typist_id == 'all') {
            $typistIds = Admin::where([['role_id', 6]])->pluck('id')->toArray();
            $TypistAchievementReportData['typist_name'] = ['ALL'];
        } else {
            $typistIds[] = $req_typist_id;
            $TypistAchievementReportData['typist_name'] = Admin::where([['role_id', 6], ['id', $req_typist_id]])->pluck('nick_name')->toArray();
        }


        $categoryArray = Category::pluck('id')->toArray();
        $TypistStatusArray = TypistStatus::pluck('id')->toArray();

        if (!empty($request->categories) && !in_array('all', $request->categories)) {
            $categoryArray = $request->categories;
        }

        if (!empty($request->typist_status) && !in_array('all', $request->typist_status)) {
            $TypistStatusArray = $request->typist_status;
        }


        $TypistAchievementReportData['start_date_to_display'] = $start_date_to_display;
        $TypistAchievementReportData['end_date_to_display'] = $end_date_to_display;
        $TypistAchievementReportData['category_name'] = Category::whereIn('id', $categoryArray)->pluck('category_name')->toArray();
        $TypistAchievementReportData['typist_status_name'] = TypistStatus::whereIn('id', $TypistStatusArray)->pluck('typist_status_name')->toArray();

        $TypistAchievementReportData['blank_count'] = Enquiry::where([['enq_register_date', '>=', $start_date], ['enq_register_date', '<=', $end_date], ['enquiries.status', 1]])
            ->whereIn('typist_id', $typistIds)
            ->whereNotNull('estimated_date')
            ->whereIn('engineer_status', [1, 2])
            ->whereNull('typist_status')
            ->whereNull('typist_completed_date')
            ->whereIn('category_id', $categoryArray)
            ->count();

        $TypistAchievementReportData['delayed'] = Enquiry::where([['enq_register_date', '>=', $start_date], ['enq_register_date', '<=', $end_date], ['enquiries.status', 1]])
            ->whereIn('typist_id', $typistIds)
            ->whereNotNull('estimated_date')
            ->whereIn('engineer_status', [1, 2])
            ->whereNotNull('typist_status')
            ->whereNotNull('typist_completed_date')
            ->whereColumn('enq_due_date', '<', 'typist_completed_date')
            ->whereIn('category_id', $categoryArray)
            ->whereIn('typist_status', $TypistStatusArray)
            ->count();


        $TypistAchievementReportData['acted_on_time'] = Enquiry::where([['enq_register_date', '>=', $start_date], ['enq_register_date', '<=', $end_date], ['enquiries.status', 1]])
            ->whereIn('typist_id', $typistIds)
            ->whereNotNull('estimated_date')
            ->whereIn('engineer_status', [1, 2])
            ->whereNotNull('typist_status')
            ->whereNotNull('typist_completed_date')
            ->whereColumn('enq_due_date', '>=', 'typist_completed_date')
            ->whereIn('category_id', $categoryArray)
            ->whereIn('typist_status', $TypistStatusArray)
            ->count();

        $TypistAchievementReportData['grand_total'] = $TypistAchievementReportData['blank_count']
            + $TypistAchievementReportData['delayed']
            + $TypistAchievementReportData['acted_on_time'];

        if ($TypistAchievementReportData['grand_total'] != 0) {
            $TypistAchievementReportData['achievement_percent'] = round(($TypistAchievementReportData['acted_on_time'] * 100.00) / $TypistAchievementReportData['grand_total'], 2);
        } else {
            $TypistAchievementReportData['achievement_percent'] = 0;
        }

        $all_status_count_q1 = Enquiry::where([['enq_register_date', '>=', $start_date], ['enq_register_date', '<=', $end_date], ['enquiries.status', 1]])->groupBy('typist_status')
            ->selectRaw('count(enquiries.id) as count, typist_status_name')
            ->whereIn('typist_id', $typistIds)
            ->whereIn('engineer_status', [1, 2])
            ->whereIn('category_id', $categoryArray)
            ->whereIn('typist_status', $TypistStatusArray)
            ->leftjoin('typist_statuses', 'typist_statuses.id', '=', 'enquiries.typist_status')
            ->pluck('count', 'typist_status_name');

        $all_status_count_q2 = TypistStatus::orderBy('typist_status_name', 'asc')
            ->where([['status', 1]])->selectRaw('0, typist_status_name')
            ->pluck('0', 'typist_status_name');
        $TypistAchievementReportData['status_count'] = $all_status_count_q1->union($all_status_count_q2);
        // print_r($data);
        // die;

        return Excel::download(new TypistAchievementExport($TypistAchievementReportData), 'Typist Achievement Report - ' . Carbon::now() . '.xlsx');
    }


    public function importEnquiry()
    {

        $data['typist_status'] = TypistStatus::all();
        $data['engineer_status'] = EngineerStatus::all();
        return view('backend/reports/enquiry_import_form', $data);
    }


    public function importExcelFile(Request $request)
    {


        $role_id = session('data')['role_id'];
        $msg_data = array();
        $msg = "";
        $validationErrors = $this->validateImportExcel($request, $role_id);

        if (count($validationErrors)) {
            \Log::error("Category Validation Exception: " . implode(", ", $validationErrors->all()));
            // errorMessage(implode("\n", $validationErrors->all()), $msg_data);
            return redirect()->route('import.form')->with('status', implode("\n", $validationErrors->all()));
        }
        Excel::import(new EnquiryImport, $request->importexcel);
        return redirect()->route('import.form')->with('success', 'File Imported Successfully');
    }




    private function validateReport(Request $request, $role_id, $for = 'data')
    {
        switch ($for) {
            case 'mis':
                return \Validator::make(
                    $request->all(),
                    [
                        'mis_date' => 'required',
                    ],
                    [
                        'mis_date.required' => 'Please select date',

                    ]
                )->errors();
                break;

            case 'data':
                return \Validator::make(
                    $request->all(),
                    [
                        'daterange' => 'required',
                    ],
                    [
                        'daterange.required' => 'Please select date range',

                    ]
                )->errors();
                break;

            case 'engineer_achievement':
                return \Validator::make(
                    $request->all(),
                    [
                        'daterange' => 'required',
                        'engineer' => 'required',
                    ],
                    [
                        'daterange.required' => 'Please select date range',
                        'engineer.required' => 'Engineer is require',

                    ]
                )->errors();
                break;

            case 'typist_achievement':
                return \Validator::make(
                    $request->all(),
                    [
                        'daterange' => 'required',
                        'typist' => 'required',
                    ],
                    [
                        'daterange.required' => 'Please select date range',
                        'typist.required' => 'Typist is require',

                    ]
                )->errors();
                break;

            default:
                # code...
                break;
        }
    }


    /**
     *   Created by : Maaz Ansari
     *   Created On : 02-sep-2022
     *   Uses :  category Add|Edit Form Validation part will be handle by below function
     *   @param Request request
     *   @return Response
     */
    private function validateTransferEngineer(Request $request)
    {
        return \Validator::make(
            $request->all(),
            [
                'engineer_id' => 'required',
            ],
            [
                'engineer_id.required' => 'The Engineer field is required',

            ]
        )->errors();
    }

    private function validateEnquiryRemark(Request $request)
    {
        return \Validator::make(
            $request->all(),
            [
                'editiorData' => 'required',
            ],
            [
                'editiorData.required' => 'Engineer Remark is require',
            ]
        )->errors();
    }


    /**
     *   Created by : Maaz Ansari
     *   Created On : 02-sep-2022
     *   Uses :  category Add|Edit Form Validation part will be handle by below function
     *   @param Request request
     *   @return Response
     */
    private function validateTransferTypist(Request $request)
    {
        return \Validator::make(
            $request->all(),
            [
                'typist_id' => 'required',
            ],
            [
                'typist_id.required' => 'The Typist field is required',

            ]
        )->errors();
    }


    private function validateImportExcel(Request $request, $role_id)
    {


        return \Validator::make(
            $request->all(),
            [
                'importexcel' => 'required|mimes:csv,xlsx,xls',
            ],
            [
                'importexcel.required' => 'Import File Is Require',
                'importexcel.mimes' => 'The Import File must be a file of type: csv, xlsx, xls',

            ]
        )->errors();
    }

    /**
     *    created by : Pradyumn Dwivedi
     *    Created On : 15-Sept-2022
     *   Uses :   To get data for allocator's dashboard engineer status current FY
     *   @param Request request
     *   @return Response
     */
    public function engineerStatusDashboard(Request $request)
    {
        $q1 = Enquiry::where([['sales_id', $request->sales_id], ['enquiries.status', 1]])->groupBy('engineer_status')
            ->selectRaw("count(enquiries.id) as count, ifnull(engineer_status_name, 'Blank') as engineer_status_name")
            ->leftjoin('engineer_statuses', 'engineer_statuses.id', '=', 'enquiries.engineer_status')
            ->pluck('count', 'engineer_status_name');

        $q2 = EngineerStatus::where([['status', 1]])->selectRaw('0, engineer_status_name')
            ->pluck('0', 'engineer_status_name');
        $data['engineer_status_count'] = $q1->union($q2);

        // print_r($data['engineer_status_count']);exit;
        return response()->json($data);
    }

    /**
     *   created by : Pradyumn Dwivedi
     *   Created On : 15-Sept-2022
     *   Uses :   To get data for sales's dashboard category status current FY
     *   @param Request request
     *   @return Response
     */
    public function categoryStatusDashboard(Request $request)
    {
        $q1 = Enquiry::where([['sales_id', $request->sales_id], ['enquiries.status', 1]])->groupBy('category_id')
            ->selectRaw("count(enquiries.id) as count, ifnull(category_name, 'Blank') as category_name")
            ->leftjoin('categories', 'categories.id', '=', 'enquiries.category_id')
            ->pluck('count', 'category_name');

        $q2 = Category::where([['status', 1]])->selectRaw('0, category_name')
            ->pluck('0', 'category_name');
        $data['category_status_count'] = $q1->union($q2);
        // print_r($data['category_status_count']);
        return response()->json($data);
    }


    /**
     *   created by : Maaz Ansari
     *   Created On : 15-Sept-2022
     *   Uses :   To get data for admin's dashboard category status current FY
     *   @param Request request
     *   @return Response
     */
    public function adminCategoryStatusDashboard(Request $request)
    {
        $q1 = Enquiry::where([['enquiries.status', 1]])->groupBy('category_id')
            ->selectRaw("count(enquiries.id) as count, ifnull(category_name, 'Blank') as category_name")
            ->leftjoin('categories', 'categories.id', '=', 'enquiries.category_id')
            ->pluck('count', 'category_name');

        $q2 = Category::where([['status', 1]])->selectRaw('0, category_name')
            ->pluck('0', 'category_name');
        $data['admin_category_status_count'] = $q1->union($q2);
        // print_r($data['category_status_count']);
        return response()->json($data);
    }


    /**
     *    created by : Maaz Ansari
     *    Created On : 15-Sept-2022
     *   Uses :   To get data for admins's dashboard engineer status current FY
     *   @param Request request
     *   @return Response
     */
    public function adminEngineerStatusDashboard(Request $request)
    {
        $q1 = Enquiry::where([['enquiries.status', 1]])->groupBy('engineer_status')
            ->selectRaw("count(enquiries.id) as count, ifnull(engineer_status_name, 'Blank') as engineer_status_name")
            ->leftjoin('engineer_statuses', 'engineer_statuses.id', '=', 'enquiries.engineer_status')
            ->pluck('count', 'engineer_status_name');

        $q2 = EngineerStatus::where([['status', 1]])->selectRaw('0, engineer_status_name')
            ->pluck('0', 'engineer_status_name');
        $data['admin_engineer_status_count'] = $q1->union($q2);

        // print_r($data['enquiries_status_count']);exit;
        return response()->json($data);
    }

    /**
     *    created by : Maaz Ansari
     *    Created On : 15-Sept-2022
     *   Uses :   To get data for admin's dashboard typist status current FY
     *   @param Request request
     *   @return Response
     */
    public function adminTypistStatusDashboard(Request $request)
    {
        $q1 = Enquiry::where([['enquiries.status', 1]])->groupBy('typist_status')
            ->selectRaw("count(enquiries.id) as count, ifnull(typist_status_name, 'Blank') as typist_status_name")
            ->leftjoin('typist_statuses', 'typist_statuses.id', '=', 'enquiries.typist_status')
            ->pluck('count', 'typist_status_name');

        $q2 = TypistStatus::where([['status', 1]])->selectRaw('0, typist_status_name')
            ->pluck('0', 'typist_status_name');
        $data['admin_typist_status_count'] = $q1->union($q2);

        // print_r($data['admin_typist_status_count']);exit;
        return response()->json($data);
    }





    /**
     *    created by : Maaz Ansari
     *    Created On : 15-Sept-2022
     *   Uses :   To get data for region count on admin dashboard 
     *   @param Request request
     *   @return Response
     */
    public function adminRegionDashboard(Request $request)
    {
        $q1 = Enquiry::where([['enquiries.status', 1]])->groupBy('region_id')
            ->selectRaw("count(enquiries.id) as count, ifnull(region_name, 'Blank') as region_name")
            ->leftjoin('regions', 'regions.id', '=', 'enquiries.region_id')
            ->pluck('count', 'region_name');

        $q2 = Region::where([['status', 1]])->selectRaw('0, region_name')
            ->pluck('0', 'region_name');
        $data['admin_region_count'] = $q1->union($q2);

        // print_r($data['region_count']);exit;
        return response()->json($data);
    }




    public function cmp($a, $b)
    {
        return $a <=> $b;
    }
}