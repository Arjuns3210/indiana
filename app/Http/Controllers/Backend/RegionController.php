<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CeoAbpApprovalRequest;
use App\Models\Abp;
use App\Models\AbpReviewHistory;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RegionController extends Controller
{
    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (!checkPermission('region')) {
            return redirect('/webadmin/dashboard');
        }
        $data['role_id'] = session('data')['role_id'];
        $data['regions'] = Region::where([['status', 1]])->get();

        return view('backend/region/index')->with($data);
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
                $query = Region::query();

                if ($role_id != 1) {
                    $query->where('status', '1');   
                }
                
                $query->orderBy('id', 'desc')->get();

                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_region']) && !is_null($request['search']['search_region'])) {
                            $query->where('id', $request['search']['search_region']);
                        }
                    })
                    ->editColumn('region', function ($event) {
                        return $event->region_name;
                    })
                    ->editColumn('action', function ($event) use ($role_id, $user_id) {
                        $region_view = checkPermission('region_view');
                        $region_approve = checkPermission('obp_region_approve');
                        $actions = '<span style="white-space:nowrap;">';
                        
                        if($region_view){
                            $actions .= '<a href="region_view/' . $event->id . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Region Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        
                        if($region_approve && checkRegionAbpDataExist($event->id) && checkAbpFinancialYearApproved($event->id)){
                            $actions .= ' <a href="abp_approve_edit/' . $event->id . '" class="btn btn-info btn-sm src_data" title="Ceo Approval"><i class="ft-check-circle"></i></a>'; 
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
    
    public function viewRegion($id)
    {
        $data['region'] = Region::where('id',$id)->first();
        $data['abp_financial_year_data'] = Abp::where('region_id',$id)->whereBetween('time_budget', [getFinancialYearStartDate(), getFinancialYearEndDate()])
                ->whereIn('product_id', config('global.ABP_VARIANCE_REPORT_PRODUCT'))
                ->join('products', 'products.id', '=', 'abp.product_id')
            ->selectRaw('abp.budget_type, products.product_name, count(products.id) as product_count')
            ->selectRaw('abp.budget_type, products.product_name, sum(abp.order_value_budget) as sales_sum') 
                ->selectRaw('abp.budget_type, products.product_name, sum(abp.net_margin_budget) as net_margin_sum') 
                ->selectRaw('abp.budget_type, products.product_name,(sum(abp.order_value_budget) * sum(abp.net_margin_budget)) / 100 as calculated_margin_rs')
                ->selectRaw('abp.budget_type, products.product_name, sum(abp.credit_days_budget) as total_credit_days_sum')
                ->groupBy(['abp.budget_type', 'products.product_name'])
                ->get()
                ->groupBy('budget_type');

        $data['abp_financial_year_total_data'] = Abp::where('region_id', $id)
            ->whereBetween('time_budget', [getFinancialYearStartDate(), getFinancialYearEndDate()])
            ->whereIn('product_id', config('global.ABP_VARIANCE_REPORT_PRODUCT'))
            ->join('products', 'products.id', '=', 'abp.product_id')
            ->selectRaw('products.product_name, count(products.id) as product_count')
            ->selectRaw('products.product_name, sum(abp.order_value_budget) as sales_sum')
            ->selectRaw('products.product_name, sum(abp.net_margin_budget) as net_margin_sum')
            ->selectRaw('products.product_name, (sum(abp.order_value_budget) * sum(abp.net_margin_budget)) / 100 as calculated_margin_rs')
            ->selectRaw('products.product_name, sum(abp.credit_days_budget) as total_credit_days_sum')
            ->groupBy('products.product_name')
            ->get();
        
        return view('backend/region/region_abp_financial_view')->with($data);
    }
    
    public function editAbpApprove($id)
    {
        $data['region'] = Region::where('id',$id)->first();
        $data['abp_financial_year_data'] = Abp::where('region_id',$id)->whereBetween('time_budget', [getFinancialYearStartDate(), getFinancialYearEndDate()])
            ->whereIn('product_id', config('global.ABP_VARIANCE_REPORT_PRODUCT'))
            ->join('products', 'products.id', '=', 'abp.product_id')
            ->selectRaw('abp.budget_type, products.product_name, count(products.id) as product_count')
            ->selectRaw('abp.budget_type, products.product_name, sum(abp.order_value_budget) as sales_sum')
            ->selectRaw('abp.budget_type, products.product_name, sum(abp.net_margin_budget) as net_margin_sum')
            ->selectRaw('abp.budget_type, products.product_name,(sum(abp.order_value_budget) * sum(abp.net_margin_budget)) / 100 as calculated_margin_rs')
            ->selectRaw('abp.budget_type, products.product_name, sum(abp.credit_days_budget) as total_credit_days_sum')
            ->groupBy(['abp.budget_type', 'products.product_name'])
            ->get()
            ->groupBy('budget_type');

        $data['abp_financial_year_total_data'] = Abp::where('region_id', $id)
            ->whereBetween('time_budget', [getFinancialYearStartDate(), getFinancialYearEndDate()])
            ->whereIn('product_id', config('global.ABP_VARIANCE_REPORT_PRODUCT'))
            ->join('products', 'products.id', '=', 'abp.product_id')
            ->selectRaw('products.product_name, count(products.id) as product_count')
            ->selectRaw('products.product_name, sum(abp.order_value_budget) as sales_sum')
            ->selectRaw('products.product_name, sum(abp.net_margin_budget) as net_margin_sum')
            ->selectRaw('products.product_name, (sum(abp.order_value_budget) * sum(abp.net_margin_budget)) / 100 as calculated_margin_rs')
            ->selectRaw('products.product_name, sum(abp.credit_days_budget) as total_credit_days_sum')
            ->groupBy('products.product_name')
            ->get();


        return view('backend/region/abp_ceo_approval_form')->with($data);
    }
    
    public function saveAbpCeoApproval(CeoAbpApprovalRequest $request)
    {
        $msg_data = [];
        $user_id = session('data')['id'];
        $msg = "Ceo Financial Year Approved successfully.";
        $regionId = $request->region_id ?? '';
        
        $abp_data = Abp::where('region_id',$regionId)->whereBetween('time_budget', [getFinancialYearStartDate(), getFinancialYearEndDate()])
            ->whereIn('product_id', config('global.ABP_VARIANCE_REPORT_PRODUCT'))
            ->get();

        // Begin the transaction
        DB::beginTransaction();
        
        try {
            
            foreach ($abp_data as $abp){
                $abp->update([
                    'ceo_approval' => '1',
                    'ceo_approval_remark' => $request->ceo_approval_remark,
                    'ceo_approval_date' => Carbon::now(),
                ]);
                
                AbpReviewHistory::create([
                   'abp_id' => $abp->id,
                   'net_margin_expected' => $abp->net_margin_budget,    
                   'order_value_expected' => $abp->order_value_budget,
                   'payment_terms_expected' => $abp->payment_terms_budget,
                   'credit_days_expected' => $abp->credit_days_budget,
                   'time_expected' => $abp->time_budget,
                   'call_from' => 'Web',
                   'ip_address' => $request->ip(),
                   'created_by' => $user_id,
                   'updated_by' => $user_id,
                ]);      
            }

            DB::commit();

        }catch (\Exception $e) {

            DB::rollback();

            \Log::error("Something Went Wrong. Abp Error: ".$e->getMessage());

            $errorMsg = "Something went wrong";

            errorMessage($errorMsg);
        }
        
        successMessage($msg);
    }
}
