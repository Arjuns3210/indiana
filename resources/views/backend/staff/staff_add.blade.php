<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Staff User</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="saveStaffData" method="post" action="saveStaff">
								<h4 class="form-section"><i class="ft-info"></i> Details</h4>
                    			@csrf
                        		<div class="row">
                        			<div class="col-sm-6">
                        				<label>Role<span class="text-danger">*</span></label>
                        				<select class="select2 required" id="role_id" name="role_id" style="width: 100% !important;">
                                            <option value="">Select</option>
                                            @foreach($data['role'] as $roles)
                                                <option value="{{$roles->id}}">{{$roles->role_name}}</option>
                                            @endforeach
                                        </select><br/>
                        			</div>
                                    <div class="col-sm-6 d-flex" style="margin-top:30px">
                                        <input type="checkbox" class="largerCheckbox" id="is_head" name="is_head" value="0">
                                        <div class="ml-2">
                                            <label class="" for="is_head">Is Head ?</label>
                                        </div>
                                    </div>
								</div><br/>
								<div class="row">
                        			<div class="col-sm-6">
                        				<label>Name<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="name" name="name"><br/>
                        			</div>
									<div class="col-sm-6">
                        				<label>Nick Name<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="nick_name" name="nick_name"><br/>
                        			</div>
									<div class="col-sm-6">
                        				<label>Phone Country Code<span style="color:#ff0000">*</span></label>
                        				<select class="select2 required" id="phone_country_code" name="phone_country_code" style="width: 100% !important;">
                                            <option value="">Select</option>
                                            @foreach($data['country'] as $countries)
                                                <option value="{{$countries->id}}">+{{$countries->phone_code}}</option>
                                            @endforeach
                                        </select><br/>
                        			</div>
                                    <div class="col-sm-6">
                                        <label>Phone<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="phone" name="phone"><br/>
                                    </div>
                        			<div class="col-sm-6">
                        				<label>Email ID<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="email" id="email" name="email"><br/>
                        			</div>
                        			<div class="col-sm-6">
                        				<label>Password<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="password" id="password" name="password"><br/>
                        			</div>
                        			<div class="col-sm-6">
                        				<label>Address<span class="text-danger">*</span></label>
                        				<textarea class="form-control required" id="address" name="address"></textarea><br/>
                        			</div>
                                    <div class="col-sm-6" id="region_mapping">
                                        <label>Region</label>
                                        <select class="select2 form-control" id="region" name="region">
                                            <option value="">Select</option>
                                            @foreach($data['regions'] as $region)
                                                <option value="{{$region->id}}">{{ $region->region_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('saveStaffData','post')">Submit</button>
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
    $("#region_mapping").css('visibility', 'hidden');
    $('.select2').select2();
    $('#is_head').click(function(){
        if( $(this).val()==1){
            $(this).val(0);
        }else{
            $(this).val(1)
        }
    });
    $("#role_id").change(function(){
        if ($("#role_id").val() == '3'){
            $("#region_mapping").css('visibility', 'visible');
        } else {
            $("#region_mapping").css('visibility', 'hidden');
        }
    });
</script>