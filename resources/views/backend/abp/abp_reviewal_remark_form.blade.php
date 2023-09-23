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
                                        Reviewal Process ABP: # {{$abp->product->product_name}} / {{$abp->order_value_budget}} / {{$abp->region_id}}
                                    </h5>
                                </div> 
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                        <div class="card-body">
                            <form id="saveAbpReviewRemarkForm" method="post" action="save_abp_review_remark">
                                <input type="hidden" name="abp_id" id="abpId" value="{{ $abp->id ?? '' }}">
                            @csrf
                            <ul class="nav nav-tabs" role="tablist">
                                {{-- Abp Deatils Tab Link--}}
                                <li class="nav-item">
                                    <a href="#abp_details" role="tab" id="abp_details-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="abp_details" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <span class="">Approved Details</span>
                                    </a>
                                </li>
                                {{-- Abp Time Expected Link--}}
                                <li class="nav-item">
                                    <a href="#abp_time_expected" role="tab" id="abp_time_expected-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="abp_time_expected" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <span class="">Variance Details</span>
                                    </a>
                                </li>
                                {{-- Ceo reviewal Remarks Link--}}
                                <li class="nav-item">
                                    <a href="#abp_reviewal_remarks" role="tab" id="abp_reviewal_remarks-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="abp_reviewal_remarks" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <span class="">Reviewal Remarks</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade mt-2 show active" id="abp_details" role="tabpanel"
                                     aria-labelledby="abp_details-tab">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped table-bordered">
                                                <tr>
                                                    <td><strong>CI</strong></td>
                                                    <td>{{ $abp->caseIncharge->nick_name ?? ''}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Product</strong></td>
                                                    <td>{{ $abp->product->product_name ?? '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Client</strong></td>
                                                    <td>{{ $abp->client_name ?? '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Region</strong></td>
                                                    <td>{{ $abp->region->region_name ?? '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Budget Type</strong></td>
                                                    <td>{{ $abp->budget_type ? strtoupper($abp->budget_type) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Budget Remarks</strong></td>
                                                    <td>{{ $abp->remarks_budget ?? '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Net Margin</strong></td>
                                                    <td>{{ $abp->net_margin_budget ?? '-'  }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Order Value</strong></td>
                                                    <td>{{ $abp->order_value_budget ?? '-'  }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Time Budget</strong></td>
                                                    <td>{{ $abp->time_budget ? \Carbon\Carbon::parse($abp->time_budget)->format('M Y') : '-'  }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Enquiry</strong></td>
                                                    <td>{{ $abp->enquiry ? $abp->enquiry->enq_no : '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Ceo Approval</strong></td>
                                                    <td>{{ $abp->ceo_approval ? 'Approved' : '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Ceo Approval Date</strong></td>
                                                    <td>{{ $abp->ceo_approval_date ?? '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Ceo Approval Remark</strong></td>
                                                    <td>{{ $abp->ceo_approval_remark ?? '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Credit Days</strong></td>
                                                    <td>{{ $abp->credit_days_budget ?? '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Created At</strong></td>
                                                    <td>{{ $abp->created_at ? date('d-m-Y H:i:s', strtotime($abp->created_at)) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Payment Terms</strong></td>
                                                    <td><strong>Percentage</strong></td>
                                                </tr>
                                                <?php
                                                $payment_terms_data = json_decode($abp->payment_terms_budget)
                                                ?>
                                                @foreach($payment_terms_data->payment_terms as $key => $paymentTermBudget)
                                                    <?php
                                                    $payment_terms_value = "-";
                                                    $payment_term_days = \App\Models\PaymentTerm::where('id',$paymentTermBudget->payment_term_id)->first();
                                                    if(!empty($payment_term_days)){
                                                        $payment_terms_value = $payment_term_days->payment_terms;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>{{ $payment_terms_value ?? '-' }}</td>
                                                        <td>{{ $paymentTermBudget->payment_value ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success" onclick="submitForm('saveAbpReviewRemarkForm','post')">Submit</button>
                                                <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                "btn btn-outline-danger  py-1 font-weight-bolder">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="abp_time_expected" role="tabpanel"
                                     aria-labelledby="abp_time_expected-tab">

                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i>  Abp Details</h5>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <colgroup>
                                                        <col style="width: 25%">
                                                        <col style="width: 25%">
                                                        <col style="width: 25%">
                                                        <col style="width: 25%">
                                                    </colgroup>
                                                    <tr>
                                                        <td><strong>Label</strong></td>
                                                        <td><strong>Approved</strong></td>
                                                        <td><strong>Variance 1</strong></td>
                                                        <td><strong>Current Variance</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Time</strong></td>
                                                        <td>{{ $abp->time_budget ? \Carbon\Carbon::parse($abp->time_budget)->format('M Y') : '-'  }}</td>
                                                        <td>{{ isset($firstVariance) && $firstVariance->time_expected ? \Carbon\Carbon::parse( $firstVariance->time_expected)->format('M Y') : '-'  }}</td>
                                                        <td>{{ isset($currentVariance) &&  $currentVariance->time_expected ? \Carbon\Carbon::parse($currentVariance->time_expected)->format('M Y') : '-'  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Order Value</strong></td>
                                                        <td>{{$abp->order_value_budget ?? '-'}}</td>
                                                        <td>{{isset($firstVariance) ? $firstVariance->order_value_expected : '-'}}</td>
                                                        <td>{{isset($currentVariance) ? $currentVariance->order_value_expected : '-'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Net Margin</strong></td>
                                                        <td>{{$abp->net_margin_budget ?? '-'}}</td>
                                                        <td>{{isset($firstVariance) ? $firstVariance->net_margin_expected : '-'}}</td>
                                                        <td>{{ isset($currentVariance) ? $currentVariance->net_margin_expected : '-'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Payment Terms</strong></td>
                                                        <?php
                                                        $abpPaymentTerms = [];
                                                        
                                                        foreach (json_decode($abp->payment_terms_budget)->payment_terms as $key => $paymentTermBudget) {
                                                            $payment_terms_value = "-";
                                                            $abpPaymentTerms[] = $paymentTermBudget->payment_value . '% ' . $paymentTermBudget->payment_type;
                                                        }

                                                        $abpPaymentTermsString = implode(', ', $abpPaymentTerms);
                                                        $firstVarianceTermsString = '-';
                                                        if(isset($firstVariance)){

                                                            $firstVariancePaymentTerms = [];

                                                            foreach (json_decode( $firstVariance->payment_terms_expected)->payment_terms as $key => $paymentTermBudget) {
                                                                $payment_terms_value = "-";

                                                                $firstVariancePaymentTerms[] = $paymentTermBudget->payment_value . '% ' . $paymentTermBudget->payment_type;
                                                            }

                                                            $firstVarianceTermsString = implode(', ', $firstVariancePaymentTerms);
                                                        }

                                                        $currentVarianceTermsString = '-';
                                                        if(isset($currentVariance)){

                                                            $currentVariancePaymentTerms = [];

                                                            foreach (json_decode( $currentVariance->payment_terms_expected)->payment_terms as $key => $paymentTermBudget) {
                                                                $payment_terms_value = "-";
                                                                $currentVariancePaymentTerms[] = $paymentTermBudget->payment_value . '% ' . $paymentTermBudget->payment_type;
                                                            }

                                                            $currentVarianceTermsString = implode(', ', $currentVariancePaymentTerms);
                                                        }

                                                        ?>
                                                        <td>{{$abpPaymentTermsString}}</td>
                                                        <td>{{$firstVarianceTermsString}}</td>
                                                        <td>{{$currentVarianceTermsString}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Credit Days</strong></td>
                                                        <td>{{$abp->credit_days_budget ?? '-'}}</td>
                                                        <td>{{ isset($firstVariance) ? $firstVariance->credit_days_expected : '-'}}</td>
                                                        <td>{{isset($currentVariance) ? $currentVariance->credit_days_expected : '-'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Reason For Change</strong></td>
                                                        <td>-</td>
                                                        <td>{{$firstVariance->remark_time_expected ?? '-'}}</td>
                                                        <td>{{$currentVariance->remark_time_expected ?? '-'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>CI Remark Date</strong></td>
                                                        <td>-</td>
                                                        <td>{{ isset($firstVariance) ? $firstVariance->created_at : '-'}}</td>
                                                        <td>{{ isset($currentVariance) ? $currentVariance->created_at : '-'}}</td>
                                                    </tr>  
                                                    <tr>
                                                        <td><strong>Ceo Remarks</strong></td>
                                                        <td>{{$abp->ceo_approval_remark ?? '-'}}</td>
                                                        <td>{{ isset($firstVariance) ? $firstVariance->ceo_reviewal_remark : '-'}}</td>
                                                        <td>-</td>    
                                                    </tr>
                                                    <tr>    
                                                        <td><strong>Ceo Remark Date</strong></td>
                                                        <td>{{$abp->ceo_approval_date ?? '-'}}</td>
                                                        <td>{{ isset($firstVariance) ? $firstVariance->ceo_reviewal_date : '-'}}</td>
                                                        <td>-</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success" onclick="submitForm('saveAbpReviewRemarkForm','post')">Submit</button>
                                                <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                "btn btn-outline-danger  py-1 font-weight-bolder">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="abp_reviewal_remarks" role="tabpanel"
                                     aria-labelledby="abp_reviewal_remarks-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <strong>Previous Remarks Date</strong>
                                            <dd>{{ isset($firstVariance) && $firstVariance->ceo_reviewal_date  ? $firstVariance->ceo_reviewal_date : '-'}}</dd>
                                        </div>
                                        <div class="col-12 my-3">
                                            <strong>Previous Remarks</strong>
                                            <dd>{{ isset($firstVariance) && $firstVariance->ceo_reviewal_remark  ? $firstVariance->ceo_reviewal_remark : '-'}}</dd>
                                        </div>
                                        <div class="col-12">
                                            <label>Reviewal Remarks<span class="text-danger"></span></label>
                                            <textarea class="form-control" id="ceo_reviewal_remark" name="ceo_reviewal_remark" rows="4"></textarea><br/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12"> 
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success" onclick="submitForm('saveAbpReviewRemarkForm','post')">Submit</button>
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
 

