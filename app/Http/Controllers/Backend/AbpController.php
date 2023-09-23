<?php

namespace App\Http\Controllers\Backend;

use App\Models\AbpProbability;
use App\Models\AbpVarianceRemark;
use App\Exports\AbpTrackerReportExport;
use Carbon\Carbon;
use App\Models\Abp;
use App\Models\Admin;
use App\Models\Region;
use App\Models\Product;
use App\Models\PaymentTerm;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\DataTables;
use App\Models\AbpReviewHistory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\AbpFormRequest;
use Illuminate\Contracts\View\Factory;
use App\Exports\AbpWeeklyReportExport;
use App\Exports\AbpVarianceReportExport;
use App\Exports\AbpOverallSummaryReportExport;
use App\Http\Requests\AbpReviewRemarkRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class AbpController extends Controller
{
    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (!checkPermission('abp')) {
            return redirect('/webadmin/dashboard');
        }   
        $data['role_id'] = session('data')['role_id'];
        $data['user_id'] = session('data')['id'];
        $data['abp_add'] = checkPermission('abp_add');
        $data['enquires'] = getEnquiriesListing();
        $data['products'] = Product::where('status', 1)
            ->get(['id', 'product_name']);
        $data['regions'] = Region::where([['status', 1]])->get();
        $data['case_incharges'] = Admin::where([['status', 1],['role_id',3]])->get();

        if ($data['role_id'] == 1) {
            $data['abp_add'] = false;
        }

        return view('backend/abp/index', compact('data'));
    }

    /**
     * @param  Request  $request
     *
     *
     * @return Application|ResponseFactory|Response
     */
    public function fetch(Request $request)
    {
        $role_id = session('data')['role_id'];
        $user_id = session('data')['id'];

        if ($request->ajax()) {
            try {
                $query = Abp::with('product:id,product_name');

                if ($role_id != 1) {
                    $query->where('status', '1');
                }

                if ($role_id == 3) { // For Case Incharge
                    $query->where('case_incharge_id', $user_id)->where('status', '1');
                }
                $query->orderBy('id', 'desc')->get();

                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_product']) && !is_null($request['search']['search_product'])) {
                            $query->where('product_id', $request['search']['search_product']);
                        }
                        if (isset($request['search']['search_region']) && !is_null($request['search']['search_region'])) {
                            $query->where('region_id', $request['search']['search_region']);
                        }
                        if (isset($request['search']['search_time']) && !is_null($request['search']['search_time'])) {
                            $month = explode('-', $request['search']['search_time'])[0];
                            $year = explode('-', $request['search']['search_time'])[1];
                            $query->where(function ($query) use ($year, $month) {
                                $query->whereYear('time_budget', $year)
                                    ->whereMonth('time_budget', $month);
                            });
                        }
                        if (isset($request['search']['search_ci']) && !is_null($request['search']['search_ci'])) {
                            $query->where('case_incharge_id', $request['search']['search_ci']);
                        }
                        $query->get();
                    })
                    ->editColumn('product_id', function ($event) {
                        return $event->product->product_name;
                    })
                    ->editColumn('client_name', function ($event) {
                        return strtoupper($event->client_name);
                    })
//                    ->editColumn('region_id', function ($event) {
//                        return strtoupper($event->region->region_name ?? '');
//                    })
                    ->editColumn('ci_id', function ($event) {
                        return strtoupper($event->caseIncharge->nick_name ?? '');
                    })
                    ->editColumn('net_margin_budget', function ($event) {
                        return $event->net_margin_budget;
                    })
                    ->editColumn('order_value_budget', function ($event) {
                        return $event->order_value_budget;
                    })
                    ->editColumn('credit_days_budget', function ($event) {
                        return $event->credit_days_budget;
                    })
                    ->editColumn('time_budget', function ($event) {
                        return Carbon::parse($event->time_budget)->format('M Y');
                    })
                    ->editColumn('action', function ($event) use ($role_id, $user_id) {
                        $abp_delete = checkPermission('abp_delete');
                        $abp_view = checkPermission('abp_view');
                        $abp_edit = checkPermission('abp_edit');
                        $abp_review = checkPermission('abp_review');
                        $actions = '<span style="white-space:nowrap;">';

                        $loginUser = Admin::where('id',$user_id)->first();

                        if ($abp_view) {
                            $actions .= '<a href="abp_view/' . $event->id . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Abp Details" title="View"><i class="fa fa-eye"></i></a>';
                        }

                        if ($abp_edit && $event->ceo_approval != 1 && $role_id != 1) {
                            $actions .= ' <a href="abp_edit/' . $event->id . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }

                        if ($abp_edit && $event->ceo_approval == 1 && $role_id != 1) {
                            $actions .= ' <a href="abp_edit/' . $event->id . '" class="btn btn-info btn-sm src_data" title="Reviewal Process"><i class="fa fa-edit"></i></a>';
                        }

                        if (($role_id == 1 && $loginUser->is_head == 1 && $event->ceo_approval == 1) || ($role_id != 1 && $abp_review && $event->ceo_approval == 1)) {
                            $actions .= ' <a href="abp_review/' . $event->id . '" class="btn btn-info btn-sm src_data" title="Reviewal Remark Process"><i class="fa fa-plus"></i></a>';
                        }

                        if ($abp_delete) {
                            $actions .= ' <a data-option="" data-url="abp_delete/' . $event->id . '" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                        }
                        $actions .= '</span>';

                        return $actions;
                    })
                    ->addIndexColumn()
                    ->make(true);
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
     *
     *
     * @return Application|Factory|View
     */
    public function abpForm()
    {
        $data = [];
        $user_id = session('data')['id'];
        $data['enquires'] = getEnquiriesListing();
        $data['products'] = Product::where('status', 1)->get(['id', 'product_name']);
        $data['payment_terms'] = PaymentTerm::orderBy('id', 'asc')->get();
        $data['regions'] = Region::where([['status', 1]])->get();
        $user = Admin::where('id', $user_id)->first();

        if (!empty($user)) {
            $data['userRegion'] = $user->region_id;
        }

        return view('backend/abp/abp_form')->with($data);
    }

    public function saveAbpDetails(AbpFormRequest $request)
    {
        $user_id = session('data')['id'];
        $input = $request->all();
        $input['abp_id'] = $input['abp_id'] ?? '';

        $carbonDefaultDate = Carbon::createFromFormat('m-Y', $input['time_budget'])->firstOfMonth();
        $formattedDefaultDate = $carbonDefaultDate->format('Y-m-d');
        $input['time_budget'] = $formattedDefaultDate;

        $result = [];
        $totalPercentage = 0;
        $creditDays = 0;

        for ($i = 0; $i < count($input['payment_terms']); $i++) {
            $paymentTermId = $input['payment_terms'][$i];
            $paymentType = PaymentTerm::find($paymentTermId);
            $paymentValue = number_format($input['payment_percentage'][$i], 2);
            
            // Check if payment term id already exists in the result array
            $index = null;
            foreach ($result as $key => $term) {
                if ($term['payment_term_id'] === $paymentTermId) {
                    $index = $key;
                    break;
                }
            }

            if ($index !== null) {
                // If it exists, update the payment value by adding the new value
                $result[$index]['payment_value'] += $paymentValue;
                $result[$index]['payment_value'] = number_format($result[$index]['payment_value'],2);
            
            } else {
                // If it doesn't exist, create a new entry in the result array
                $term = [
                    "payment_term_id" => $paymentTermId,
                    "payment_type" => $paymentType->payment_terms,
                    "payment_value" => $paymentValue,
                ];
                $result[] = $term;
            }

            $totalPercentage += $input['payment_percentage'][$i];
            $creditDays += (($paymentType->no_of_days * $input['payment_percentage'][$i]) / 100);
        }

        if($totalPercentage != 100){
            errorMessage('Payment Percentage total must be 100.');
        }
        $input['credit_days_budget'] = number_format($creditDays,2);
        $input['time_expected'] = $input['time_budget'];
        
        $paymentTermsJsonData = json_encode(["payment_terms" => $result]);

        $input['payment_terms_budget'] = $paymentTermsJsonData;

        if ($input['abp_id']) {
            $msg = 'Abp updated successfully';
            $abp = Abp::find($input['abp_id']);
            $input['updated_by'] = $user_id;
            $abp->update($input);
        } else {
            $msg = 'Abp created successfully';
            $input['case_incharge_id'] = $user_id;
            $user = Admin::where('id', $user_id)->first();
            $input['ip_address'] = $request->ip();
            $input['call_from'] = "Web";
            $input['created_by'] = $user_id;

            $abp = Abp::create($input);
        }

        successMessage($msg);
    }

    /**
     * @param  Abp  $abp
     *
     *
     * @return Application|Factory|View
     */
    public function editAbp(Abp $abp)
    {
        $data = [];
        $user_id = session('data')['id'];
        $currentUserRoleId = session('data')['role_id'];
        $data['enquires'] = getEnquiriesListing();
        $data['products'] = Product::where('status', 1)
            ->get(['id', 'product_name']);
        $data['payment_terms'] = PaymentTerm::orderBy('id', 'asc')->get();
        $data['probabilities'] = AbpProbability::orderBy('id', 'asc')->get();
        $data['varianceRemarks'] = AbpVarianceRemark::orderBy('id', 'asc')->get();
        $data['abp'] = $abp;
        $data['regions'] = Region::where([['status', 1]])->get();

        $data['payment_terms_data'] = json_decode($abp->payment_terms_budget);

        if (($currentUserRoleId == 3 && $abp->ceo_approval == 1) || ($currentUserRoleId == 1 && $abp->ceo_approval == 1)) { // for Case incharge and admin
            $latestAbpHistory = $abp->abpReviewHistories()->latest()->first();

            if(!empty($latestAbpHistory)){
                $data['abp_data']['time_expected'] = $latestAbpHistory['time_expected'];
                $data['abp_data']['remark_time_expected'] = $latestAbpHistory['remark_time_expected'];
                $data['abp_data']['reason_id'] = $latestAbpHistory['reason_id'];
                $data['abp_data']['probability'] = $latestAbpHistory['probability'];
                $data['abp_data']['net_margin_expected'] = $latestAbpHistory['net_margin_expected'];
                $data['abp_data']['order_value_expected'] = $latestAbpHistory['order_value_expected'];
                $data['abp_data']['credit_days_expected'] = $latestAbpHistory['credit_days_expected'];
                $data['abp_data']['payment_terms_expected'] = json_decode($latestAbpHistory['payment_terms_expected']);
            } else {
                $data['abp_data']['time_expected'] = $abp->time_expected;
                $data['abp_data']['probability'] = 0;
                $data['abp_data']['reason_id'] =  0;
                $data['abp_data']['remark_time_expected'] = '';
                $data['abp_data']['net_margin_expected'] = $abp->net_margin_budget;
                $data['abp_data']['order_value_expected'] = $abp->order_value_budget;
                $data['abp_data']['credit_days_expected'] = $abp->credit_days_budget;
                $data['abp_data']['payment_terms_expected'] = $data['payment_terms_data'];
            }

            return view('backend/abp/abp_after_approval_form')->with($data);
        } else {
            return view('backend/abp/abp_form')->with($data);
        }

        return view('backend/abp/abp_form')->with($data);
    }

    /**
     * @param $id
     *
     *
     */
    public function deleteAbp($id)
    {
        $abp = Abp::where('id', $id)->first();
        $abp->delete();

        successMessage('Data Deleted successfully', []);
    }

    public function preparePaymentTerm()
    {
        $data['payment_terms'] = PaymentTerm::orderBy('id', 'asc')->get();

        $returnValue =  view('backend/abp/prepare_payment_terms')->with($data)->render();

        return \Illuminate\Support\Facades\Response::json($returnValue);
    }

    public function saveAfterApprovalAbpDetails(Request $request)
    {
        $msg_data = [];
        $user_id = session('data')['id'];
        $input = $request->all();
        $msg = "Abp updated successfully.";

        $input['call_from'] = 'Web';
        $input['ip_address'] = $request->ip();
        $input['created_by'] = $user_id;
        $input['updated_by'] = $user_id;
        $carbonDefaultDate = Carbon::createFromFormat('m-Y', $input['time_expected'])->firstOfMonth();
        $formattedDefaultDate = $carbonDefaultDate->format('Y-m-d');
        $input['time_expected'] = $formattedDefaultDate;

        $result = [];
        $totalPercentage = 0;
        $creditDays = 0;

        for ($i = 0; $i < count($input['payment_terms']); $i++) {
            $paymentTermId = $input['payment_terms'][$i];
            $paymentType = PaymentTerm::find($paymentTermId);
            $paymentValue = number_format($input['payment_percentage'][$i], 2);

            // Check if payment term id already exists in the result array
            $index = null;
            foreach ($result as $key => $term) {
                if ($term['payment_term_id'] === $paymentTermId) {
                    $index = $key;
                    break;
                }
            }

            if ($index !== null) {
                // If it exists, update the payment value by adding the new value
                $result[$index]['payment_value'] += $paymentValue;
                $result[$index]['payment_value'] = number_format($result[$index]['payment_value'],2);

            } else {
                // If it doesn't exist, create a new entry in the result array
                $term = [
                    "payment_term_id" => $paymentTermId,
                    "payment_type" => $paymentType->payment_terms,
                    "payment_value" => $paymentValue,
                ];
                $result[] = $term;
            }

            $totalPercentage += $input['payment_percentage'][$i];
            $creditDays += (($paymentType->no_of_days * $input['payment_percentage'][$i]) / 100);
        }

        if($totalPercentage != 100){
            errorMessage('Payment Percentage total must be 100.');
        }
        $input['credit_days_expected'] = number_format($creditDays,2);
            
        $paymentTermsJsonData = json_encode(["payment_terms" => $result]);

        $input['payment_terms_expected'] = $paymentTermsJsonData;

        $latestAbpHistory = AbpReviewHistory::where('abp_id',$input['abp_id'])->latest()->first();

        if(!empty($latestAbpHistory)){
            $oldValueArr = [
                'time_expected' =>  $latestAbpHistory->time_expected,
                'probability' =>  $latestAbpHistory->probability,
                'reason_id' =>  $latestAbpHistory->reason_id,
                'net_margin_expected' =>  $latestAbpHistory->net_margin_expected,
                'order_value_expected' =>  $latestAbpHistory->order_value_expected,
                'payment_terms_expected' =>  $latestAbpHistory->payment_terms_expected,
            ];
        }else{
            $abp = Abp::where('id',$input['abp_id'])->first();
            $oldValueArr = [
                'time_expected' =>  $abp->time_budget,
                //                'remark_time_expected' => null,
                'probability' => 0,
                'reason_id' =>  0,
                'net_margin_expected' =>  $abp->net_margin_budget,
                'order_value_expected' =>  $abp->order_value_budget,
                'payment_terms_expected' =>  $abp->payment_terms_budget,
            ];
        }

        $newValueArr = [
            'time_expected' => $input['time_expected'],
            //            'remark_time_expected' =>  $input['remark_time_expected'],
            'probability' => isset($input['probability']) ? $input['probability'] : 0,
            'reason_id' => isset($input['reason_id']) ? $input['reason_id'] : 0,
            'net_margin_expected' =>  number_format($input['net_margin_expected'],2),
            'order_value_expected' =>  number_format($input['order_value_expected'],2),
            'payment_terms_expected' =>  $paymentTermsJsonData,
        ];

        $differences = array_diff_assoc($newValueArr, $oldValueArr);

        if (count($differences) === 0) {
            errorMessage("No values have changed.");
        }

        $validator = \Validator::make($request->all(), [
            'remark_time_expected' => 'required',
            'reason_id' => 'required',
        ],[
            'remark_time_expected.required' => 'Reason For Change field is required',
            'reason_id.required' => 'Reason For Variance field is required',
        ])->errors();

        if (count($validator)) {
            \Log::error("ABP Validation Exception: ".implode(", ", $validator->all()));
            errorMessage(implode("\n", $validator->all()), $msg_data);
        }

        if (count($validator)) {
            $errorMessage = 'Reason For Change field is required';

            \Log::error("Abp Create Review Validation Exception: " . $errorMessage);
            errorMessage($errorMessage, $msg_data);
        }

        try {
            AbpReviewHistory::create($input);

            $abp = Abp::find($input['abp_id']);
            $abp->update([
                'time_expected' => $input['time_expected']
            ]);

        }catch (\Exception $e) {
            \Log::error("Something Went Wrong. Abp Error: ".$e->getMessage());

            $errorMsg = "Something went wrong";

            errorMessage($errorMsg);
        }

        successMessage($msg);
    }

    public function viewAbp(Abp $abp)
    {
        if (!checkPermission('abp_view')) {
            return redirect('/webadmin/dashboard');
        }
        $data['abp'] = $abp;
        $data['abpVariance'] = AbpReviewHistory::where('abp_id', $abp->id)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();
        
        return view('backend/abp/abp_view')->with($data);
    }

    public function reviewAbp(Abp $abp)
    {
        $data = [];
        $data['abp'] = $abp;

        $latestAbpHistory = $abp->abpReviewHistories()->latest()->first();

        $data['firstVariance'] = AbpReviewHistory::where('abp_id',$abp->id)->whereNotNull('ceo_reviewal_remark')->latest()->first();
        
        $existRemarkVariance = AbpReviewHistory::where('abp_id',$abp->id)->latest()->first();
        if(!empty($existRemarkVariance) && $existRemarkVariance->ceo_reviewal_remark == null){
            $data['currentVariance'] = AbpReviewHistory::where('abp_id',$abp->id)->whereNull('ceo_reviewal_remark')->latest()->first();
        }

        if(!empty($latestAbpHistory)){
            $data['abp_data']['time_expected'] = $latestAbpHistory['time_expected'];
            $data['abp_data']['probability'] = $latestAbpHistory['probability'];
            $data['abp_data']['remark_time_expected'] = $latestAbpHistory['remark_time_expected'];
            $data['abp_data']['net_margin_expected'] = $latestAbpHistory['net_margin_expected'];
            $data['abp_data']['order_value_expected'] = $latestAbpHistory['order_value_expected'];
            $data['abp_data']['credit_days_expected'] = $latestAbpHistory['credit_days_expected'];
            $data['abp_data']['payment_terms_expected'] = json_decode($latestAbpHistory['payment_terms_expected']);
            $data['abp_data']['ceo_reviewal_remark'] = $latestAbpHistory->ceo_reviewal_remark;
        } else {
            $data['abp_data']['time_expected'] = $abp->time_expected;
            $data['abp_data']['net_margin_expected'] = $abp->net_margin_budget;
            $data['abp_data']['order_value_expected'] = $abp->order_value_budget;
            $data['abp_data']['credit_days_expected'] = $abp->credit_days_budget;
            $data['abp_data']['payment_terms_expected'] = json_decode($abp->payment_terms_budget);
            $data['abp_data']['ceo_reviewal_remark'] = '';
        }

        return view('backend/abp/abp_reviewal_remark_form')->with($data);

    }

    public function saveReviewRemarkProcess(AbpReviewRemarkRequest $request)
    {
        $msg = "Abp Reviewal Remark updated successfully.";
        $input = $request->all();
        $latestAbpHistory = AbpReviewHistory::where('abp_id',$input['abp_id'])->latest()->first();

        if(!empty($latestAbpHistory) && !empty($input['ceo_reviewal_remark'])){
            $latestAbpHistory->update([
                'ceo_reviewal_remark' => $input['ceo_reviewal_remark'],
                'ceo_reviewal_date' => Carbon::now()
            ]);
        }

        successMessage($msg);

    }

    public function abpReportView()
    {
        $data['regions'] = Region::where([['status', 1]])->get();
        $data['roleId'] = session('data')['role_id'];
        
        return view('backend.reports.abp_report_form')->with($data);
    }

    public function generateAbpReport(Request $request)
    {
        $validationErrors = \Validator::make(
            $request->all(),
            [
                'daterange' => 'required',
            ],
            [
                'daterange.required' => 'Please select Month',
            ]
        )->errors();

        if (count($validationErrors)) {
            \Log::error("Abp Variance Validation Exception: ".implode(", ", $validationErrors->all()));

            return redirect(url('webadmin/abp_report'))->with('status', implode("\n", $validationErrors->all()));
        }
        ini_set('memory_limit', '1024M');
        $regionId = $request->region_id ?? '';
        $regionName = Region::where('id', $regionId)->first()->region_name ?? '';
        if (
            isset($request->daterange) && ! empty($request->daterange)
        ) {
            $date = '01-'.$request->daterange;
            $selectDate = Carbon::parse($date)->format('Y-m-d');
        }

        $data['fileName'] = Carbon::parse($selectDate)->monthName ?? '';

        // get abp budget type new,expected and time budget , time expected both are same
        $data['abpVarianceTypeA'] = $this->abpVarianceReportQuery($selectDate, '=', $regionId, ['new', 'expected']);

        // get abp budget type new,expected and time expected is delay
        $data['abpVarianceTypeB'] = $this->abpVarianceReportQuery($selectDate, '>', $regionId, ['new', 'expected']);


        // get abp budget type new,expected and time expected is early
        $data['abpVarianceTypeC'] = $this->abpVarianceReportQuery($selectDate, '<', $regionId, ['new', 'expected']);

        // get abp budget miscellaneous
        $data['abpVarianceTypeD'] = $this->abpVarianceReportQuery($selectDate, '', $regionId, ['miscellaneous']);

        return Excel::download(new AbpVarianceReportExport($data),
            $regionName.' '.'ABP Variance '.Carbon::now().'.xlsx');

    }

    public function abpVarianceReportQuery($selectDate, $operator, $regionId, $budgetType)
    {
        $session_data = session('data');
        $userId = $session_data['id'];
        $roleId = $session_data['role_id'];
        $userFieldName = '';
        if ($roleId == 3) {
            $userFieldName = 'abp.case_incharge_id';
        }

        return Abp::with([
            'region', 'abpReviewLatestOneHistory', 'enquiry.region',
            'enquiry.category', 'enquiry.industry',
        ])
            ->where('abp.time_expected', $selectDate)
            ->when(! empty($userFieldName) && in_array($roleId, [1, 7]),
                function ($query) use ($userFieldName, $userId) {
                    $query->where($userFieldName, $userId);
                })->when(! empty($operator), function ($query) use ($operator, $selectDate) {
                $query->where('abp.time_budget', $operator, $selectDate);
            })
            ->when(! empty($regionId), function ($query) use ($regionId) {
                $query->where('abp.region_id', $regionId);
            })
            ->whereIn('product_id', config('global.ABP_VARIANCE_REPORT_PRODUCT'))
            ->whereIn('budget_type', $budgetType)
            ->join('products', 'products.id', '=', 'abp.product_id')
            ->select('abp.*', 'products.product_name AS product_name')
            ->get()
            ->groupBy('product_name');
    }

    /**
     * @author Syed Mohammed Taqi <mohammed.s@mypcot.com>
     * Created On : 23 aug 2022
     * Uses : This will load abp weekly report form.
     */
    public function abpWeeklyReport()
    {
        $data['products'] = Product::where([['status', 1]])->get();
        $data['ci'] = Admin::where([['role_id', 3]])->get();
        $data['roleId'] = session('data')['role_id'];

        return view('backend/reports/abp_weekly_report_form', $data);
    }

    // generate weekly report
    public function generateAbpWeeklyReport(Request $request)
    {
        ini_set('memory_limit', '512M');
        $role_id = session('data')['role_id'];
        $abp_weekly_data = array();
        $validationErrors = $this->validateReport($request);

        if (count($validationErrors)) {
            \Log::error("Export ABP Weekly Report Validation Exception: " . implode(", ", $validationErrors->all()));

            // errorMessage(implode("\n", $validationErrors->all()), $msg_data);
            return redirect()->route('abp_weekly_report')->with('status', implode("\n", $validationErrors->all()));
        }

        if (!empty($request->date_range)) {
            $string = explode('-', $request->date_range);
            $start_date = date('Y-m-d', strtotime(trim(str_replace('/', '-', $string[0]))));
            $end_date = date('Y-m-d', strtotime(trim(str_replace('/', '-', $string[1]))));
        }
        $interval_dates = [];
        $days = (int) config('global.ABP_WEEKLY_INTERVAL_DAYS');

        for ($date = strtotime($start_date); $date <= strtotime($end_date); $date = strtotime("+{$days} day", $date)) {
            $interval_dates[] = date('Y-m-d', $date);
        }

        $session_data = session('data');
        $userId = $session_data['id'];
        $roleId = $session_data['role_id'];
        $userFieldName = '';
        if ($roleId == 3) {
            $userFieldName = 'abp.case_incharge_id';
        }
        $abp = Abp::with('caseIncharge', 'product')->where([
            ['created_at', '>=', $start_date],
            ['created_at', '<=', $end_date],
            ['status', '1'],
        ])->when(! empty($userFieldName) && in_array($roleId, [1, 7]), function ($query) use ($userFieldName, $userId) {
            $query->where($userFieldName, $userId);
        })
            ->when(isset($request->product_id) && ! empty($request->product_id), function ($query) use ($request) {
                return $query->where('product_id', $request->product_id);
            })->when(isset($request->ci_id) && ! empty($request->ci_id), function ($query) use ($request) {
                return $query->where('case_incharge_id', $request->ci_id);
            });
        $abp_weekly_data = $abp->get();
        $report_data = array();
        $case_dates = array();

        if (!empty($abp_weekly_data)) {
            $ceo_details = Admin::where([
                ['role_id', $role_id],
                ['is_head', '1'],
                ['status', '1'],
            ])->first();
            $total_reviews = 0;

            foreach ($abp_weekly_data->toArray() as $key => $abp_report) {
                $report_data[$abp_report['id']] = $abp_report;
                $case_history = AbpReviewHistory::where([
                    ['abp_id', $abp_report['id']],
                    ['status', '1'],
                ])->whereNotNull('ceo_reviewal_date')
                    ->orderBy('created_at', 'DESC')
                    ->get()->take(config('global.ABP_WEEKLY_REPORT_PREVIOUS_ROW_LIMIT'))->toArray();

                if (count($case_history) > $total_reviews) {
                    $total_reviews = count($case_history);
                }
                array_walk($case_history, function ($val, $key) use (&$case_dates) {
                    $case_dates[] = $val['ceo_reviewal_date'];
                }, $case_dates);
                $report_data[$abp_report['id']]['case_history'] = $case_history;
                $latest_record = AbpReviewHistory::where([
                    ['abp_id', $abp_report['id']],
                    ['status', '1'],
                ])->latest()->first();
                $latest_record_dates = $latest_record->created_at ?? '';

                $report_data[$abp_report['id']]['latest_record'] = (!empty($latest_record)) ? $latest_record->toArray() : array();
            }
        }
        $excel_data['ceo_details'] = $ceo_details->toArray();
        $excel_data['case_history_dates'] = array_filter(array_unique($case_dates));
        $excel_data['report_data'] = array_values($report_data);
        $excel_data['date_range'] = $request->date_range;
        $excel_data['total_reviews'] = $total_reviews;

        // $da = view('backend/reports/abp_weekly_report_excel', ['abp_weekly_data' => $excel_data])->render();

        // echo "<pre>";
        // print_r($da);
        // echo "</pre>";
        // die("da");

        return Excel::download(new AbpWeeklyReportExport($excel_data), 'ABP Weekly Report - ' . Carbon::now() . '.xlsx');
    }

    public function abpOverallSummaryReport()
    {
        $data['products'] = Product::where([['status', 1]])->get();
        $data['ci'] = Admin::where([['role_id', 3]])->get();

        return view('backend/reports/abp_overall_summary_report_form', $data);
    }

    // generate Overall Summary report
    public function generateAbpOverallSummaryReport(Request $request)
    {
        ini_set('memory_limit', '512M');
        $msg_data = array();
        $msg = "";
        $abp_weekly_data = array();
        $validationErrors = $this->validateReport($request);

        if (count($validationErrors)) {
            \Log::error("Export ABP overall summary Report Validation Exception: ".implode(", ",
                    $validationErrors->all()));

            return redirect()->route('abp_overall_summary_report')->with('status',
                implode("\n", $validationErrors->all()));
        }

        if (! empty($request->date_range)) {
            $string = explode('-', $request->date_range);
            $start_date = date('Y-m-d', strtotime(trim(str_replace('/', '-', $string[0]))));
            $end_date = date('Y-m-d', strtotime(trim(str_replace('/', '-', $string[1]))));
        }
        $interval_dates = [];
        $session_data = session('data');
        $userId = $session_data['id'];
        $roleId = $session_data['role_id'];
        $userFieldName = '';
        if ($roleId == 3) {
            $userFieldName = 'abp.case_incharge_id';
        }
        // $days = (int) config('global.ABP_WEEKLY_INTERVAL_DAYS');
        $abp = Abp::with('caseIncharge', 'product')
            ->when(! empty($userFieldName) && in_array($roleId, [1, 7]),
                function ($query) use ($userFieldName, $userId) {
                    $query->where($userFieldName, $userId);
                })
            ->where([
                ['created_at', '>=', $start_date],
                ['created_at', '<=', $end_date],
                ['status', '1'],
            ]);
        $overall_summary_data = $abp->get();

        // echo "<pre>";
        // print_r($overall_summary_data->toArray());
        // echo "</pre>";
        // die("Debug");
        return Excel::download(new AbpOverallSummaryReportExport($overall_summary_data),
            'ABP Overal Summary Report - '.Carbon::now().'.xlsx');
    }

    private function validateReport(Request $request)
    {
        return \Validator::make(
            $request->all(),
            [
                'date_range' => 'required',
            ],
            [
                'date_range.required' => 'Please select date',
            ]
        )->errors();

    }

    /**
     * View abp tracker report form
     *
     * @return Application|Factory|View
     */
    public function abpTrackerReportView()
    {
        $data['regions'] = Region::where([['status', 1]])->get();

        return view('backend.reports.abp_tracker_report')->with($data);
    }

    /**
     * @param  Request  $request
     *
     * Export abp tracker report excel function
     * @return BinaryFileResponse
     */
    public function exportAbpTrackerReport(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $regionId = $request->region_id ?? '';
        $data['regionName'] = Region::where('id', $regionId)->first()->region_name ?? '';
        $startDate = getFinancialYearStartDate();
        $endDate = getFinancialYearEndDate();
        $data['headingName'] = 'ABP FY '.Carbon::parse($startDate)->isoFormat('YYYY').'-'.Carbon::parse($endDate)->isoFormat('YY');

        $data['fileName'] = 'ABP Tracker';
        $data['trackerData'] = $this->abpTrackerDataQuery($startDate, $endDate, $regionId);
        $data['ciBudgetData'] = $this->abpTrackerCIDataQuery($startDate, $endDate, $regionId);

        return Excel::download(new AbpTrackerReportExport($data),
            'ABP Tracker '.Carbon::now().'.xlsx');

    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $regionId
     *
     * @return mixed
     */
    public function abpTrackerDataQuery($startDate, $endDate, $regionId)
    {
        $session_data = session('data');
        $userId = $session_data['id'];
        $roleId = $session_data['role_id'];
        $userFieldName = '';
        if ($roleId == 3) {
            $userFieldName = 'abp.case_incharge_id';
        }

        return Abp::whereBetween('time_budget', [$startDate, $endDate])
            ->when(! empty($userFieldName) && in_array($roleId, [1, 7]),
                function ($query) use ($userFieldName, $userId) {
                    $query->where($userFieldName, $userId);
                })
            ->when(isset($regionId) && ! empty($regionId), function ($query) use ($regionId) {
                return $query->where('abp.region_id', $regionId);
            })
            ->whereIn('product_id', config('global.ABP_VARIANCE_REPORT_PRODUCT'))
            ->join('products', 'products.id', '=', 'abp.product_id')
            ->selectRaw('abp.budget_type, products.product_name, sum(abp.order_value_budget) as sales_sum')
            ->selectRaw('abp.budget_type, products.product_name, sum(abp.net_margin_budget) as net_margin_sum')
            ->selectRaw('abp.budget_type, products.product_name,(sum(abp.order_value_budget) * (sum(abp.net_margin_budget) + 10)) / 100 as calculated_margin_rs')
            ->selectRaw('abp.budget_type, products.product_name, sum(abp.credit_days_budget) as total_credit_days_sum')
            ->groupBy(['abp.budget_type', 'products.product_name'])
            ->get()
            ->groupBy('budget_type');
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $regionId
     *
     * @return mixed
     */
    public function abpTrackerCIDataQuery($startDate, $endDate, $regionId)
    {
        $session_data = session('data');
        $userId = $session_data['id'];
        $roleId = $session_data['role_id'];
        $userFieldName = '';
        if ($roleId == 3) {
            $userFieldName = 'abp.case_incharge_id';
        }

        return Abp::whereBetween('time_budget', [$startDate, $endDate])
            ->when(! empty($userFieldName) && in_array($roleId, [1, 7]),
                function ($query) use ($userFieldName, $userId) {
                    $query->where($userFieldName, $userId);
                })
            ->when(isset($regionId) && ! empty($regionId), function ($query) use ($regionId) {
                return $query->where('abp.region_id', $regionId);
            })
            ->whereIn('product_id', config('global.ABP_VARIANCE_REPORT_PRODUCT'))
            ->join('products', 'products.id', '=', 'abp.product_id')
            ->join('admins', 'admins.id', '=', 'abp.case_incharge_id')
            ->selectRaw('admins.nick_name, abp.budget_type, sum(abp.order_value_budget) as sales_sum')
            ->selectRaw('admins.nick_name, abp.budget_type, sum(abp.net_margin_budget) as net_margin_sum')
            ->selectRaw('admins.nick_name, abp.budget_type,(sum(abp.order_value_budget) * sum(abp.net_margin_budget)) / 100 as calculated_margin_rs')
            ->selectRaw('admins.nick_name, abp.budget_type, sum(abp.credit_days_budget) as total_credit_days_sum')
            ->selectRaw('products.product_name as product_name')
            ->groupBy(['admins.nick_name', 'abp.budget_type', 'products.product_name'])
            ->get()
            ->groupBy(['nick_name', 'budget_type']);

    }
}
