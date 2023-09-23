<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">
                                        Region Financial Year Approval: #{{$region->region_name}}
                                    </h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                        <div class="card-body">
                            <form id="saveAbpCeoApprovalForm" method="post" action="save_abp_ceo_approval_form">
                                <input type="hidden" name="region_id" id="regionId" value="{{ $region->id ?? '' }}">
                                @csrf
                                <ul class="nav nav-tabs" role="tablist">
                                    {{-- Abp Deatils Tab Link--}}
                                    <li class="nav-item">
                                        <a href="#abp_details" role="tab" id="abp_details-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="abp_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Financial Year Details</span>
                                        </a>
                                    </li>
                                    {{-- Ceo Approval Link--}}
                                    <li class="nav-item">
                                        <a href="#abp_ceo_approval" role="tab" id="abp_ceo_approval-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="abp_ceo_approval" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Ceo Approval</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade mt-2 show active" id="abp_details" role="tabpanel"
                                         aria-labelledby="abp_details-tab">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered">
                                                        <tr>
                                                            <td><strong>Product</strong></td>
                                                            <td><strong>Sales</strong></td>
                                                            <td><strong>Net Margin</strong></td>
                                                            <td><strong>Product Count</strong></td>
                                                            <td><strong>Credit Days</strong></td>
                                                        </tr>
                                                        @if(isset($abp_financial_year_data['expected']))
                                                            <tr>
                                                                <td colspan="5" class="text-center">Expected</td>
                                                            </tr>
                                                            @foreach($abp_financial_year_data['expected'] as $abp_data)
                                                                <tr>
                                                                    <td><strong>{{$abp_data->product_name}}</strong></td>
                                                                    <td>{{number_format($abp_data->sales_sum,2)}}</td>
                                                                    <td>{{number_format($abp_data->net_margin_sum,2)}}</td>
                                                                    <td>{{$abp_data->product_count}}</td>
                                                                    <td>{{number_format($abp_data->total_credit_days_sum,2)}}</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td><strong>Total Expected</strong></td>
                                                                <td><strong>{{number_format($abp_financial_year_data['expected']->sum('sales_sum'),2)}}</strong></td>
                                                                <td><strong>{{number_format($abp_financial_year_data['expected']->sum('net_margin_sum')/count($abp_financial_year_data['expected']),2)}}</strong></td>
                                                                <td><strong>{{$abp_financial_year_data['expected']->sum('product_count')}}</strong></td>
                                                                <td><strong>{{number_format($abp_financial_year_data['expected']->sum('total_credit_days_sum'),2)}}</strong></td>                                                    </tr>
                                                        @endif
                                                        @if(isset($abp_financial_year_data['miscellaneous']))
                                                            <tr>
                                                                <td colspan="5" class="text-center">MISC</td>
                                                            </tr>
                                                            @foreach($abp_financial_year_data['miscellaneous'] as $abp_data)
                                                                <tr>
                                                                    <td><strong>{{$abp_data->product_name}}</strong></td>
                                                                    <td>{{number_format($abp_data->sales_sum,2)}}</td>
                                                                    <td>{{number_format($abp_data->net_margin_sum,2)}}</td>
                                                                    <td>{{$abp_data->product_count}}</td>
                                                                    <td>{{number_format($abp_data->total_credit_days_sum,2)}}</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td><strong>Total MISC</strong></td>
                                                                <td><strong>{{number_format($abp_financial_year_data['miscellaneous']->sum('sales_sum'),2)}}</strong></td>
                                                                <td><strong>{{number_format($abp_financial_year_data['miscellaneous']->sum('net_margin_sum')/count($abp_financial_year_data['miscellaneous']),2)}}</strong></td>
                                                                <td><strong>{{$abp_financial_year_data['miscellaneous']->sum('product_count')}}</strong></td>
                                                                <td><strong>{{number_format($abp_financial_year_data['miscellaneous']->sum('total_credit_days_sum'),2)}}</strong></td>
                                                            </tr>
                                                        @endif
                                                        @if(isset($abp_financial_year_data['new']))
                                                            <tr>
                                                                <td colspan="5" class="text-center">New</td>
                                                            </tr>
                                                            @foreach($abp_financial_year_data['new'] as $abp_data)
                                                                <tr>
                                                                    <td><strong>{{$abp_data->product_name}}</strong></td>
                                                                    <td>{{number_format($abp_data->sales_sum,2)}}</td>
                                                                    <td>{{number_format($abp_data->net_margin_sum,2)}}</td>
                                                                    <td>{{$abp_data->product_count}}</td>
                                                                    <td>{{number_format($abp_data->total_credit_days_sum,2)}}</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td><strong>Total New</strong></td>
                                                                <td><strong>{{number_format($abp_financial_year_data['new']->sum('sales_sum'),2)}}</strong></td>
                                                                <td><strong>{{number_format($abp_financial_year_data['new']->sum('net_margin_sum')/count($abp_financial_year_data['new']),2)}}</strong></td>
                                                                <td><strong>{{$abp_financial_year_data['new']->sum('product_count')}}</strong></td>

                                                                <td><strong>{{number_format($abp_financial_year_data['new']->sum('total_credit_days_sum'),2)}}</strong></td>                                                    </tr>
                                                        @endif
                                                        <tr>
                                                            <td colspan="5" class="text-center">Total Export</td>
                                                        </tr>
                                                        @foreach($abp_financial_year_total_data as $abp_data)
                                                            <tr>
                                                                <td><strong>{{$abp_data->product_name}}</strong></td>
                                                                <td>{{number_format($abp_data->sales_sum,2)}}</td>
                                                                <td>{{number_format($abp_data->net_margin_sum,2)}}</td>
                                                                <td>{{$abp_data->product_count}}</td>
                                                                <td>{{number_format($abp_data->total_credit_days_sum,2)}}</td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td><strong>Total Export</strong></td>
                                                            <td><strong>{{number_format($abp_financial_year_total_data->sum('sales_sum'),2)}}</strong></td>
                                                            <td><strong>{{count($abp_financial_year_total_data) != 0 ? number_format($abp_financial_year_total_data->sum('net_margin_sum')/count($abp_financial_year_total_data),2) : 0.00}}</strong></td>                                                        <td><strong>{{$abp_financial_year_total_data->sum('product_count')}}</strong></td>

                                                            <td><strong>{{number_format($abp_financial_year_total_data->sum('total_credit_days_sum'),2)}}</strong></td>                                                    </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">    
                                                    <button type="button" class="btn btn-success" onclick="submitForm('saveAbpCeoApprovalForm','post')">Approve</button>
                                                    <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                    "btn btn-outline-danger  py-1 font-weight-bolder">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade mt-2" id="abp_ceo_approval" role="tabpanel"
                                         aria-labelledby="abp_ceo_approval-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <label>Approval Remarks<span class="text-danger"></span></label>
                                                <textarea class="form-control" id="ceo_approval_remark" name="ceo_approval_remark" rows="4"></textarea><br/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <button type="button" class="btn btn-success" onclick="submitForm('saveAbpCeoApprovalForm','post')">Approve</button>
                                                    <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                    "btn btn-outline-danger  py-1 font-weight-bolder">Cancel</a>    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 

