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
                                        @if(isset($abp))
                                            Edit ABP: # {{$abp->product->product_name}} / {{$abp->order_value_budget}} / {{$abp->region->region_name ?? '-'}}
                                        @else
                                            Add ABP
                                        @endif
                                    </h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                        <div class="card-body">
                            <form id="saveAbpData" method="post" action="save_abp_details">
                            <input type="hidden" name="abp_id" id="abpId" value="{{ $abp->id ?? '' }}">
                                @csrf
                                <ul class="nav nav-tabs" role="tablist">
                                    {{-- Abp Deatils Tab Link--}}
                                    <li class="nav-item">
                                        <a href="#abp_details" role="tab" id="abp_details-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="abp_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Abp Details</span>
                                        </a>
                                    </li>
                                    {{-- Abp Time Expected Link--}}
                                    <li class="nav-item">
                                        <a href="#abp_payment_terms" role="tab" id="abp_payment_terms-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="abp_payment_terms" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Payment Terms Details</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade mt-2 show active" id="abp_details" role="tabpanel"
                                         aria-labelledby="abp_details-tab">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Product<span class="text-danger">*</span></label>
                                                <select class="select2 required" id="product_id" name="product_id" style="width: 100% !important;">
                                                    <option value="">Select Product</option>@foreach($products as $product)
                                                        <option value="{{$product->id}}" {{ (isset($abp) && $abp->product_id == $product->id ) ? 'selected' : '' }}>{{ $product->product_name }}</option>
                                                    @endforeach
                                                </select><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Client<span class="text-danger">*</span></label>
                                                <input class="form-control required" type="text" id="client_name" name="client_name"
                                                       value="{{ $abp->client_name ?? '' }}" autocomplete="off"> <br>
                                                <div id="clientList" class="col-sm-10"></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Region<span style="color:#ff0000">*</span></label>
                                                <select class="select2" id="region_id" name="region_id" {{ !empty($userRegion) || !empty($abp->region_id) ? 'disabled' : '' }} style="width: 100% !important;">
                                                    <option value="">Select Region</option>
                                                @foreach($regions as $region)
                                                        <option value="{{$region->id}}" {{ (isset($abp) && $abp->region_id == $region->id || (isset($userRegion) && $userRegion == $region->id)  ) ? 'selected' : '' }}>{{ $region->region_name }}</option>
                                                    @endforeach
                                                </select><br/><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Budget Type<span style="color:#ff0000">*</span></label>
                                                <select class="select2 required" id="budget_type" name="budget_type"
                                                        style="width: 100% !important;">
                                                    @if(isset($abp))
                                                        <option value="new" {{ $abp->budget_type == 'new' ? 'selected' : '' }}>  NEW </option>
                                                        <option value="expected" {{ $abp->budget_type == 'expected' ? 'selected' : '' }}> EXPECTED </option>
                                                        <option value="miscellaneous" {{ $abp->budget_type == 'miscellaneous' ? 'selected' : '' }}> MISCELLANEOUS </option>
                                                    @else
                                                        <option value="new" selected>NEW</option>
                                                        <option value="expected">EXPECTED</option>
                                                        <option value="miscellaneous">MISCELLANEOUS</option>
                                                    @endif
                                                </select><br/><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Net Margin<span class="text-danger">*</span></label>
                                                <input class="form-control required" type="number" id="net_margin_budget" name="net_margin_budget" value="{{ $abp->net_margin_budget ?? '' }}" min="0" max="100" step="0.01" oninput="validatePercentage(this)"><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Order Value<span class="text-danger">*</span></label>
                                                <input class="form-control required" type="number" id="order_value_budget" name="order_value_budget" value="{{ $abp->order_value_budget ?? '' }}" oninput="validateAmount(this)"><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Time<span class="text-danger">*</span></label>
                                                <input class="form-control required" type="text" id="time_budget" name="time_budget" value="{{ isset($abp) && $abp->time_budget ? \Carbon\Carbon::parse($abp->time_budget)->format('m-Y') : '' }}" autocomplete="off">
                                                <br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Enquiry</label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <select class="select2" id="enquiry_id" style="width: 100% !important;" name="enquiry_id">
                                                            <option value="">Enquiry</option>
                                                            @foreach($enquires as $enquire)
                                                                <option value="{{$enquire->id}}" {{ (isset($abp) && $abp->enquiry_id == $enquire->id) ? 'selected' : '' }}>{{ $enquire->enq_no.' / '. $enquire->region_code ." / ". $enquire->revision_no }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </fieldset>
                                                <input type="hidden" name="abp_id" value="{{ $abp->id ?? '' }}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Remarks<span class="text-danger">*</span></label>
                                                <textarea class="form-control required" id="remarks_budget" name="remarks_budget">{{ $abp->remarks_budget ?? '' }}</textarea><br/>
                                                <br/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <button type="button" class="btn btn-success" onclick="submitForm('saveAbpData','post')">Submit</button>
                                                    <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1"> Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade mt-2" id="abp_payment_terms" role="tabpanel"
                                         aria-labelledby="abp_payment_terms-tab">

                                        @if(isset($abp))
                                            <div class="append-div">
                                                @foreach($payment_terms_data->payment_terms as $key => $paymentTermBudget)
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
                                        @else
                                            <div class="append-div">
                                                <div class="row payment_term_div">
                                                    <div class="col-3">
                                                        <label>Payment Terms<span class="text-danger">*</span></label>
                                                        <select class="select2 required"  name="payment_terms[]" style="width: 100%">
                                                            @foreach($payment_terms as $payment_term)
                                                                <option value="{{$payment_term->id}}" data-payment-days="{{$payment_term->no_of_days}}" class="payment_days">{{ $payment_term->payment_terms}}</option>
                                                            @endforeach
                                                        </select>                                                </div>
                                                    <div class="col-3">
                                                        <label>Percentage<span class="text-danger">*</span></label>
                                                        <input class="form-control required payment_value" type="number"  name="payment_percentage[]" oninput="validatePercentage(this)"><br/>
                                                    </div>
                                                    <div class="col-1">
                                                        <br>
                                                        <div class="py-1">
                                                            <a href="javascript:void(0)" class="btn btn-info btn-sm add_payment_term_item"><i class="fa fa-plus"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="col-3 my-auto">
                                                        <h6>Your Credit Days is <strong class="credit_days">0</strong>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <button type="button" class="btn btn-success" onclick="submitForm('saveAbpData','post')">Submit</button>
                                                    <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1"> Cancel</a>
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

    $(document).ready(function(){
        $('#client_name').keyup(function(){
            var query = $(this).val();

            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('enquiry_form.autoData') }}",
                    method:'post',
                    data:{query:query,_token:_token},
                    success:function(data) {
                        if (data) {
                            $("#clientList").show();
                            $('#clientList').html(data);
                            document.getElementsByClassName("autoData")[0].addEventListener("click",(e)=>{
                                let text=e.target.innerText
                                if(text){
                                    document.getElementById("client_name").value=text;
                                }
                                $("#clientList").hide();
                            })
                            $("#client_name").click(function(){
                                $("#clientList").show();
                            });
                        } else {
                            $("#clientList").hide();
                        }
                    }
                });
            } else {
                $("#clientList").hide();
            }
        });

        $("#client_name").on("blur", function() {
            $("body").click(function(e) {
                if(e.target.id !== 'clientList'){
                    $("#clientList").hide();
                }
            });
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

        $('#time_budget').datepicker({
            format: "mm-yyyy",
            startView: "months",
            minViewMode: "months",
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
