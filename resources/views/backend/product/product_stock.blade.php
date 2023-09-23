<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Stock:   {{$name->en}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                    	<div class="card-body">
                    		<form id="editStockForm" method="post" action="saveStock?id={{$data->id}}">
                            <h4 class="form-section"><i class="ft-info"></i> Current Stock: {{$data->current_stock}}</h4>
                    			@csrf
                                <input type="hidden" value="{{$data->id}}" name="product_id">
                                <input class="form-control" type="hidden"  value="{{$data->category_id}}" id="category_id" name="category_id">
                                <input class="form-control" type="hidden"  value="{{$data->sub_category_id }}" id="sub_category_id" name="sub_category_id">
                                
    
                        		<div class="row">

                                    <div class="col-sm-6">
                        				<label>Type<span style="color:#ff0000">*</span></label>
                        				<select class="select2 required" id="type" name="type" style="width: 100% !important;">
                                            <option value="">Select</option>
                                        
                                            <option value="Add">Add</option>
                                            <option value="Destroy">Destroy</option>
                                        </select><br/><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Stock Quantity<span style="color:#ff0000">*</span></label>
                        				<input class="form-control required" type="text" id="quantity" name="quantity" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                        			</div>
                                    <div class="col-sm-6">
                                        <label>Rate<span style="color:#ff0000">*</span></label>
                                        <input class="form-control" type="text" id="rate" name="rate" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Total Price<span style="color:#ff0000">*</span></label>
                                        <input class="form-control" type="text" id="total" name="total" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                                    </div>
                                    <div class="col-md-12">
                        				<label>Note</label>
                        				<textarea class="form-control" type="text" id="reason_note" name="reason_note"></textarea><br/>
                        			</div>
                                    

                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('editStockForm','post')">Submit</button>
                                            <a href="{{URL::previous()}}" class="btn btn-sm btn-danger px-3 py-1">Cancel</a>
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