<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <!-- <h5 class="pt-2">Edit </h5> -->
                                    <h5 class="pt-2">Edit Daily Remarks : {{$data->remark_date}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="editRemarkData" method="post" action="saveRemark?id={{$data->id}}">
                                <h4 class="form-section"><i class="ft-info"></i>Details</h4>
                    			@csrf
                        		<div class="row">
                                    <div class="col-sm-6">
                                        <label>Remark Date<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="date" id="remark_date" name="remark_date" value="{{$data->remark_date}}"><br/>
                                    </div>
									<div class="col-sm-12">
                        				<label>Activity Remark<span class="text-danger">*</span></label>
                        				<textarea class="form-control required" id="activity_remarks" name="activity_remarks" >{{$data->activity_remarks}}</textarea><br/>
                                    </div>
                                </div><br/>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('editRemarkData','post')">Update</button>
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
