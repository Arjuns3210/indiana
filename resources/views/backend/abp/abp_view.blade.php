<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    @if(isset($abp))
                                        <h5 class="pt-2">View ABP: #{{$abp->product->product_name}} / {{$abp->order_value_budget}} / {{$abp->region->region_name ?? '-'}}</h5>
                                    @endif
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                {{-- Abp Details Tab Link--}}
                                <li class="nav-item">
                                    <a href="#abp_details" role="tab" id="abp_details-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="abp_details" aria-selected="true">
                                        <i class="ft-info mr-1"></i>
                                        <span class="d-none d-sm-block">Approved Details</span>
                                    </a>
                                </li>
                                {{-- Payment Terms Details Tab Link--}}
                                @if(count($abpVariance))
                                    <li class="nav-item">
                                        <a href="#latest_review_details" role="tab" id="latest_review_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="latest_review_details" aria-selected="true">
                                            <i class="ft-info mr-1"></i>
                                            <span class="d-none d-sm-block">Variance Details</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade mt-2 show active" id="abp_details" role="tabpanel" aria-labelledby="abp_details-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <td><strong>Case Incharge</strong></td>
                                                        <td>{{ $abp->caseIncharge->nick_name ?? '-'}}</td>
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
                                                        <td><strong>Net Margin</strong></td>
                                                        <td>{{ $abp->net_margin_budget ?? '-'  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Order Value</strong></td>
                                                        <td>{{ $abp->order_value_budget ?? '-'  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Time</strong></td>
                                                        <td>{{ $abp->time_budget ? \Carbon\Carbon::parse($abp->time_budget)->format('M Y') : '-'  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Enquiry</strong></td>
                                                        <td>{{ isset($abp->enquiry) ? $abp->enquiry->enq_no . " / " . $abp->region->region_code . " / " . $abp->enquiry->revision_no : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Remarks</strong></td>
                                                        <td>{{ $abp->remarks_budget ?? '-'}}</td>
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
                                                        $payment_terms = \App\Models\PaymentTerm::where('id',$paymentTermBudget->payment_term_id)->first();

                                                        if (!empty($payment_terms)) {
                                                            $payment_terms_value = $payment_terms->payment_terms;
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td><strong> {{ $payment_terms_value }} </strong></td>
                                                        <td>{{ $paymentTermBudget->payment_value }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="latest_review_details" role="tabpanel" aria-labelledby="latest_review_details-tab">
                                    @if(count($abpVariance))
                                        @foreach($abpVariance as $key => $variance)
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i>Variance Details {{ $key + 1 }} ( {{ $variance->created_at ? date('d-m-Y H:i:s', strtotime($variance->created_at)) : '-' }} )</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered">
                                                        <tr>
                                                            <td style="width: 37.66%;"><strong>Time Expected</strong></td>
                                                            <td>{{ $variance->time_expected ? \Carbon\Carbon::parse($variance->time_expected)->format('M Y') : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Probability</strong></td>
                                                            <td>{{ $variance->abpProbability->probability ?? '-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Reason For Variance</strong></td>
                                                            <td>{{ $variance->reason->reason	 ?? '-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Reason For Change</strong></td>
                                                            <td>{{ $variance->remark_time_expected	 ?? '-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Net Margin</strong></td>
                                                            <td>{{ $variance->net_margin_expected ?? '-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Order Value</strong></td>
                                                            <td>{{ $variance->order_value_expected ?? '-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Credit Days</strong></td>
                                                            <td>{{ $variance->credit_days_expected ?? '-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Ceo Reviewal Remark</strong></td>
                                                            <td>{{ $variance->ceo_reviewal_remark	 ?? '-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Ceo Reviewal Date</strong></td>
                                                            <td>{{ $variance->ceo_approval_date ?? '-'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Payment Terms</strong></td>
                                                            <td><strong>Percentage</strong></td>
                                                        </tr>
                                                        <?php
                                                            $payment_terms_data = json_decode($variance->payment_terms_expected)
                                                        ?>
                                                        @foreach($payment_terms_data->payment_terms as $key => $paymentTermBudget)
                                                        <?php
                                                            $payment_terms_value = "-";
                                                            $payment_terms = \App\Models\PaymentTerm::where('id',$paymentTermBudget->payment_term_id)->first();

                                                            if(!empty($payment_terms)){
                                                                $payment_terms_value = $payment_terms->payment_terms;
                                                            }
                                                        ?>
                                                        <tr>
                                                            <td><strong>{{ $payment_terms_value }}</strong></td>
                                                            <td>{{ $paymentTermBudget->payment_value }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
