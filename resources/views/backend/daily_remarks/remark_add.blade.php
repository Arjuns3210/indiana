<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Activity Remark</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="saveRemarkData" method="post" action="saveRemark">
								<h4 class="form-section"><i class="ft-info"></i> Details</h4>
                    			@csrf
								<div class="row">
									<div class="col-sm-6">
                                        <label>Remark Date<span class="text-danger">*</span></label>
                                        <input class="form-control date required" type="date" id="remark_date" name="remark_date"><br/>
                                        {{-- <input type='date' onkeydown="return false" min="{{ date('Y-m-d', strtotime( $enq_details->enq_register_date ?? now())) }}" max="{{ date('Y-m-d', strtotime( $enq_details->enq_register_date ?? now())) }}" class="form-control date required" placeholder="dd/mm/yyyy" name="enq_register_date" id="enq_register_date" value=@isset($enq_details) {{$enq_details->enq_register_date ? date('Y-m-d', strtotime($enq_details->enq_register_date)) : '';}} @endisset> --}}

                                    </div>
									<div class="col-sm-12">
                        				<label>Activity Remark<span class="text-danger">*</span></label>
                        				<textarea class="form-control required" id="activity_remarks" name="activity_remarks"></textarea><br/>
                                    </div>
                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('saveRemarkData','post')">Submit</button>
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


    const d = new Date();
    const formattedDate = d.getFullYear()+'-'+("0"+(d.getMonth()+1))+'-'+("0"+d.getDate()).slice(-2);
    $('#remark_date').val( formattedDate );

</script>