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
                            <form id="editAbpAfterApprovalForm" method="post" action="save_after_approval_abp_details">
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
                                        <span class="">Time-Margin-Order Details</span>
                                    </a>
                                </li>
                                {{-- Abp Payment Term Expected Link--}}
                                <li class="nav-item">
                                    <a href="#abp_payment_terms_expected" role="tab" id="abp_payment_terms_expected-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="abp_payment_terms_expected" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <span class="">Payment Term Details</span>
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
                                                <button type="button" class="btn btn-success" onclick="submitForm('editAbpAfterApprovalForm','post')">Submit</button>
                                                <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                "btn btn-outline-danger  py-1 font-weight-bolder">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="abp_time_expected" role="tabpanel"
                                     aria-labelledby="abp_time_expected-tab">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Time Expected<span class="text-danger">*</span></label>
                                            <input class="form-control required" type="text" id="time_expected" name="time_expected" value="{{ isset($abp_data['time_expected']) && $abp_data['time_expected'] ? \Carbon\Carbon::parse($abp_data['time_expected'])->format('m-Y') : '' }}">
                                            <br/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Probability<span style="color:#ff0000">*</span></label>
                                            <select class="select2 required" id="probability" name="probability" style="width: 100% !important;">
                                                <option value="">Select Probability</option>
                                                @foreach($probabilities as $probability)
                                                    <option value="{{$probability->id}}" {{  $abp_data['probability'] == $probability->id ? 'selected' : '' }}>{{ $probability->probability }}</option>
                                                @endforeach
                                            </select><br/><br/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Net Margin Expected<span class="text-danger">*</span></label>
                                            <input class="form-control required" type="number" id="net_margin_expected" name="net_margin_expected" value="{{ $abp_data['net_margin_expected'] ?? '' }}" oninput="validatePercentage(this)"><br/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Order Value Expected<span class="text-danger">*</span></label>
                                            <input class="form-control required" type="number" id="order_value_expected" name="order_value_expected" value="{{ $abp_data['order_value_expected'] ?? '' }}" oninput="validateAmount(this)"><br/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Reason For Variance<span style="color:#ff0000">*</span></label>
                                            <select class="select2 required" id="reason_id" name="reason_id" style="width: 100% !important;">
                                                <option value="">Select Reason</option>
                                                @foreach($varianceRemarks as $reason)
                                                    <option value="{{$reason->id}}">{{ $reason->reason }}</option>
                                                @endforeach
                                            </select><br/><br/>
                                        </div>
                                        <div class="col-6">
                                            <label>Reason For Change<span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="remark_time_expected" name="remark_time_expected" rows="4"></textarea><br/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success" onclick="submitForm('editAbpAfterApprovalForm','post')">Submit</button>
                                                <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                "btn btn-outline-danger  py-1 font-weight-bolder">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="abp_payment_terms_expected" role="tabpanel"
                                     aria-labelledby="abp_payment_terms_expected-tab">

                                    @if(isset($abp))
                                        <div class="append-div">
                                            @foreach($abp_data['payment_terms_expected']->payment_terms as $key => $paymentTermBudget)
                                                <div class="row payment_term_div">
                                                    <div class="col-3">
                                                        @if($key == 0)
                                                            <label>Payment Terms<span class="text-danger">*</span></label>
                                                        @endif
                                                        <select class="select2 required"  name="payment_terms[]" style="width: 100%">
                                                            @foreach($payment_terms as $payment_term)
                                                                <option value="{{$payment_term->id}}" {{$payment_term->id == $paymentTermBudget->payment_term_id ? 'selected' : ''}} style="width: 100%" data-payment-days="{{$payment_term->no_of_days}}" class="payment_days">{{ $payment_term->payment_terms}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        @if($key == 0)
                                                            <label>Percentage<span class="text-danger">*</span></label>
                                                        @endif
                                                        <input class="form-control required payment_value" type="number"  name="payment_percentage[]" value="{{$paymentTermBudget->payment_value}}" oninput="validatePercentage(this)">
                                                        <br/>
                                                    </div>
                                                    <div class="col-1">
                                                        @if($key == 0)
                                                            <br>
                                                        @endif
                                                        <div class="py-1">
                                                            @if($key == 0)
                                                                <a href="javascript:void(0)" class="btn btn-info btn-sm add_payment_term_item"><i class="fa fa-plus"></i></a>
                                                            @else
                                                                <a href="javascript:void(0)" class="btn btn-danger btn-sm remove_payment_term_item"><i class="fa fa-trash"></i></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-3 my-auto">
                                                        @if($key == 0)
                                                            <h6>Your Credit Days is <strong class="credit_days">0</strong>
                                                            </h6>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                     <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success" onclick="submitForm('editAbpAfterApprovalForm','post')">Submit</button>
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
<script>
    $('.select2').select2();

    $(document).ready(function() {
        $('#time_expected').datepicker({
            format: "mm-yyyy",
            startView: "months",
            minViewMode: "months",
        });

        $('.add_payment_term_item').click(function() {
            $.ajax({
                type:'GET',
                url:'prepare_payment_term',
                success:function(data){
                    $('.append-div').append(data)
                    $('.select2').select2();
                }
            });
        });

        updateCreditDays();

        $(document).on('change keyup', 'select[name="payment_terms[]"], input[name="payment_percentage[]"]', function() {
            updateCreditDays();
        });

        $(document).on('click','.remove_payment_term_item',function (){
            $(this).closest('.payment_term_div').remove();
            updateCreditDays();
        });
        
    });

    function updateCreditDays() {
        var paymentTerms = $('.payment_term_div');
        var totalPercentage = 0;
        var creditDays = 0;

        paymentTerms.each(function() {
            var paymentValue = parseFloat($(this).find('input[name="payment_percentage[]"]').val());
            var paymentDays = parseFloat($(this).find('select[name="payment_terms[]"] option:checked').data('paymentDays'));

            totalPercentage += paymentValue;
            if(paymentValue >= 0){
                creditDays += (paymentDays * paymentValue) / 100;
            }
        });

        $('.credit_days').text(creditDays.toFixed(2));
    }
    
</script>
 

