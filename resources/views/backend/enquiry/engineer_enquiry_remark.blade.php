<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div  class="col-12 col-sm-7">
                                    @if(isset($enq_details->id))
                                        @if(isset($revision))
                                        <h5 class="pt-2">Revising Enquiry: #{{$enq_details->enq_no}} / {{$enq_details->region_name}} / {{$enq_details->revision_no}}</h5>
                                        @else
                                        <h5 class="pt-2">Enquiry Remark: #{{$enq_details->enq_no}} / {{$enq_details->region_name}} / {{$enq_details->revision_no}}</h5>
                                        @endif                                    
                                    @else
                                    @endif 
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                             <form id="Remark" method="post" action="enquiryRemark">
                                @csrf
                                <div class="tab-content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" value="{{ $enq_details->id }}" name="id">
                        				        <label>Engineer Remark<span style="color:#ff0000">*</span></label>
                                                <textarea class = "ckeditor" name="engineer_remark" id="engineer_remark"><?php
                                                echo $enq_details->engineer_remark;
                                            ?></textarea>
                        			        </div>
                                    </div>
                                    <hr>
                                     <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success" onclick="submitEditor('Remark','post')">Submit</button> 
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
    loadCKEditor('engineer_remark')
</script>
