<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                     <h5 class="pt-2">Transfer Engg For Enquiry: #{{$enquiries->enq_no}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="saveTransferEngineerData" method="post" action="saveTransferEngineer?id={{$enquiries->id}}">
                                <h4 class="form-section"><i class="ft-info"></i>Details</h4>
                    			@csrf
                        		<div class="row">
                                    <div class="col-sm-12">
                                    <h6>Currently Allocated Engineer is {{$enquiries->engineer_nick_name}} </h6>
                                    </div>
                        			<div class="col-sm-6">
                        				<label>Engineer<span class="text-danger">*</span></label>                                       
                        				<select class="select2 required" id="engineer_id" name="engineer_id" style="width: 100% !important;">
                                            <option value="">Select</option>
                                            @foreach($engineers as $engg)
                                                    <option value="{{$engg->id}}">{{$engg->nick_name}}</option>
                                            @endforeach
                                        </select><br/>
                        			</div>
                                </div><br/>
                               
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('saveTransferEngineerData','post')">Update</button>
                                            
                                            <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1"> Cancel</a>
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
</script>