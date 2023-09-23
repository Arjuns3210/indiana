<?php

namespace App\Http\Controllers\Backend;


use App\Exports\EnquiryExport;
use App\Exports\MipoReportExport;
use App\Http\Requests\EstimatorDocumentRequest;
use App\Models\MipoStatus;
use Carbon\Carbon;
use App\Models\Mipo;
use App\Models\Admin;
use App\Http\Requests\DesignerDocumentRequest;
use App\Models\Category;
use App\Models\Region;
use App\Models\TypistStatus;
use App\Models\EngineerStatus;
use Illuminate\Support\Facades\Redirect;
use App\Models\Enquiry;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\PaymentTerm;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMipoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\MipoVerificationRequest;
use App\Http\Requests\CommercialDocumentRequest;
use App\Http\Requests\CaseInchargeDocumentRequest;
use App\Http\Requests\PurchaseTeamDocumentRequest;
use App\Http\Requests\ManagementAllocationRequestst;
use App\Http\Requests\ManagementVerificationRequest;
use App\Http\Requests\MipoOrderSheetApprovalRequest;
use App\Http\Requests\EstimatorHeadAllocationRequest;
use App\Http\Requests\EstimatorHeadVerificationRequest;

/**
 * Class MipoController
 */
class MipoController extends Controller
{
    /**
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $user_id = session('data')['id'];
        $role_id = session('data')['role_id'];
        $data['mipo_add'] = checkPermission('mipo_add');
        $data['user'] = Admin::find($user_id);

        if ($role_id == '8') {
            $data['mipo_add'] = ($data['user']->is_head == '1') ? true : false;
        }
        $data['enquires'] = getEnquiriesListing();
        $data['regions'] = Region::where([['status', 1]])->get();
        $data['products'] = Product::where([['status', 1]])->get();
        $data['categories'] = Category::where([['status', 1]])->get();
        $data['mipoStatus'] = MipoStatus::where([['status',1]])->get();

        return view('backend/mipo/index',compact('data'));
    }

    /**
     * @param  Request  $request
     *
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function fetch(Request $request)
    {
        $role_id = session('data')['role_id'];
        $user_id = session('data')['id'];
        $user_data = Admin::where([
            ['status', '1'],
            ['id', $user_id]
        ])->first();
        $getRejectedMipoIds = DB::table('mipos')
            ->whereRaw('(ci_approval_status = "rejected" 
                OR engg_approval_status = "rejected" 
                OR commercial_approval_status = "rejected" 
                OR purchase_approval_status = "rejected" 
                OR head_engg_approval_status = "rejected"
                OR order_sheet_approval_status = "rejected"
                OR management_approval_status = "rejected"
                )')
            ->pluck('id')->toArray();
        if ($request->ajax()) {
            try {
                $query = Mipo::with('region:id,region_name', 'category:id,category_name', 'product:id,product_name','enquiry.region');

                if ($role_id != 1) {
                    $query->where('status', 1);
                }
                if ($role_id == 3) { // For Case Incharge
                    $query->where('case_incharge_id', $user_id);
                }
                if ($role_id == 5) { // For Estimator Engineer
                    $query->where('engineer_id', $user_id)->orWhere('head_engineer_id',$user_id);
                }
                if ($role_id == 8) { // For MIPO
                    if ($user_data->is_head != '1') {
                    $query->where('mipo_user_id', $user_id);
                    }
                }
                if ($role_id == 9) { // For Design Engineer
                    $query->where('drawing_id', $user_id);
                }
                if ($role_id == 10) { // For Commercial
                    $query->where('commercial_id', $user_id);
                }
                if ($role_id == 11) { // For Purchase Team
                    $query->where('purchase_id', $user_id);
                }
                $query->orderBy('id', 'desc');

                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_po_type']) && ! is_null($request['search']['search_po_type'])) {
                            $query->where('po_type', $request['search']['search_po_type']);
                        }
                        if (isset($request['search']['search_enquiry']) && ! is_null($request['search']['search_enquiry'])) {
                            $query->where('enquiry_id', $request['search']['search_enquiry']);
                        }
                        if (isset($request['search']['search_region']) && !is_null($request['search']['search_region'])) {
                            $query->where('region_id', $request['search']['search_region']);
                        }
                        if (isset($request['search']['search_product']) && !is_null($request['search']['search_product'])) {
                            $query->where('product_id', $request['search']['search_product']);
                        }
                        if (isset($request['search']['search_category']) && !is_null($request['search']['search_category'])) {
                            $query->where('category_id', $request['search']['search_category']);
                        }
                        if (isset($request['search']['search_is_frp']) && !is_null($request['search']['search_is_frp'])) {
                            $query->where('is_frp', $request['search']['search_is_frp']);
                        }if (isset($request['search']['search_po_status']) && !is_null($request['search']['search_po_status'])) {
                            $query->whereIn('mipo_status', $request['search']['search_po_status']);
                        }
                        $query->get();
                    })
                    ->editColumn('po_no', function ($event) {
                        return $event->po_no;
                    })
                    ->editColumn('po_type', function ($event) {
                        return strtoupper($event->po_type);
                    })
                    ->editColumn('revision_no', function ($event) {
                        return $event->revision_no;
                    })
                    ->editColumn('enquiry_no', function ($event) {
                        return $event->enquiry->enq_no.' / '. $event->enquiry->region->region_code .' / '. $event->enquiry->revision_no;
                    })
                    ->editColumn('region_name', function ($event) {
                        return $event->region->region_name;
                    })
                    ->editColumn('product_name', function ($event) {
                        return $event->product->product_name;
                    })
                    ->editColumn('action', function ($event) use ($role_id,$getRejectedMipoIds,$user_data) {
                        $mipo_delete = checkPermission('mipo_delete');
                        $mipo_view = checkPermission('mipo_view');
                        $mipo_edit = checkPermission('mipo_edit');
                        $user_id = session('data')['id'];
                        $mipo_head = false;

                        if ($role_id == 8 && $user_data->is_head == '1') {
                            $mipo_head = ($event->created_by != $user_id) ? true : false;
                        }
                        $actions = '<span style="white-space:nowrap;">';

                        if ($mipo_view) {
                            $actions .= '<a href="mipo_view/' . $event->id . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Mipo Details" title="View"><i class="fa fa-eye"></i></a>';
                        }

                        // if estimator engineer and head are not same than edit action access only for estimator engineer
                        if ($mipo_edit && !$mipo_head/* && $event->has_revisions == 0 */ && (($event->engineer_id != $event->head_engineer_id) ? (($user_id == $event->head_engineer_id) ? false : true) : true
                    )) {
                            if(checkTeamUserApproveOrRejected($event->id)){
                                $actions .= ' <a href="mipo_edit/'.$event->id.'" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                            }
                        }
                        if (in_array($role_id,[1,8]) && in_array($event->id, $getRejectedMipoIds)) {
                            $actions .= ' <a href="mipo_reassign/'.$event->id.'" class="btn btn-info btn-sm src_data" title="Reassign"><i class="fa fa-exchange"></i></a>';
                        }

                        // mipo verification button access only for assign mipo,Estimator head and management
                        if($event->ci_approval_status == "accepted" && $event->engg_approval_status == "accepted" && $event->commercial_approval_status == "accepted" && (($event->is_frp == 1) ? (($event->purchase_approval_status == "accepted") ? true : false) : true)){
                            if($user_id == $event->mipo_user_id && $event->mipo_verification_status == "pending"){
                                $actions .= ' <a href="edit_mipo_verification/'.$event->id.'" class="btn btn-warning btn-sm src_data" title="mipo verification"><i class="ft-check-circle"></i></a>';
                            }

                            if($user_id == $event->head_engineer_id && $event->head_engg_approval_status == "pending" && $event->mipo_verification_status == "accepted"){
                                $actions .= ' <a href="edit_mipo_verification/'.$event->id.'" class="btn btn-warning btn-sm src_data" title="Estimator Head Verification"><i class="ft-check-circle"></i></a>';     
                            }

                            if($user_id == $event->mipo_user_id && $event->head_engg_approval_status == "accepted" && $event->order_sheet_approval_status == "pending"){
                                $actions .= ' <a href="edit_mipo_verification/'.$event->id.'" class="btn btn-info btn-sm src_data" title="Order Sheet Approval"><i class="fa fa-plus"></i></a>';
                            }

                            if($user_id == $event->management_id && $event->order_sheet_approval_status == "accepted" && $event->management_approval_status == "pending"){
                                $actions .= ' <a href="edit_mipo_verification/'.$event->id.'" class="btn btn-warning btn-sm src_data" title="management verification"><i class="ft-check-circle"></i></a>';
                            }
                        }

                        if ($mipo_delete){
                            $dataUrl = '#'.$event->po_no;
                            $actions .= ' <a data-option="'.$dataUrl.'" data-url="mipo_delete/'.$event->id.'" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                            $actions .= '</span>';
                        }

                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns([
                        'po_no', 'po_type', 'enquiry_no', 'product_name', 'action',
                    ])->setRowId('id')
                    ->setRowClass(function ($event) use ($getRejectedMipoIds,$role_id) {
                        if (in_array($role_id ,[1,8])){
                            return in_array($event->id,$getRejectedMipoIds) ? 'text-danger' : '';
                        }
                        return  '';
                    })->make(true);
            } catch (\Exception $e) {
                \Log::error("Something Went Wrong. Error: ".$e->getMessage());

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

    public function getClientname(Request $request){

        $data['enquires'] = getEnquiriesListing($request->client_name,$request->region_id);

        return Response::json($data);
    }

    /**
     * View Mipo Form
     *
     * @return Application|Factory|View
     */
    public function viewForm()
    {
        $data['enquires'] = getEnquiriesListing();
        $data['regions'] = Region::where([['status', 1]])->get();
        $data['products'] = Product::where('status', 1)->get(['id', 'product_code']);
        $data['categories'] = Category::where([['status', 1]])->get(['id', 'category_code']);
        $data['caseIncharges'] = Admin::where([['role_id', 3], ['status', 1]])->get();
        $data['engineers'] = Admin::where([['role_id', 5], ['status', 1]])->get();
        $data['mipos'] = Mipo::with('region')->where('status', 1)->get();

        return view('backend/mipo/add_mipo')->with($data);
    }

    /**
     * @param  Request  $request
     * get Select Enquiry data
     * @return JsonResponse
     */
    public function getEnquiryData(Request $request)
    {
        $enquiryId = $request->get('enquiryId') ?? '';
        $data['data'] = Enquiry::where([['id', $enquiryId], ['status', 1]])->first();
        $data['result'] = ($data['data']) ? true : false;

        return Response::json($data);
    }

    /**
     * @param  Request  $request
     * Get Selected Mipo Data
     *
     * @return JsonResponse
     */
    public function getMipoData(Request $request)
    {
        $mipo = $request->get('mipoId') ?? '';
        $data['data'] = Mipo::where([['id', $mipo], ['status', 1]])->first();
        $data['result'] = ($data['data']) ? true : false;

        return Response::json($data);
    }
    /**
     * @param  CreateMipoRequest  $request
     *
     * Store mipo Details
     */
    public function saveMipoDetails(CreateMipoRequest $request)
    {
        $input = $request->all();
        $input['mipo_id'] = $input['mipo_id'] ?? '';

        if ($input['mipo_id']) {
            $msg = 'Mipo updated successfully';
            $mipo = Mipo::find($input['mipo_id']);
            $mipo->update($input);
        } else {
            $input['created_by'] = session('data')['id'];
            $input['mipo_user_id'] = assignMipoUser();
            $input['mipo_user_allocation_dt'] = Carbon::now();

            if(empty( $input['mipo_user_id'])){
                errorMessage("Please first create the Mipo user.");
            }
            if(empty($input['category_id'])){
                $input['category_id'] = config('global.DEFAULT_CATEGORY_ID');
            }
            $input['maker_id'] = session('data')['id'];
            //generate revision no
            if ($input['po_type'] == 'new') {
                $input['revision_no'] = 0;
                $input['po_no'] = uniqueMipoJobNumber();
            }

            if ($input['po_type'] == 'cn') {
                $mipo = Mipo::where('id', $input['revision_mipo_id'])->first();
                $getLastMipos = Mipo::withTrashed()->where('po_no', $mipo->po_no)->latest()->first();
                //check last revision mipo is exist or not
                if ($getLastMipos) {
                    // update last mipo in has revision field
                    $getLastMipos->update([
                        'has_revisions' => 1,
                    ]);
                    $input['revision_no'] = $getLastMipos->revision_no + 1;
                    $input['po_no'] = $getLastMipos->po_no;
                } else {
                    $input['revision_no'] = 1;
                    $input['po_no'] = uniqueMipoJobNumber();
                }
            }
            $mipo = Mipo::create($input);

            if ($mipo) {
                $mipoId = $mipo->id;
                $remark = getUserData($mipo->mipo_user_id)->nick_name .' is allocated';
                updateMipoStatus('POW', $mipo);
                addMipoCaseHistory($mipoId, getRoleName(8), 'allocated',$remark);

                //Send mail allocated users
                if ($mipo->mipo_user_id) {
                    $productEmails = Product::where('id', $mipo->product_id)->first()->email_id ?? '';
                    $productEmails = explode(',', $productEmails);

                    foreach ($productEmails as $productEmail) {
                        // remove space into exploded emails
                        $ccEmail[] = trim($productEmail);
                    }
                    $ccEmail[] = session('data')['email'];
                    sendMipoMail('PO_ROLES_MAPPED', 'all', $mipo, $mipo->mipo_user_id, $ccEmail);
                }
            }
            $msg = 'Mipo created successfully';
        }

        successMessage($msg);
    }

    /**
     * @param $id
     *
     */
    public function deleteMipo($id)
    {
        $mipo = Mipo::where('id', $id)->first();
        $mipo->delete();

        successMessage('Data Deleted successfully', []);
    }

    /**
     * @param $id
     * Edit Mipo Form Screen
     *
     * @return Application|Factory|View
     */
    public function editMipo($id)
    {
        $data['enquires'] = getEnquiriesListing();
        $data['regions'] = Region::where([['status', 1]])->get();
        $data['products'] = Product::where('status', 1)->get(['id', 'product_code']);
        $data['categories'] = Category::where([['status', 1]])->get(['id', 'category_code']);
        $data['engineers'] = Admin::where([['role_id', 5], ['status', 1]])->get();
        $data['mipo'] = Mipo::where('id', $id)->first();
        $data['caseIncharges'] = Admin::where([['role_id', 3], ['status', 1]])->get();
        $data['mipos'] = Mipo::with('region')->where('status', 1)->get();

        //check commercial document folder is exist or not
        $data['templateDocumentsSrcArr'] = file_view('commercial', 'template_'.$id, null);
        $data['poDetailDocumentsSrcArr'] = file_view('commercial', 'po-detail_'.$id, null);
        $data['extraCommercialDocumentsSrcArr'] = file_view('commercial', 'extra_'.$id, null);

        //check purchase_team document folder is exist or not
        $data['vendorPoDocumentsSrcArr'] = file_view('purchase-team', 'vendor-po_'.$id, null);
        $data['extraPurchaseDocumentsSrcArr'] = file_view('purchase-team', 'extra_'.$id, null);

        //get caseincharge data
        $type = 'caseincharge';
        $data['dclDocumentsSrcArr'] = file_view($type, 'dcl_'.$id, null);
        $data['miDocumentsSrcArr'] = file_view($type, 'mi_'.$id, null);
        $data['extraCiDocumentsSrcArr'] = file_view($type, 'extra_'.$id, null);
        
        // Estimator Engineer documents
        $data['poCostSheetDocumentsSrcArr'] = file_view('estimator-engineer', 'po-cost-sheet_'.$id);
        $data['extraEstimatorDocumentsSrcArr'] = file_view('estimator-engineer', 'extra_'.$id);

        // Design Engineer documents
        $data['designDrawingDocumentsSrcArr'] = file_view('design-engineer', 'design-drawing_'.$id);

        $currentUserRoleId = session('data')['role_id'];

        if ($currentUserRoleId == 1) { // for admin
            return view('backend/mipo/add_mipo')->with($data);
        }
        if ($currentUserRoleId == 3) { // for Case incharge
            return view('backend/mipo/case_incharge_mipo')->with($data);
        }
        if ($currentUserRoleId == 5) { // for Estimator Engineer
            $data['role'] = 'Estimator Engineer';
            $data['designEngineers'] = Admin::where([['role_id', 9],['status',1]])->get();

            return view('backend/mipo/mipo_estimator_engineer_form',$data);
        }
        if ($currentUserRoleId == 8) { // for Mipo
            $data['role'] = 'Mipo';
            $data['client_histories'] = Mipo::where([
                ['client_name', $data['mipo']->client_name],
                ['created_at', '<', $data['mipo']->created_at]
            ])->orderBy('created_at', 'desc')->take(config('global.TOTAL_RECORDS_FOR_OLD_MIPO_HISTORY'))->get();
            $data['caseIncharges'] = Admin::where([['role_id', 3], ['status', 1]])->get();
            $data['engineers'] = Admin::where([['role_id', 5], ['status', 1]])->get();
            $data['commercial'] = Admin::where([['role_id', 10], ['status', 1]])->get();
            $data['purchaseTeams'] = Admin::where([['role_id', 11], ['status', 1]])->get();

            return view('backend/mipo/mipo_allocation_user_form')->with($data);
        }
        if ($currentUserRoleId == 9) { // for Design Engineer
            return view('backend/mipo/mipo_design_engineer_form',$data);
        }
        if ($currentUserRoleId == 10) { // for Commercial
            $data['role'] = 'Commercial';

            return view('backend/mipo/mipo_commercial_form', $data);
        }
        if ($currentUserRoleId == 11) { // for Purchase Team
            $data['role'] = 'Purchase Team';

            return view('backend/mipo/mipo_purchase_team_form', $data);
        }
    }

    public function saveMipoAllocation(Request $request)
    {
        $msg_data = [];

        $validator = \Validator::make($request->all(), [
            'case_incharge_id' => 'required',
            'engineer_id'      => 'required',
            'commercial_id'    => 'required',
        ]);

        // if foreign purchase(is_frp) than purchase Team is required
        if ($request->is_frp == 1) {
            $validator->addRules(['purchase_id' => 'required']);
        }
        $validateMipoErrors = $validator->errors();

        if (count($validateMipoErrors)) {
            \Log::error("Category Validation Exception: ".implode(", ", $validateMipoErrors->all()));
            errorMessage(implode("\n", $validateMipoErrors->all()), $msg_data);
        }
        $input = $request->all();
        $mipoId = $input['mipo_id'];
        $mipo = Mipo::findOrFail($mipoId);

        $ciId = $mipo->case_incharge_id;
        $engId = $mipo->engineer_id;
        $commercialId = $mipo->commercial_id;
        $purchaseId = $mipo->purchase_id;

        $mipo->update($input);

        //for ccEmails
        $productEmails = Product::where('id', $mipo->product_id)
                ->first()->email_id ?? '';
        $productEmails = explode(',', $productEmails);
        foreach ($productEmails as $productEmail) {
            // remove space into exploded emails
            $ccEmail[] = trim($productEmail);
        }
        $ccEmail[] = session('data')['email'] ?? '';

        // For add mipo case history
        if ($mipo->case_incharge_id != $ciId && ! is_null($mipo->allocation_completion_dt)) {
            $remark = 'transferred '.getUserData($ciId)->nick_name.' to '.getUserData($mipo->case_incharge_id)->nick_name;
            addMipoCaseHistory($mipoId, getRoleName(3), 'transfer',$remark);
            sendMipoMail('PO_ROLES_TRANSFER', 'all', $mipo, $mipo->case_incharge_id, $ccEmail);
        } elseif (is_null($mipo->allocation_completion_dt) || empty($mipo->allocation_completion_dt)) {
            $remark = getUserData($mipo->case_incharge_id)->nick_name.' is allocated';
            addMipoCaseHistory($mipoId, getRoleName(3), 'allocated',$remark);
            sendMipoMail('PO_ROLES_MAPPED', 'all', $mipo, $mipo->case_incharge_id, $ccEmail);
        }

        if ($mipo->engineer_id != $engId && ! is_null($mipo->allocation_completion_dt)) {
            $remark = 'transferred '.getUserData($engId)->nick_name.' to '.getUserData($mipo->engineer_id)->nick_name;
            addMipoCaseHistory($mipoId,  getRoleName(5), 'transfer',$remark);
            sendMipoMail('PO_ROLES_TRANSFER', 'all', $mipo, $mipo->engineer_id, $ccEmail);
        } elseif (is_null($mipo->allocation_completion_dt) || empty($mipo->allocation_completion_dt)) {
            $remark = getUserData($mipo->engineer_id)->nick_name .' is allocated';
            addMipoCaseHistory($mipoId, getRoleName(5), 'allocated',$remark);
            sendMipoMail('PO_ROLES_MAPPED', 'all', $mipo, $mipo->engineer_id, $ccEmail);
        }

        if ($commercialId == 0 && ! empty($mipo->commercial_id)) {
            $remark = getUserData($mipo->commercial_id)->nick_name .' is allocated';
            addMipoCaseHistory($mipoId, getRoleName(10), 'allocated',$remark);
            sendMipoMail('PO_ROLES_MAPPED', 'all', $mipo, $mipo->commercial_id, $ccEmail);
        } elseif ($commercialId != $mipo->commercial_id) {
            $remark = 'transferred '.getUserData($commercialId)->nick_name.' to '.getUserData($mipo->commercial_id)->nick_name;
            addMipoCaseHistory($mipoId, getRoleName(10), 'transfer',$remark);
            sendMipoMail('PO_ROLES_TRANSFER', 'all', $mipo, $mipo->commercial_id, $ccEmail);
        }

        if ($purchaseId == 0 && ! empty($mipo->purchase_id)) {
            $remark = getUserData($mipo->purchase_id)->nick_name .' is allocated';
            addMipoCaseHistory($mipoId, getRoleName(11), 'allocated',$remark);
            sendMipoMail('PO_ROLES_MAPPED', 'all', $mipo, $mipo->purchase_id, $ccEmail);
        } elseif (! empty($mipo->purchase_id) && $purchaseId != $mipo->purchase_id) {
            $remark = 'transferred '.getUserData($purchaseId)->nick_name.' to '.getUserData($mipo->purchase_id)->nick_name;
            addMipoCaseHistory($mipoId, getRoleName(11), 'transfer',$remark);
            sendMipoMail('PO_ROLES_TRANSFER', 'all', $mipo, $mipo->purchase_id, $ccEmail);
        }
        // first time allocation check condition
        if (is_null($mipo->allocation_completion_dt) || empty($mipo->allocation_completion_dt)) {
            updateMipoStatus('TMA', $mipo);
        }
        $mipo->update([
            'allocation_completion_dt' => Carbon::now(),
        ]);
        $msg = 'Mipo User Allocation updated successfully';

        successMessage($msg, $msg_data);
    }

    public function saveMipoEstimatorForm(EstimatorDocumentRequest $request)
    {
        $msg_data = [];
        $mipoId = $request->mipo_id;
        $mipo = Mipo::findOrFail($mipoId);

        // Designer Approval
        if(isset($request->designer_approval_status) && $request->designer_approval_status == "designer_approve") {
            $msg = "Mipo Designer Documents approved successfully";
            $mipo->update([
                'drawing_approval_status'    => 'accepted',
                'drawing_document_upload_dt' => Carbon::now(),
                'drawing_remarks'            => $request->drawing_remarks,
            ]);
            if (checkIsAllRolesApprovedMipo($mipo)) {
                $statusCode = 'MFV_PEN';
            } else {
                $statusCode = 'ENG_APP';
            }
            updateMipoStatus($statusCode, $mipo);
            $remark = 'Approved by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, getRoleName(9), 'approved', $remark, $request->drawing_remarks ?? '');
            sendMipoMail('PO_APPROVED', 'all', $mipo, $mipo->mipo_user_id);

            successMessage($msg,$msg_data);
        }

        // Designer reject
        if (isset($request->designer_approval_status) && $request->designer_approval_status == "designer_rejected") {
            $mipo->update([
                'drawing_remarks'            => $request->drawing_remarks,
                'drawing_document_upload_dt' => Carbon::now(),
                'drawing_approval_status'    => "rejected",
            ]);
            updateMipoStatus('ENG_REJ', $mipo);
            $remark = 'Rejected by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, getRoleName(9), 'rejected', $remark, $request->drawing_remarks ?? '');
            sendMipoMail('PO_REJECTED', 'all', $mipo, $mipo->mipo_user_id);

            $msg = "Mipo Drawing documents rejected successfully.";
            successMessage($msg, $msg_data);
        }

        // Estimator reject
        if (isset($request->estimator_approval_status) && $request->estimator_approval_status == "estimator_rejected") {
            $mipo->update([
                'engg_document_upload_dt' => Carbon::now(),
                'engg_remarks'            => $request->engg_remarks,
                'engg_approval_status'    => "rejected",
            ]);
            updateMipoStatus('ENG_REJ', $mipo);
            $remark = 'Rejected by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, getRoleName(5), 'rejected', $remark, $request->engg_remarks ?? '');
            sendMipoMail('PO_REJECTED', 'all', $mipo, $mipo->mipo_user_id);

            $msg = "Mipo Estimator Engineer rejected successfully.";
            successMessage($msg, $msg_data);
        }

        // if is_gr than design engineer is required
        if ($request->is_gr == 1) {
            $validator = \Validator::make($request->all(), [
                'drawing_id' => 'required'
            ]);
            $validateMipoErrors = $validator->errors();

            if (count($validateMipoErrors)) {
                \Log::error("Mipo Estimator Validation Exception: ".implode(", ", $validateMipoErrors->all()));
                errorMessage(implode("\n", $validateMipoErrors->all()), $msg_data);
            }
        }
        $input = $request->all();
        $mipo->update($input);

        $type = "estimator-engineer";
        $remarkDocumentMsg = "";

        if (isset($input['estimatorPoSheetDocument']) && ! empty($input['estimatorPoSheetDocument'])) {
            $this->storeMultipleDocuments($input['estimatorPoSheetDocument'], $type, 'po-cost-sheet_'.$mipoId);
            $remarkDocumentMsg .= "Total ".count($input['estimatorPoSheetDocument'])." PO Cost Sheet Docs Uploaded. ";
        }
        if (isset($input['estimatorExtraDocument']) && ! empty($input['estimatorExtraDocument'])) {
            $this->storeMultipleDocuments($input['estimatorExtraDocument'], $type, 'extra_'.$mipoId);
            $remarkDocumentMsg .= "Total ".count($input['estimatorExtraDocument'])." Extra Docs Uploaded. ";
        }
        if(isset($input['estimatorPoSheetDocument']) || isset($input['estimatorExtraDocument'])){
            addMipoCaseHistory($mipoId,getRoleName(5),'upload',$remarkDocumentMsg);
        }

        // Estimator Approval
        if(isset($request->estimator_approval_status) && $request->estimator_approval_status == "estimator_approve") {
            $msg = "Mipo Estimator approved successfully";
            $mipo->update([
                'engg_document_upload_dt' => Carbon::now(),
                'engg_approval_status' => "accepted",
                'engg_remarks' => $request->engg_remarks,
            ]);
            if (checkIsAllRolesApprovedMipo($mipo)) {
                $statusCode = 'MFV_PEN';
            } else {
                $statusCode = 'ENG_APP';
            }
            $remark = 'Approved by '.session('data')['nick_name'];
            updateMipoStatus($statusCode, $mipo);
            addMipoCaseHistory($mipoId, getRoleName(5), 'approved', $remark, $request->engg_remarks ?? '');
            sendMipoMail('PO_APPROVED', 'all', $mipo, $mipo->mipo_user_id);
            successMessage($msg,$msg_data);
        }
        $msg = "Mipo Update successfully";
        successMessage($msg,$msg_data);
    }

    public function saveDesignerMipoForm(DesignerDocumentRequest $request)
    {
        // document folder type
        $type = 'design-engineer';
        $input = $request->all();
        $mipoId = $input['mipo_id'];
        $mipo = Mipo::findOrFail($mipoId);
        $mipo->ig_breakup = $input['ig_breakup'];
        $mipo->input_availability = $input['input_availability'];
        $mipo->input_availability_by = session('data')['role_id'];
        $mipo->save();

        if (isset($input['designerDrawingDocument']) && ! empty($input['designerDrawingDocument'])) {
            $msg = "Mipo Designer documents uploaded successfully.";
            $this->storeMultipleDocuments($input['designerDrawingDocument'], $type, 'design-drawing_'.$input['mipo_id']);

            $remarkDocumentMsg = "Total ".count($input['designerDrawingDocument'])." Design Drawing Docs Uploaded. ";
            addMipoCaseHistory($mipoId,getRoleName(9),'upload',$remarkDocumentMsg);
        }
        $msg = "Mipo Designer Data Updated Successfully.";
        successMessage($msg);
    }

    public function saveCommercialMipoForm(CommercialDocumentRequest $request)
    {
        $type = 'commercial';
        $mipoId = $request->mipo_id;
        $mipo = Mipo::findOrFail($mipoId);

        $mipo->update([
            'commercial_remarks' => $request->commercial_remarks,
        ]);

        if (isset($request->commercial_approval_status) && $request->commercial_approval_status == "rejected") {
            $mipo->update([
                'commercial_document_upload_dt' => Carbon::now(),
                'commercial_approval_status'    => "rejected",
            ]);
            updateMipoStatus('COM_REJ', $mipo);
            $remark = 'Rejected by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, getRoleName(10), 'rejected', $remark, $request->commercial_remarks ?? '');
            sendMipoMail('PO_REJECTED', 'all', $mipo, $mipo->mipo_user_id);

            successMessage('Mipo Commercial rejected successfully.');
        }
        $input = $request->all();
        $remarkDocumentMsg = "";

        if (isset($input['commercialTemplateDocument']) && ! empty($input['commercialTemplateDocument'])) {
            $this->storeMultipleDocuments($input['commercialTemplateDocument'], $type, 'template_'.$mipoId);
            $remarkDocumentMsg .= "Total ".count($input['commercialTemplateDocument'])." Template Docs Uploaded. ";
        }
        if (isset($input['commercialPoDetailDocument']) && ! empty($input['commercialPoDetailDocument'])) {
            $this->storeMultipleDocuments($input['commercialPoDetailDocument'], $type, 'po-detail_'.$mipoId);
            $remarkDocumentMsg .= "Total ".count($input['commercialPoDetailDocument'])." PO Detail Docs Uploaded. ";
        }
        if (isset($input['commercialExtraDocument']) && ! empty($input['commercialExtraDocument'])) {
            $this->storeMultipleDocuments($input['commercialExtraDocument'], $type, 'extra_'.$mipoId);
            $remarkDocumentMsg .= "Total ".count($input['commercialExtraDocument'])." Extra Docs Uploaded. ";
        }

        if(isset($input['commercialTemplateDocument']) || isset($input['commercialPoDetailDocument']) || isset($input['commercialExtraDocument'])){
            
            addMipoCaseHistory($mipoId,getRoleName(10),'upload',$remarkDocumentMsg);   
        }

        //commercial approval
        if(isset($request->commercial_approval_status) && $request->commercial_approval_status == "approve") {
            $mipo->update([
                'commercial_approval_status' => "accepted",
                'commercial_document_upload_dt' => Carbon::now(),
                ]);
            if (checkIsAllRolesApprovedMipo($mipo)) {
                $statusCode = 'MFV_PEN';
            } else {
                $statusCode = 'COM_APP';
            }
            updateMipoStatus($statusCode, $mipo);
            $remark = 'Approved by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, getRoleName(10), 'approved', $remark, $request->commercial_remarks ?? '');
            sendMipoMail('PO_APPROVED', 'all', $mipo, $mipo->mipo_user_id);
            
            successMessage('Mipo Commercial document uploads and Approved successfully.');
        }
        successMessage('Mipo Commercial documents uploaded successfully.');
    }

    public function savePurchaseTeamMipoForm(PurchaseTeamDocumentRequest $request)
    {
        $type = 'purchase-team';
        $mipoId = $request->mipo_id;
        $mipo = Mipo::findOrFail($mipoId);

        $mipo->update([
            'purchase_remarks' => $request->purchase_remarks,
        ]);

        if(isset($request->purchase_approval_status) && $request->purchase_approval_status == "rejected") {
            $mipo->update([
                'purchase_document_upload_dt' => Carbon::now(),
                'purchase_approval_status'    => "rejected",
            ]);
            $remark = 'Rejected by '.session('data')['nick_name'];
            updateMipoStatus('PUR_REJ', $mipo);
            addMipoCaseHistory($mipoId, getRoleName(11), 'rejected', $remark, $request->purchase_remarks ?? '');
            sendMipoMail('PO_REJECTED', 'all', $mipo, $mipo->mipo_user_id);

            successMessage('Mipo Purchase Team rejected successfully.');
        }
        $input = $request->all();
        $remarkDocumentMsg = "";

        if (isset($input['purchaseVendorPoDocument']) && ! empty($input['purchaseVendorPoDocument'])) {
            $this->storeMultipleDocuments($input['purchaseVendorPoDocument'], $type, 'vendor-po_'.$mipoId);
            $remarkDocumentMsg .= "Total ".count($input['purchaseVendorPoDocument'])." Vendor PO Docs Uploaded. ";
        }
        if (isset($input['purchaseExtraDocument']) && ! empty($input['purchaseExtraDocument'])) {
            $this->storeMultipleDocuments($input['purchaseExtraDocument'], $type, 'extra_'.$mipoId);
            $remarkDocumentMsg .= "Total ".count($input['purchaseExtraDocument'])." Extra Docs Uploaded. ";
        }

        if(isset($input['purchaseVendorPoDocument']) || isset($input['purchaseExtraDocument'])){
          
            
            addMipoCaseHistory($mipoId,getRoleName(11),'upload',$remarkDocumentMsg);
        }

        //purchase team approval
        if(isset($request->purchase_approval_status) && $request->purchase_approval_status == "approve") {
            $mipo->update([
                'purchase_approval_status' => "accepted",
                'purchase_document_upload_dt' => Carbon::now(),
            ]);
            if (checkIsAllRolesApprovedMipo($mipo)) {
                $statusCode = 'MFV_PEN';
            } else {
                $statusCode = 'PUR_APP';
            }
            updateMipoStatus($statusCode, $mipo);
            updateMipoStatus($statusCode, $mipo);
            $remark = 'Approved by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, getRoleName(11), 'approved', $remark, $request->purchase_remarks ?? '');
            sendMipoMail('PO_APPROVED', 'all', $mipo, $mipo->mipo_user_id);
            successMessage('Mipo Purchase Team document uploads and Approved successfully.');
        }
        successMessage('Mipo Purchase Team documents uploaded successfully.');
    }

    /**
     * @param  CaseInchargeDocumentRequest  $request
     * Update case incharge mipo details & Documents
     *
     * @return bool
     */
    public function saveCashinchargeMipoDetails(CaseInchargeDocumentRequest $request)
    {
        $input = $request->all();
        $mipoId = $input['mipo_id'] ?? '';
        $type = 'caseincharge';
        $mipo = Mipo::findOrFail($mipoId);
        $mipo->update([
            'ci_remarks'              => $request->ci_remarks,
            "first_engg_input_date"   => $input["first_engg_input_date"] ?? '',
            "last_engg_input_date"    => $input["last_engg_input_date"] ?? '',
            "no_of_days_for_approval" => $input["no_of_days_for_approval"] ?? '',
            "input_availability"      => $input["input_availability"] ?? '',
            'input_availability_by'   => session('data')['role_id'],
        ]);

        if(isset($request->ci_approval_status) && $request->ci_approval_status == "rejected") {
            $mipo->update([
                'ci_approval_status'    => "rejected",
                'ci_document_upload_dt' => Carbon::now(),
            ]);
            updateMipoStatus('CI_REJ', $mipo);
            $remark = 'Rejected by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, getRoleName(3), 'rejected', $remark, $request->ci_remarks ?? '');
            sendMipoMail('PO_REJECTED', 'all', $mipo, $mipo->mipo_user_id);

            successMessage('Mipo CaseIncharge rejected successfully.');
        }

        $remarkDocumentMsg = "";

        if (isset($input['caseInchargeDclDocument']) && ! empty($input['caseInchargeDclDocument'])) {
            $this->storeMultipleDocuments($input['caseInchargeDclDocument'], $type, 'dcl_'.$mipoId);
            $remarkDocumentMsg .= "Total ".count($input['caseInchargeDclDocument'])." DCL Docs Uploaded. ";
        }
        if (isset($input['caseInchargeMiDocument']) && ! empty($input['caseInchargeMiDocument'])) {
            $this->storeMultipleDocuments($input['caseInchargeMiDocument'], $type, 'mi_'.$mipoId);
            $remarkDocumentMsg .= "Total ".count($input['caseInchargeMiDocument'])." MI Docs Uploaded. ";
        }
        if (isset($input['caseInchargeExtraDocument']) && ! empty($input['caseInchargeExtraDocument'])) {
            $this->storeMultipleDocuments($input['caseInchargeExtraDocument'], $type, 'extra_'.$mipoId);
            $remarkDocumentMsg .= "Total ".count($input['caseInchargeExtraDocument'])." Extra Docs Uploaded. ";
        }

        if(isset($input['caseInchargeDclDocument']) || isset($input['caseInchargeMiDocument']) || isset($input['caseInchargeExtraDocument'])){
            addMipoCaseHistory($mipoId,getRoleName(3),'upload',$remarkDocumentMsg);
        }

        //Case Incharge approval
        if(isset($request->ci_approval_status) && $request->ci_approval_status == "approve") {
            $mipo->update([
                'ci_approval_status' => "accepted",
                'ci_document_upload_dt' => Carbon::now(),
            ]);
            if (checkIsAllRolesApprovedMipo($mipo)) {
                $statusCode = 'MFV_PEN';
            } else {
                $statusCode = 'CI_APP';
            }
            updateMipoStatus($statusCode, $mipo);
            $remark = 'Approved by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, getRoleName(3), 'approved', $remark, $request->purchase_remarks ?? '');
            sendMipoMail('PO_APPROVED', 'all', $mipo, $mipo->mipo_user_id);
            
            successMessage('Mipo Case Incharge document uploads and Approved successfully.');
        }

        successMessage('Mipo Case Incharge documents uploaded successfully.');
    }

    /**
     * @param $documents
     * @param $type
     * @param $mipoId
     *
     * Store multiple documents
     */
    public function storeMultipleDocuments($documents, $type, $mipoId)
    {
       $arr = file_view($type, $mipoId, null);
        $max_value = 0;
        if (! empty($arr)) {
            foreach ($arr as $element) {
                $filename =  pathinfo($element)['filename'];
                $getLastNumber = explode('_', $filename)[3];
                if ($max_value === null || $getLastNumber > $max_value) {
                    $max_value = $getLastNumber;
                }
            }
        }

        if (! empty($documents)) {
            saveMultipleImage($documents, $type, $mipoId, $max_value + 1);
        }
    }

    /**
     * @param  Request  $request
     * Delete Mipo Document
     *
     * @return bool
     */
    public function deleteMipoDocument(Request $request)
    {
        $input = $request->all();
        if (isset($input['url'])) {
            $getUrl = $input['url'];
            $filename = pathinfo(parse_url($getUrl, PHP_URL_PATH), PATHINFO_BASENAME);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $value = explode('_', pathinfo($getUrl)['filename']);
            if ($input['path'] == 'caseincharge' || $input['path'] == 'commercial' || $input['path'] == 'purchase-team' || $input['path'] == 'estimator-engineer' || $input['path'] == 'design-engineer' || $input['path'] == 'mipo-team') {
                $mipoIdWithKey = implode('_', [$value[1], $value[2]]);
                deleteImage($mipoIdWithKey, $value[3], $extension, $input['path']);
            }

            return true;
        }

        return false;
    }

    /**
     * @param  Mipo  $mipo
     * View Mipo Form
     *
     * @return Application|Factory|View
     */
    public function viewMipo(Mipo $mipo)
    {
        $mipo->load('user','region','caseIncharge','estimateEngineer','commercial');
        $data['mipo'] = $mipo;

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die("data");

        //check commercial document folder is exist or not
        $data['templateDocumentsSrcArr'] = file_view('commercial','template_'.$mipo->id, null);
        $data['poDetailDocumentsSrcArr'] = file_view('commercial','po-detail_'.$mipo->id, null);
        $data['extraCommercialDocumentsSrcArr'] = file_view('commercial','extra_'.$mipo->id, null);

        //check purchase_team document folder is exist or not
        $data['vendorPoDocumentsSrcArr'] = file_view('purchase-team', 'vendor-po_'.$mipo->id, null);
        $data['extraPurchaseDocumentsSrcArr'] = file_view('purchase-team', 'extra_'.$mipo->id, null);

        //check caseincharge  document folder is exist or not
        $type = 'caseincharge';
        $data['dclDocumentsSrcArr'] = file_view($type, 'dcl_'.$mipo->id, null);
        $data['miDocumentsSrcArr'] = file_view($type, 'mi_'.$mipo->id, null);
        $data['extraCiDocumentsSrcArr'] = file_view($type, 'extra_'.$mipo->id, null);

        //check estimator  document folder is exist or not
        $data['poCostSheetDocumentsSrcArr'] = file_view('estimator-engineer', 'po-cost-sheet_'.$mipo->id);
        $data['extraEstimatorDocumentsSrcArr'] = file_view('estimator-engineer', 'extra_'.$mipo->id);

        // Design Engineer documents
        $data['designDrawingDocumentsSrcArr'] = file_view('design-engineer', 'design-drawing_'.$mipo->id);

        //Mipo order approval sheet
        $data['orderApprovalSheetDocumentsSrcArr'] = file_view('mipo-team', 'order-approval-sheet_'.$mipo->id);

        //As Of Now No Need To Use Role Specific View, But We Might Need This In Future
        // $currentUserRoleId = session('data')['role_id'];
        // if ($currentUserRoleId == 8) // for Mipo
        // {
            $data['role'] = 'Mipo';
            // $data['caseIncharges'] = Admin::where([['role_id', 3],['status',1]])->get();
            // $data['engineers'] = Admin::where([['role_id', 5],['status',1]])->get();
            // $data['commercial'] = Admin::where([['role_id', 10],['status',1]])->get();
            // $data['purchaseTeams'] = Admin::where([['role_id', 11],['status',1]])->get();

            return view('backend/mipo/mipo_view')->with($data);
        // }
    }

    public function viewEmail($id)
    {
        if (!checkPermission('mipo_view')) {
            return redirect('/webadmin/dashboard');
        }
        $id = Crypt::decrypt($id);
        $mipo = Mipo::findOrFail($id);
        $mipo->load('user','region','caseIncharge','estimateEngineer','commercial');
        $data['mipo'] = $mipo;

        //check commercial document folder is exist or not
        $data['templateDocumentsSrcArr'] = file_view('commercial','template_'.$mipo->id, null);
        $data['poDetailDocumentsSrcArr'] = file_view('commercial','po-detail_'.$mipo->id, null);
        $data['extraCommercialDocumentsSrcArr'] = file_view('commercial','extra_'.$mipo->id, null);

        //check purchase_team document folder is exist or not
        $data['vendorPoDocumentsSrcArr'] = file_view('purchase-team', 'vendor-po_'.$mipo->id, null);
        $data['extraPurchaseDocumentsSrcArr'] = file_view('purchase-team', 'extra_'.$mipo->id, null);

        //check caseincharge  document folder is exist or not
        $type = 'caseincharge';
        $data['dclDocumentsSrcArr'] = file_view($type, 'dcl_'.$mipo->id, null);
        $data['miDocumentsSrcArr'] = file_view($type, 'mi_'.$mipo->id, null);
        $data['extraCiDocumentsSrcArr'] = file_view($type, 'extra_'.$mipo->id, null);

        //check estimator  document folder is exist or not
        $data['poCostSheetDocumentsSrcArr'] = file_view('estimator-engineer', 'po-cost-sheet_'.$mipo->id);
        $data['extraEstimatorDocumentsSrcArr'] = file_view('estimator-engineer', 'extra_'.$mipo->id);

        // Design Engineer documents
        $data['designDrawingDocumentsSrcArr'] = file_view('design-engineer', 'design-drawing_'.$mipo->id);


        return view('backend/mipo/mipo_email_view')->with($data);
    }

    public function editMipoVerification($id)
    {
        $data['mipo'] = Mipo::where('id', $id)->first();
        $user_id = session('data')['id'];
        $currentUserRoleId = session('data')['role_id'];

        //check commercial document folder is exist or not
        $data['templateDocumentsSrcArr'] = file_view('commercial', 'template_'.$id, null);
        $data['poDetailDocumentsSrcArr'] = file_view('commercial', 'po-detail_'.$id, null);
        $data['extraCommercialDocumentsSrcArr'] = file_view('commercial', 'extra_'.$id, null);

        //check purchase_team document folder is exist or not
        $data['vendorPoDocumentsSrcArr'] = file_view('purchase-team', 'vendor-po_'.$id, null);
        $data['extraPurchaseDocumentsSrcArr'] = file_view('purchase-team', 'extra_'.$id, null);

        //get caseincharge data
        $type = 'caseincharge';
        $data['dclDocumentsSrcArr'] = file_view($type, 'dcl_'.$id, null);
        $data['miDocumentsSrcArr'] = file_view($type, 'mi_'.$id, null);
        $data['extraCiDocumentsSrcArr'] = file_view($type, 'extra_'.$id, null);

        // Estimator Engineer documents
        $data['poCostSheetDocumentsSrcArr'] = file_view('estimator-engineer', 'po-cost-sheet_'.$id);
        $data['extraEstimatorDocumentsSrcArr'] = file_view('estimator-engineer', 'extra_'.$id);

        // Design Engineer documents
        $data['designDrawingDocumentsSrcArr'] = file_view('design-engineer', 'design-drawing_'.$id);

        //Mipo order approval sheet
        $data['orderApprovalSheetDocumentsSrcArr'] = file_view('mipo-team', 'order-approval-sheet_'.$id, null);

        // for mipo verification
        if ($currentUserRoleId == 8)
        {
            $data['headEngineers'] = Admin::where([['role_id',5],['is_head', 1], ['status', 1]])->get();
            $data['managementUsers'] = Admin::where([['role_id',1],['is_head', 1], ['status', 1]])->get();

            return view('backend/mipo/mipo_verification_form')->with($data);
        }

        // for estimator head verification
        if ($currentUserRoleId == 5 && $data['mipo']->head_engineer_id == $user_id)
        {
            return view('backend/mipo/estimator_head_verification_form')->with($data);
        }

        // for management user verification
        if ($currentUserRoleId == 1 && $data['mipo']->management_id == $user_id)
        {
            return view('backend/mipo/management_user_verification_form')->with($data);
        }
    }

    public function saveMipoVerification(MipoVerificationRequest $request)
    {
        $mipoId = $request->mipo_id;
        $mipo = Mipo::findOrFail($mipoId);
        $heasEnggId = $mipo->head_engineer_id;
        $input = $request->all();
            
        // MIPO Approval
        if(isset($request->mipo_approval_status) && $request->mipo_approval_status == "approve")  {

            $mipo->update([
                'head_engineer_id' => $input['head_engineer_id'],
                'head_engg_allocation_dt' => Carbon::now(),
                'mipo_verification_status' => 'accepted',
                'mipo_verification_status_dt' => Carbon::now(),
                'mipo_remarks' => $request->mipo_remarks,
            ]);

            if ($heasEnggId == 0 && ! empty($mipo->head_engineer_id)) {
                $remark = getUserData($mipo->head_engineer_id)->nick_name.' is allocated';
                addMipoCaseHistory($mipoId, 'Estimator Head', 'allocated', $remark);
                updateMipoStatus('HEV_PEN', $mipo);
                sendMipoMail('PO_ROLES_MAPPED', 'all', $mipo, $mipo->head_engineer_id);
            }

            $msg = "Mipo allocation and approved successfully";

            $remark = 'Approved by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, 'Mipo', 'approved', $remark, $request->mipo_remarks ?? '');
            successMessage($msg);
        }

        // MIPO reject
        if (isset($request->mipo_reject_status) && $request->mipo_reject_status == "rejected") {
            $msg = "Mipo Rejected successfully";
            $mipo->update([
                'mipo_verification_status'    => "rejected",
                'mipo_remarks'                => $request->mipo_remarks,
                'mipo_verification_status_dt' => Carbon::now(),
            ]);
            updateMipoStatus('MFV_REJ', $mipo);
            $remark = 'Rejected by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, 'Mipo', 'rejected', $remark, $request->mipo_remarks ?? '');
            sendMipoMail('PO_ROLES_MAPPED', 'all', $mipo, $mipo->mipo_user_id);
            successMessage($msg);
        }
    }
    
    public function saveEstimatorHeadVerification(EstimatorHeadVerificationRequest $request)
    {
        $mipoId = $request->mipo_id;
        $mipo = Mipo::findOrFail($mipoId);

        if($mipo->mipo_verification_status != "accepted"){
            $msg = "You can not approve or reject without Mipo final verification approval.";
            errorMessage($msg);
        }

        // Estimator Head Approval
        if (isset($request->head_approval_status) && $request->head_approval_status == "approve") {
            $msg = "Estimator Head verified and approved successfully";
            $mipo->update([
                'head_engg_approval_status' => 'accepted',
                'head_engg_remarks'         => $request->head_engg_remarks,
                'head_engg_status_dt'       => Carbon::now(),
            ]);
            updateMipoStatus('POS_PEN', $mipo);
            $remark = 'Approved by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, 'Estimator Head', 'approved', $remark, $request->head_engg_remarks ?? '');
            sendMipoMail('PO_APPROVED', 'all', $mipo, $mipo->mipo_user_id);

            successMessage($msg);
        }

        // Estimator Head reject
        if (isset($request->head_reject_status) && $request->head_reject_status == "rejected") {
            $msg = "Estimator Head Rejected successfully";
            $mipo->update([
                'head_engg_approval_status' => "rejected",
                'head_engg_remarks'         => $request->head_engg_remarks,
                'head_engg_status_dt'       => Carbon::now(),
            ]);
            updateMipoStatus('HEV_REJ', $mipo);
            $remark = 'Rejected by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, 'Estimator Head', 'rejected', $remark, $request->head_engg_remarks ?? '');
            sendMipoMail('PO_REJECTED', 'all', $mipo, $mipo->mipo_user_id);

            successMessage($msg);
        }
    }

    public function saveMipoOrderApprovalForm(MipoOrderSheetApprovalRequest $request)
    {
        $type = 'mipo-team';
        $mipoId = $request->mipo_id;
        $mipo = Mipo::findOrFail($mipoId);
        $managementId = $mipo->management_id;

        if($mipo->mipo_verification_status != "accepted"){
            $msg = "You can not any action before your Mipo verification approval.";
            errorMessage($msg);
        }

        $mipo->update([
            'order_sheet_remarks' => $request->order_sheet_remarks,
            'management_id' => $request->management_id,
        ]);

        if ($managementId == 0 && ! empty($mipo->management_id)) {
            $remark = getUserData($mipo->management_id)->nick_name.' is allocated';
            updateMipoStatus('MAP_PEN', $mipo);
            addMipoCaseHistory($mipoId, 'Management User', 'allocated', $remark);
            sendMipoMail('PO_ROLES_MAPPED', 'all', $mipo, $mipo->management_id);
        }

        //Mipo Order sheet Rejection
        if(isset($request->mipo_order_sheet_reject_status) && $request->mipo_order_sheet_reject_status == "rejected") {
            $mipo->update([
                'order_sheet_approval_status'    => "rejected",
                'order_sheet_status_dt'          => Carbon::now(),
                'order_approval_sheet_upload_dt' => Carbon::now(),
            ]);
            updateMipoStatus('POS_REJ', $mipo);
            $remark = 'Rejected by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, 'Mipo Team', 'rejected', $remark, $request->order_sheet_remarks ?? '');
            sendMipoMail('PO_REJECTED', 'all', $mipo, $mipo->mipo_user_id);

            $msg = "Mipo Team Order Approval Sheet rejected successfully.";

            successMessage($msg);
        }

        $input = $request->all();
        $remarkDocumentMsg = "";

        if (isset($input['mipoOrderApprovalSheetDocument']) && ! empty($input['mipoOrderApprovalSheetDocument'])) {
            $this->storeMultipleDocuments($input['mipoOrderApprovalSheetDocument'], $type, 'order-approval-sheet_'.$mipoId);
            $remarkDocumentMsg = "Total ".count($input['mipoOrderApprovalSheetDocument'])." Order Approval Sheet Docs Uploaded. ";
            

            addMipoCaseHistory($mipoId,'Mipo Team','upload',$remarkDocumentMsg);
        }

        //Mipo Order sheet Approval
        if(isset($request->mipo_order_sheet_approval_status) && $request->mipo_order_sheet_approval_status == "approve") {
            $mipo->update([
                'order_sheet_approval_status'    => "accepted",
                'order_sheet_status_dt'          => Carbon::now(),
                'order_approval_sheet_upload_dt' => Carbon::now(),
            ]);

            $remark = 'Approved by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, 'Mipo Team', 'approved', $remark, $request->order_sheet_remarks ?? '');
            sendMipoMail('PO_APPROVED', 'all', $mipo, $mipo->mipo_user_id);

            $msg = "Mipo Team Order Approval Sheet uploads and Approved successfully.";

            successMessage($msg);
        }

        $msg = "Mipo Team Order Approval Sheet uploads successfully.";

        successMessage($msg);
    }

    public function saveManagementAllocation(ManagementAllocationRequestst $request)
    {
        $input = $request->all();
        $mipoId = $input['mipo_id'];
        $mipo = Mipo::findOrFail($mipoId);
        $managementId = $mipo->management_id;

        $mipo->update([
            'management_id' => $input['management_id'],
        ]);

        if($managementId == 0 && !empty($mipo->management_id)){
            $remark = getUserData($mipo->management_id)->nick_name.' is allocated';
            addMipoCaseHistory($mipoId,'Management User','allocated',$remark);
            sendMipoMail('PO_ROLES_MAPPED', 'all', $mipo, $mipo->management_id);
        }elseif($managementId != $mipo->management_id){
            $remark = 'transferred '.getUserData($managementId)->nick_name.' to '.getUserData($mipo->management_id)->nick_name;
            addMipoCaseHistory($mipoId,'Management User','transfer',$remark);
            sendMipoMail('PO_ROLES_TRANSFER', 'all', $mipo, $mipo->management_id);
        }

        $msg = 'Mipo Management User Allocation successfully';

        successMessage($msg);
    }

    public function saveManagementVerification(ManagementVerificationRequest $request)
    {
        $mipoId = $request->mipo_id;
        $mipo = Mipo::findOrFail($mipoId);

        if($mipo->order_sheet_approval_status != "accepted"){
            $msg = "You can not approve or reject without Mipo order sheet approval.";
            errorMessage($msg);
        }

        // Management Approval
        if (isset($request->management_approval_status) && $request->management_approval_status == "approve") {
            $msg = "Management verified and approved successfully";
            $mipo->update([
                'management_approval_status' => 'accepted',
                'management_remarks'         => $request->management_remarks,
                'management_status_dt'       => Carbon::now(),
            ]);
            updateMipoStatus('POC', $mipo);
            $remark = 'Approved by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, 'Management', 'approved', $remark, $request->management_remarks ?? '');
            sendMipoMail('PO_APPROVED', 'all', $mipo, $mipo->mipo_user_id);
            successMessage($msg);
        }

        // Management reject
        if (isset($request->management_reject_status) && $request->management_reject_status == "rejected") {
            $msg = "Management Rejected successfully";
            $mipo->update([
                'management_approval_status' => "rejected",
                'management_remarks'         => $request->management_remarks,
                'management_status_dt'       => Carbon::now(),
            ]);
            updateMipoStatus('MAP_REJ', $mipo);
            $remark = 'Rejected by '.session('data')['nick_name'];
            addMipoCaseHistory($mipoId, 'Management', 'rejected', $remark, $request->management_remarks ?? '');
            sendMipoMail('PO_REJECTED', 'all', $mipo, $mipo->mipo_user_id);
            successMessage($msg);
        }
    }

    /**
     * @param $mipoId
     * View mipo reassign function
     *
     * @return Application|Factory|View
     */
    public function mipoReassign($mipoId)
    {
        $mipo = Mipo::findOrFail($mipoId);
        $userIdArray = [
            $mipo->case_incharge_id,
            $mipo->engineer_id,
            $mipo->commercial_id,
            $mipo->purchase_id ?? '',
        ];
        $userLists = Admin::with('role')->whereIn('id', $userIdArray)->get();
        $userListArray = [];
        foreach ($userLists as $key => $user) {
            $userListArray[$user->id] = $user->nick_name.' - '.$user->role->role_name ?? '';
        }
        $data['mipo'] = $mipo->load('region');
        $data['userListArray'] = $userListArray;

        return view('backend/mipo/mipo_reassign')->with($data);
    }

    /**
     * @param  Request  $request
     *
     * mipo reassign function 
     */
    public function saveMipoReassignDetails(Request $request)
    {
        $msg_data = [];

        $validator = \Validator::make($request->all(), [
            'user_id' => 'required',
        ], [
            'user_id.required' => 'The mipo user  field is required.',
        ]);     
        
        $validateMipoErrors = $validator->errors();

        if (count($validateMipoErrors)) {
            \Log::error("Po Validation Exception: ".implode(", ", $validateMipoErrors->all()));
            errorMessage(implode("\n", $validateMipoErrors->all()), $msg_data);
        } 
        
        $input = $request->all();  
        $mipo = Mipo::find($input['mipo_id'] ?? '');
        $currentUserRoleName = Role::where('id',session('data')['role_id'])->first()->role_name ?? '';
        $transferUserRoleName = '';
        if ($mipo) {
            if ($input['user_id'] == $mipo->case_incharge_id) {
                $mipo->update([
                    'ci_document_upload_dt' => null,
                    'ci_remarks' => null,
                    'ci_approval_status'    => 'pending',
                ]);
                $transferUserRoleName = Role::where('id', Admin::find($mipo->case_incharge_id)
                            ->role_id ?? '')->first()->role_name ?? '';
                $sendMailRoleId = $mipo->case_incharge_id;
            }
            if ($input['user_id'] == $mipo->engineer_id) {
                $mipo->update([
                    'engg_document_upload_dt' => null,
                    'engg_remarks' => null,
                    'engg_approval_status'    => 'pending',
                ]);
                $transferUserRoleName = Role::where('id', Admin::find($mipo->engineer_id)
                            ->role_id ?? '')->first()->role_name ?? '';
                $sendMailRoleId = $mipo->engineer_id;
            }
            if ($input['user_id'] == $mipo->commercial_id) {
                $mipo->update([
                    'commercial_document_upload_dt' => null,
                    'commercial_remarks' => null,
                    'commercial_approval_status'    => 'pending',
                ]);
                $transferUserRoleName = Role::where('id', Admin::find($mipo->commercial_id)
                            ->role_id ?? '')->first()->role_name ?? '';
                $sendMailRoleId = $mipo->commercial_id;
            }
            if ($input['user_id'] == $mipo->purchase_id ?? '') {
                $mipo->update([
                    'purchase_document_upload_dt' => null,
                    'purchase_remarks' => null,
                    'purchase_approval_status'    => 'pending',
                ]);
                $transferUserRoleName = Role::where('id', Admin::find($mipo->purchase_id)
                            ->role_id ?? '')->first()->role_name ?? '';
                $sendMailRoleId = $mipo->purchase_id;
            }
            $remark = 'reassigned po  the '.$transferUserRoleName.' by '.$currentUserRoleName;
            addMipoCaseHistory($mipo->id, $currentUserRoleName, 'reverify', $remark);
            if ($sendMailRoleId) {
                sendMipoMail('PO_REVERIFY', 'all', $mipo, $sendMailRoleId);
            }
            
            // null all head teams approval status and remarks
            $mipo->update([
                'mipo_verification_status'       => 'pending',
                'mipo_remarks'                   => '',
                'head_engg_status_dt'            => '',
                'head_engg_approval_status'      => 'pending',
                'head_engg_remarks'              => '',
                'order_approval_sheet_upload_dt' => '',
                'order_sheet_status_dt'          => '',
                'order_sheet_approval_status'    => 'pending',
                'order_sheet_remarks'            => '',
                'management_status_dt'           => '',
                'management_approval_status'     => 'pending',
                'management_remarks'             => '',
            ]);
        }   

        successMessage('Mipo Reassign successfully.');
    }

    public function mipoReportView()
    {
        $data['regions'] = Region::where([['status', 1]])->get();
        $data['products'] = Product::where([['status', 1]])->get();
        $data['mipoStatus'] = MipoStatus::where([['status', 1]])->get();
        $data['roleId'] = session('data')['role_id'];

        return view('backend.reports.mipo_report_form')->with($data);
    }

    public function generateMipoReport(Request $request)
    {
        $validationErrors = \Validator::make(
            $request->all(),
            [
                'daterange' => 'required',
            ],
            [
                'daterange.required' => 'Please select date',
            ]
        )->errors();

        if (count($validationErrors)) {
            \Log::error("Category Validation Exception: ".implode(", ", $validationErrors->all()));

            return redirect()->route('mipo_report')->with('status', implode("\n", $validationErrors->all()));
        }
        $start_date = Carbon::parse(now())->format('Y-m-d');
        $end_date = Carbon::parse(now())->format('Y-m-d');

        if (isset($request->daterange) && ! empty($request->daterange)) {
            $string = explode('-', $request->daterange);
            $start_date = Carbon::createFromFormat('d/m/Y', trim($string[0]))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($string[1]))->format('Y-m-d');
        }
        $datediff = strtotime($end_date) - strtotime($start_date);
        $days = round($datediff / (60 * 60 * 24));
        $report_max_days = config('global.MAX_DAYS.MAX_ENQ_REP_DAYS');

        if ($days > $report_max_days) {
            return redirect()->route('mipo_report')->with('status', __('report.days_count_exceed'));
        }

        return Excel::download(new MipoReportExport($request), 'Data MIPO - '.Carbon::now().'.xlsx');
    }

    public function addMipoEnquiry()
    {
        $data['products'] = Product::where('status', '1')->get();
        $data['engineers'] = Admin::where([['role_id', 5], ['status', 1]])->get();
        $data['case_incharge'] = Admin::where([['role_id', 3], ['status', 1]])->get();

        return view('backend/mipo/add_mipo_enquiry_form', $data);
    }

    public function saveMipoEnquiry(Request $request)
    {
        $region_id = Admin::where([
            ['status', '1'],
            ['id', $request->case_incharge_id]
        ])->value('region_id');

        $typist_status = TypistStatus::where('typist_status_name', 'MIPO-QTD')->first();
        $engineer_status = EngineerStatus::where('engineer_status_name', 'MIPO-EST')->first();

        $enquiry = new Enquiry();
        $currentDate = Carbon::parse(now())->format('Y-m-d');

        $financial_year = get_finacial_year_range();

        //get max enq_no from db as per region and date
        $maxEnqNo = get_max_enq_no($region_id, $financial_year);
        $newEnqNo = $maxEnqNo + 1;
        $enquiry->enq_no = getFormatid($newEnqNo);
        $enquiry->enq_recv_date = $currentDate;
        $enquiry->enq_register_date = $currentDate;
        $enquiry->enq_due_date = $currentDate;
        $enquiry->enq_reminder_date = $currentDate;
        $enquiry->client_name = $request->client_name;
        $enquiry->project_name = $request->project_name;
        $enquiry->product_id = $request->product_id;
        $enquiry->region_id = $region_id;
        $enquiry->case_incharge_id = $request->case_incharge_id;
        $enquiry->sales_remark = $request->sales_remark;
        $enquiry->engineer_id = $request->engineer_id;
        $enquiry->engineer_status = $engineer_status->id ?? 'MIPO-EST';
        $enquiry->typist_status = $typist_status->id ?? 'MIPO-QTD';
        $enquiry->save();

        $enquiry->enquires = getEnquiriesListing($request->client_name,$request->region_id);

        successMessage('Enquiry added successfully', array($enquiry));
        return redirect()->back();
    }
}
