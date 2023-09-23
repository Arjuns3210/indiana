<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <!-- <h5 class="pt-2">Edit {{$data['data']->admin_name}}</h5> -->
                                    <h5 class="pt-2">Edit Staff :  {{$data['data']->admin_name}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="editStaffData" method="post" action="saveStaff?id={{$data['data']->id}}">
                                <h4 class="form-section"><i class="ft-info"></i>Details</h4>
                    			@csrf
                        		<div class="row">
                        			<div class="col-sm-6">
                        				<label>Role<span class="text-danger">*</span></label>                                       
                        				<select class="select2 required" id="role_id" name="role_id" style="width: 100% !important;">
                                            <option value="">Select</option>
                                            @foreach($data['roles'] as $roles)
                                                @if($roles->id == $data['data']->role_id)
                                                    <option value="{{$roles->id}}" selected>{{$roles->role_name}}</option>
                                                @else
                                                    <option value="{{$roles->id}}">{{$roles->role_name}}</option>
                                                @endif
                                            @endforeach
                                        </select><br/>
                        			</div>
                                    <div class="col-sm-6 d-flex" style="margin-top:30px">
                                        <input type="checkbox" class="largerCheckbox" id="is_head" name="is_head" value="{{$data['data']->is_head}}" {{ $data['data']->is_head == 1 ? 'checked' :'' }}>
                                        <div class="ml-2">
                                            <label class="" for="is_head">Is Head ?</label>
                                        </div>
                                    </div>
                                </div><br/>
                                <div class="row">
                        			<div class="col-sm-6">
                        				<label>Name<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="name" name="name" value="{{$data['data']->admin_name}}"><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Nick Name<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="nick_name" name="nick_name" value="{{$data['data']->nick_name}}"><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Phone Country Code<span style="color:#ff0000">*</span></label>
                        				<select class="select2 required" id="phone_country_code" name="phone_country_code" style="width: 100% !important;">
                                            <option value="">Select</option>
                                            @foreach($data['country'] as $codes)
                                                @if ($codes->id == $data['data']->country_id)
                                                    <option value="{{$codes->id}}" selected>+{{$codes->phone_code}}</option>
                                                @else
                                                    <option value="{{$codes->id}}">+{{$codes->phone_code}}</option>
                                                @endif
                                            @endforeach
                                        </select><br/><br>
                        			</div>
                                    <div class="col-sm-6">
                                        <label>Phone<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="phone" name="phone" value="{{$data['data']->phone}}"><br/>
                                    </div>
                        			<div class="col-sm-6">
                        				<label>Email ID<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="email" id="email" name="email" value="{{$data['data']->email}}"><br/>
                        			</div>
                        			<div class="col-sm-6">
                        				<label>Address<span class="text-danger">*</span></label>
                        				<textarea class="form-control required" id="address" name="address">{{$data['data']->address}}</textarea><br/>
                        			</div>
                                    <div class="col-sm-6" id="region_mapping">
                                        <label>Region</label>
                                        <select class="form-control select2" id="region" name="region">
                                            <option value="">Select</option>
                                            @foreach($data['regions'] as $region)
                                                @if ($region->id == $data['data']->region_id)
                                                    <option value="{{$region->id}}" selected>{{ $region->region_name }}</option>
                                                @else
                                                    <option value="{{$region->id}}">{{ $region->region_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('editStaffData','post')">Update</button>
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
    if ($("#role_id").val() != '3'){
    $("#region_mapping").css('visibility', 'hidden');
    }

    $('.select2').select2();
    $('#is_head').click(function(){
       if( $(this).val()==1){
         $(this).val(0);
       }else{
         $(this).val(1)
       }
    })
    $("#role_id").change(function(){
        if ($("#role_id").val() == '3'){
            $("#region_mapping").css('visibility', 'visible');
        } else {
            $("#region_mapping").css('visibility', 'hidden');
        }
    });
</script>