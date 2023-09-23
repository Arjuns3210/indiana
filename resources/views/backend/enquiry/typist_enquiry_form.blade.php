<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                               <div class="col-12 col-sm-7">
                                    @if(isset($enq_details->id))
                                        @if(isset($revision))
                                        <h5 class="pt-2">Revising Enquiry: #{{$enq_details->enq_no}} / {{$enq_details->region_name}} / {{$enq_details->revision_no}}</h5>
                                        @else
                                        <h5 class="pt-2">Edit Enquiry: #{{$enq_details->enq_no}} / {{$enq_details->region_name}} / {{$enq_details->revision_no}}</h5>
                                        @endif                                    
                                    @else
                                    <h5 class="pt-2"> Add Enquiry</h5>
                                    @endif
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                             <form id="addEnquiryDetailsForm" method="post" action="saveEnquiryDetails">
                                @isset($enq_details)
                                <input type="hidden" id="enq_no" name="enq_no" value="{{$enq_details->enq_no ?? 0 ;}}">
                                @endisset
                                <input type="hidden" id="enq_id" name="id" value= @if(isset($revision)) {{$revision ? '-1' : $enq_details->id ?? '-1';}} @else {{$enq_details->id ?? '-1';}} @endif >
                                @isset($revision)
                                    <input type="hidden" name='revision' id="revision" value="revision">
                                @endisset
                                <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#enquiry_details" role="tab" id="enquiry_details-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="enquiry_details" aria-selected="true">
                                        <i class="ft-info mr-1"></i>
                                        <!-- <span class="d-none d-sm-block">Details</span> -->
                                        <span class="">Enquiry Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#category_details" role="tab" id="category_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="category_details" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <!-- <span class="d-none d-sm-block">SEO description</span> -->
                                        <span class="">Category Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#allocation_details" role="tab" id="allocation_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="allocation_details" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <!-- <span class="d-none d-sm-block">SEO description</span> -->
                                        <span class="">Allocation Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#status_details" role="tab" id="status_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="status_details" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <!-- <span class="d-none d-sm-block">SEO description</span> -->
                                        <span class="">Status Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#amount_details" role="tab" id="amount_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="amount_details" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <!-- <span class="d-none d-sm-block">SEO description</span> -->
                                        <span class="">Amount Details</span>
                                    </a>
                                </li>
                            </ul>
                                        @csrf   
                                <div class="tab-content">
                                    <div class="tab-pane fade mt-2 show active" id="enquiry_details" role="tabpanel" aria-labelledby="enquiry_details-tab">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                            <strong>Enquiry Actual Received Date</strong>
                                                            <div class="input-group">
                                                                <input type='hidden' class="form-control date required" placeholder="dd/mm/yyyy" name="enq_recv_date" id="enq_recv_date" value=@isset($enq_details) {{$enq_details->enq_recv_date ? date('Y-m-d', strtotime($enq_details->enq_recv_date)) : '';}} @endisset>
                                                            <dd>{{ $enq_details->enq_recv_date ? date('d-m-Y', strtotime($enq_details->enq_recv_date)) : '-'; }}</dd>
                                                            </div>
                                                        </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                            <strong>Enquiry Register Date</strong>
                                                            <div class="input-group">
                                                                <input type='hidden' class="form-control date required" placeholder="dd/mm/yyyy" name="enq_register_date" id="enq_register_date" value=@isset($enq_details) {{$enq_details->enq_register_date ? date('Y-m-d', strtotime($enq_details->enq_register_date)) : '';}} @endisset>
                                                                <dd>{{ $enq_details->enq_register_date ? date('d-m-Y', strtotime($enq_details->enq_register_date)) : '-'; }}</dd>
                                                            </div>
                                                        </div>
                                            </div>
                                          <div class="col-sm-6">
                                                <div class="form-group">
                                                            <strong>Enquiry Due Date</strong>
                                                            <div class="input-group"> 
                                                                @if(isset($revision))
                                                                <input type='date' onkeydown="return false" min="{{date('Y-m-d', strtotime(now()))}}" class="form-control date required" placeholder="dd/mm/yyyy" name="enq_due_date" id="enq_due_date" value=@isset($enq_details) {{$enq_details->enq_due_date ? date('Y-m-d', strtotime($enq_details->enq_due_date)) : '';}} @endisset>
                                                                @else
                                                                   <input type='hidden' class="form-control date required" placeholder="dd/mm/yyyy" name="enq_due_date" id="enq_due_date" value=@isset($enq_details) {{$enq_details->enq_due_date ? date('Y-m-d', strtotime($enq_details->enq_due_date)) : '';}} @endisset>
                                                                <dd>{{ $enq_details->enq_due_date ? date('d-m-Y', strtotime($enq_details->enq_due_date)) : '-'; }}</dd>
                                                                @endif
                                                             </div>
                                                        </div>
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                            <strong>{{config('global.enq_minus_3')}}</strong>
                                                            <div class="input-group">
                                                                <input type='hidden' class="form-control date" placeholder="dd/mm/yyyy" name="enq_reminder_date" id="enq_reminder_date" value=@isset($enq_details) {{$enq_details->enq_reminder_date ? date('Y-m-d', strtotime($enq_details->enq_reminder_date)) : '';}} @endisset>
                                                                <dd>{{ $enq_details->enq_reminder_date ? date('d-m-Y', strtotime($enq_details->enq_reminder_date)) : '-'; }}</dd>
                                                            </div>
                                                        </div>
                                            </div>
                                            
                                            {{-- <div class="col-sm-6">
                                                <label>Days Old</label>
                                               <p id="days_old"></p><br/><br/>
                                            </div> --}}
                                            <div class="col-sm-6">
                                                <strong>Revision</strong>
                                                <input class="form-control" type="hidden" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="revision_no" name="revision_no" step=".001" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46" value= @if(isset($revision)) {{$revision ? $revision : $enq_details->revision_no ?? 0 ;}} @else {{$enq_details->revision_no ?? 0 ;}} @endif><br/>
                                                <dd>{{ $enq_details->revision_no ?? '-'; }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Client</strong>
                                                <input class="form-control" type="hidden" id="client_name" name="client_name" value="{{$enq_details->client_name ?? '';}}" ><br/>
                                                <dd>{{ $enq_details->client_name ?? '-'; }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Project</strong>
                                                <input class="form-control" type="hidden" id="project_name" name="project_name" value="{{$enq_details->project_name ?? '';}}"><br/>
                                                <dd>{{ $enq_details->project_name ?? '-'; }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                        				            <strong>Product</strong>
                        				                <input type="hidden" id="product_id" name="product_id" value="{{ $enq_details->product_id ?? ''; }}">
                                                        <dd>{{ $enq_details->product_name ?? '-'; }}</dd>

                        			        </div>
                                            <div class="col-sm-6">
                                                <strong>Region</strong>
                                                <input type="hidden" id="region_id" name="region_id" value="{{ $enq_details->region_id ?? ''; }}">
                                                    
                                                <dd>{{ $enq_details->region_name ?? '-'; }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Case Incharge</strong>
                                                <input type="hidden" id="case_incharge_id" name="case_incharge_id" value="{{ $enq_details->case_incharge_id ?? ''; }}">
                                                 
                                                <dd>{{ $enq_details->case_incharge ?? '-'; }} / {{$enq_details->case_incharge_nick_name ?? '-';}}</dd>
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <strong>Sales Remark</strong>
                                                <input type="hidden" id="sales_remark" name="sales_remark" value="{{ $enq_details->sales_remark ?? ''; }}">
                                                <dd>{{ $enq_details->sales_remark ?? '-'; }} </dd>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane fade mt-2" id="category_details" role="tabpanel" aria-labelledby="category_details-tab">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <strong>Category</strong>
                                                <input type="hidden" id="category_id" name="category_id" value="{{ $enq_details->category_id ?? ''; }}">
                                                <dd>{{ $enq_details->category_name ?? '-'; }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Industry</strong>
                                                 <input type="hidden" id="industry_id" name="industry_id" value="{{ $enq_details->industry_id ?? ''; }}">
                                                <dd>{{ $enq_details->industry_name ?? '-'; }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>End User</strong>
                                                <input type="hidden" class="form-control" id="actual_client" name="actual_client" value="{{$enq_details->actual_client ?? '';}}"><br/>
                                                <dd>{{ $enq_details->actual_client ?? '-'; }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                        				        <strong>CI Remark</strong>
                        				        <input type="hidden" class="form-control" id="case_incharge_remark" name="case_incharge_remark" value="{{$enq_details->case_incharge_remark ?? '';}}"><br/>
                                                <dd>{{ $enq_details->case_incharge_remark ?? '-'; }}</dd>
                        			        </div> 
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane fade mt-2" id="allocation_details" role="tabpanel" aria-labelledby="allocation_details-tab">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <strong>Engineer</strong>
                                                <input type="hidden" id="engineer_id" name="engineer_id" value="{{ $enq_details->engineer_id ?? ''; }}">
                                                <dd>{{ $enq_details->engineer ?? '-'; }} / {{$enq_details->engineer_nick_name ?? '-';}}</dd>
                                                    
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Typist</strong>
                                                <input type="hidden" id="typist_id" name="typist_id" value="{{ $enq_details->typist_id ?? ''; }}">
                                                <dd>{{ $enq_details->typist ?? '-'; }} / {{$enq_details->typist_nick_name ?? '-';}}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Allocation Remark</strong>
                                                <input type="hidden" id="allocation_remark" name="allocation_remark" value="{{ $enq_details->allocation_remark ?? ''; }}">
                                                <dd>{{ $enq_details->allocation_remark ?? '-'; }}</dd>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade mt-2" id="status_details" role="tabpanel" aria-labelledby="status_details-tab">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <strong>Engineer Status</strong>
                                                <input type="hidden" id="engineer_status" name="engineer_status" value="{{ $enq_details->engineer_id ?? ''; }}">
                                                   <dd>{{ $enq_details->engineer_status_name ?? '-'; }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                        				        <strong>Engineer Remark</strong>
                        				        <input type="hidden" class="form-control" id="engineer_remark" name="engineer_remark" value="{{$enq_details->engineer_remark ?? '';}}"><br/>
                                                <dd><?php echo (!empty($enq_details->engineer_remark) ? $enq_details->engineer_remark : '-' ); ?></dd>
                        			        </div> 
                                             <div class="col-sm-6">
                                                <strong>Estimated Date</strong>
                                                {{-- <input class="form-control" type='hidden' id="estimated_date" name="estimated_date" value=@isset($enq_details) {{$enq_details->estimated_date ? date('Y-m-d', strtotime($enq_details->estimated_date)) : '';}} @endisset><br> --}}
                                                <dd>{{ $enq_details->estimated_date ? date('d-m-Y', strtotime($enq_details->estimated_date)) : '-'; }}</dd>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane fade mt-2" id="amount_details" role="tabpanel" aria-labelledby="amount_details-tab">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Typist Status<span style="color:#ff0000">*</span></label>
                                                <select class="select2 required" id="typist_status" name="typist_status" style="width: 100% !important;">
                                                    <option value="">Select</option>
                                                    @foreach($typist_status as $typ_status)
                                                        <option value="{{$typ_status->id}}" @isset($enq_details) {{ ($typ_status->id == $enq_details->typist_status) ? 'selected':'';}} @endisset>{{$typ_status->typist_status_name}}</option>
                                                    @endforeach
                                                </select><br/><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Amount</label>
                                                <input class="form-control required" type="text" id="amount" name="amount" step=".001" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46" value={{$enq_details->amount ?? '';}}><br/>
                                            </div>
                                            <div class="col-sm-6">
                        				        <label>Typist Remark</label>
                        				        <textarea class="form-control" id="typist_remark" name="typist_remark">{{$enq_details->typist_remark ?? '';}}</textarea><br/>
                        			        </div> 
                                        </div>
                                    </div>
                                    <hr>
                                     <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success" onclick="submitForm('addEnquiryDetailsForm','post')">Submit</button> 
                                                 <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
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

    function formatDate(date) {
     var d = new Date(date),
         month = '' + (d.getMonth() + 1),
         day = '' + d.getDate(),
         year = d.getFullYear();

     if (month.length < 2) month = '0' + month;
     if (day.length < 2) day = '0' + day;

     return [year, month, day].join('-');
 }
    $('.select2').select2();
    // $('.date').val(new Date().toJSON().slice(0,10));
$( "#enq_due_date" ).change(function() {

    todaysDate = new Date();
    todaysDate = formatDate(todaysDate);
    date = $(this).val()
    var d = new Date(date);
    calc_date = d.setDate(d.getDate()-3);
    enq_reminder_date = formatDate(calc_date);

    if(enq_reminder_date <todaysDate){
    enq_reminder_date = formatDate(date);
    }
    $('#enq_reminder_date').val(enq_reminder_date);

});


var days_old_calc = function(date){
        enq_register_date = new Date(date),
        today   = new Date(),
        diff  = new Date(today - enq_register_date),
        days  = diff/1000/60/60/24;
        $('#days_old').text(Math.round(days));

}

$( "#enq_register_date" ).change(function() {
    date = $(this).val()
    var d = new Date(date);
    days_old_calc(d);

});
if(($("#enq_register_date").val()) != ''){
    var d = new Date($("#enq_register_date").val());
    days_old_calc(d);
}else{
    $('#enq_register_date').val(new Date().toJSON().slice(0,10));
var d = new Date($("#enq_register_date").val());
    days_old_calc(d);
}

</script>
