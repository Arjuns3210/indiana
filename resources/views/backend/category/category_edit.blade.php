<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Collection : {{$data->title}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                    	<div class="card-body">
                    		<form id="editCategoryForm" method="post" action="saveCategory?id={{$data->id}}">
                                <h4 class="form-section"><i class="ft-info"></i> Details</h4>
                    			@csrf
                        		<div class="row">
                                    <div class="col-sm-6">
                        				<label>Super Category<span style="color:#ff0000">*</span></label>
                        				<select class=" form-control select2 required" id="super_category" name="super_category" style="width: 100% !important;">
                                            <option value="">Select</option>
                                            @foreach($data['super_category'] as $val)
                                                @if ($val->id == $data->super_category_id)
                                                    <option value="{{$val->id}}" selected>{{$val->super_category_name}}</option>
                                                @else
                                                    <option value="{{$val->id}}">{{$val->super_category_name}}</option>
                                                @endif
                                            @endforeach
                                        </select><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Category Name<span style="color:#ff0000">*</span></label>
                        				<input class="form-control required" type="text" id="category_name" value="{{ $data->category_name }}" name="category_name"><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Attribute<span style="color:#ff0000">*</span></label>
                        				<select class="select2 required" id="attribute_id" name="attribute_id[]" style="width: 100% !important;" multiple="multiple">
                                            <option value="">Select</option>
                                            @foreach($data['attribute'] as $val)
                                                {{-- @foreach($data['attribute_arr'] as $values) --}}
                                                    @if(in_array($val->id, $data['attribute_arr']))
                                                {{-- //    @if(array_search($val->id, array_column($data['attribute_arr'], 'id')) !== false) --}}
                                                        <option value="{{$val->id}}" selected>{{$val->name}}</option>
                                                    @else
                                                        <option value="{{$val->id}}">{{$val->name}}</option> 
                                                    @endif
                                                {{-- @endforeach --}}
                                            @endforeach
                                        </select><br/><br>
                        			</div>
                                    <div class="col-sm-6">
                                        <label>Category Image<span style="color:#ff0000">*</span></label>
                                        <p style="color:blue;">Note : Upload file size <?php echo  config('global.DIMENTIONS.CATEGORY'); ?></p>
                                        <input type="file" id="category_image" name="category_image" class="form-control" accept="image/png, image/jpg, image/jpeg"><br/>
                                        <img src="{{ $data[]->image_path}}" width="200px" height="auto">
                                    </div>
                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('editCategoryForm','post')">Update</button>
                                            <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
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