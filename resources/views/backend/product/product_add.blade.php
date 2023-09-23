
<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Product</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#details" role="tab" id="details-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="details" aria-selected="true">
                                        <i class="ft-info mr-1"></i>
                                        <!-- <span class="d-none d-sm-block">Details</span> -->
                                        <span class="">Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#features" role="tab" id="features-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="features" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <!-- <span class="d-none d-sm-block">SEO description</span> -->
                                        <span class="">Customizations & Features</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#price" role="tab" id="price-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="price" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <!-- <span class="d-none d-sm-block">SEO description</span> -->
                                        <span class="">Price</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#description" role="tab" id="description-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="price" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <!-- <span class="d-none d-sm-block">SEO description</span> -->
                                        <span class="">Description</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#page_description" role="tab" id="page_description-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="page_description" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <!-- <span class="d-none d-sm-block">SEO description</span> -->
                                        <span class="">SEO description</span>
                                    </a>
                                </li>
                            </ul>
                            <form id="addProductForm" method="post" action="saveProduct">
                            @csrf
                            <div class="tab-content">
                                <div class="tab-pane fade mt-2 show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                                    <div class="row">
                                        <div class="col-sm-6">
                        				    <label>Product Name<span style="color:#ff0000">*</span></label>
                        				    <input class="form-control required" type="text" id="product_name" name="product_name"><br/>
                            			</div>
                                        <div class="col-sm-6">
                            				<label>Product SKU Code<span style="color:#ff0000">*</span></label>
                            				<input class="form-control required" type="text" id="sku_code" name="sku_code"><br/>
                            			</div>
                                        <div class="col-sm-6">
                            				<label>Current Stock<span style="color:#ff0000">*</span></label>
                        	    			<input class="form-control required" type="text" id="current_stock" name="current_stock" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                        		    	</div>
                                    
                                        <div class="col-sm-6">
                                            <label>Product Image<span style="color:#ff0000">*</span></label>
                                            <p style="color:blue;">Note : Upload file size <?php echo  config('global.DIMENTIONS.PRODUCT'); ?></p>
                                            <input type="file" id="product_image" name="product_image[]" class="form-control required" accept=" product_image/jpg, product_image/jpeg" onchange="checkFiles(this.files)" multiple>
                                            <br/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="custom-switch custom-control-inline mb-1 mb-xl-0">
                                                <input type="checkbox" class="custom-control-input" id="listing_visible" name="listing_visible"  checked="">
                                                <label class="custom-control-label mr-1" for="listing_visible">
                                                    <span>Listing Visible</span>
                                                </label>
                                            </div> 
                                            <br/><br/>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="custom-switch custom-control-inline mb-1 mb-xl-0">
                                                <input type="checkbox" class="custom-control-input" id="search_visible" name="search_visible"   checked="">
                                                <label class="custom-control-label mr-1" for="search_visible">
                                                    <span>Search Visible</span>
                                                </label>
                                            </div> 
                                            <br/><br/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <br/>

                                            <div class="custom-switch custom-control-inline mb-1 mb-xl-0">
                                                <input type="checkbox" class="custom-control-input" id="has_variations" name="has_variations"  >
                                                <label class="custom-control-label mr-1" for="has_variations">
                                                    <span>Bundle</span>
                                                </label>
                                            </div>
                                            
                                            <!-- <input type="checkbox" class="js-switch switchery" id="has_variations" name="has_variations" value="1">
                                            <label for="has_variations">Bundle With</label> -->
                                            <br/><br/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Product To Bundle </label>
                            				<select class="select2" id="map_variations" name="map_variations[]" style="width: 100% !important;" multiple>
                                                <option value="">Select</option>
                                            </select><br/><br/>
                            	        </div>
                                    </div>
                            </div>
                            <div class="tab-pane fade mt-2" id="features" role="tabpanel" aria-labelledby="features-tab">
                                <div class="row">
                                    <div class="col-sm-6">
                        				<label>Category<span style="color:#ff0000">*</span></label>
                        				<select class="select2 required" id="product_category" name="product_category" style="width: 100% !important;">
                                            <option value="">Select</option>
                                            @foreach($category as $categories)
                                                <option value="{{$categories->id}}">{{$categories->category_name}}</option>
                                            @endforeach
                                        </select><br/><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Sub Category<span style="color:#ff0000">*</span></label>
                        				<select class="select2 required" id="product_sub_category" name="product_sub_category" style="width: 100% !important;" >
                                            <option value="">Select</option>
                                           
                                        </select><br/><br/>
                        			</div>
                                    
                                    
                                    <div class="col-sm-6">
                        				<label>Brand<span style="color:#ff0000">*</span></label>
                        				<select class="select2 required" id="brand" name="brand" style="width: 100% !important;">
                                            <option value="">Select</option>
                                            @foreach($brand as $brands)
                                                <option value="{{$brands->id}}">{{$brands->name}}</option>
                                            @endforeach
                                        </select><br/><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Collection</label>
                        				<select class="select2" id="collection" name="collection[]" style="width: 100% !important;" multiple>
                                        <option value="">Select</option>
                                            @foreach($collection as $collections)
                                                <option value="{{$collections->id}}">{{$collections->title}}</option>
                                            @endforeach
                                        </select><br/><br/>
                        			</div>
                                </div> 
                                <div class="row" id="attributes">


                        			</div><br/>
                                
                            </div>
                            <div class="tab-pane fade mt-2" id="price" role="tabpanel" aria-labelledby="price-tab">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Sale Price<span style="color:#ff0000">*</span></label>
                                        <input class="form-control" type="text" id="sale_price" name="sale_price" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Purchase Price<span style="color:#ff0000">*</span></label>
                                        <input class="form-control" type="text" id="purchase_price" name="purchase_price" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Shipping Cost<span style="color:#ff0000">*</span></label>
                                        <input class="form-control" type="text" id="shipping_cost" name="shipping_cost" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Discount (in %)</label>
                                        <input class="form-control" type="text" id="discount" name="discount" value="0" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="tab-pane fade mt-2" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <div class="row">
                                    <div class="col-sm-6">
                                    	<label>Product Weight(in gms)<span style="color:#ff0000">*</span></label>
                        				<input class="form-control required" type="text" id="product_weight" name="product_weight" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                        			</div>
                                    
                                    <div class="col-sm-6">
                        				<label>Video URL</label>
                        				<input class="form-control required" type="text" id="video" name="video"><br/>
                        			</div>
                                   
                                    <div class="col-sm-6">
                        				<label>Short Description<span style="color:#ff0000">*</span></label>
                        				<input class="form-control required" type="text" id="short_description" name="short_description"><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Long Description<span style="color:#ff0000">*</span></label>
                        				<textarea class="form-control required" type="text" id="long_description" name="long_description"></textarea><br/>
                        			</div>
                                    
                                    
                                </div>
                            </div>
                            <div class="tab-pane fade mt-2" id="page_description" role="tabpanel" aria-labelledby="page_description-tab">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Meta Title</label>
                                        <input class="form-control" type="text" id="meta_title" name="meta_title"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Meta Description</label>
                                        <input class="form-control" type="text" id="meta_description" name="meta_description"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Meta Keyword</label>
                                        <input class="form-control" type="text" id="meta_keyword" name="meta_keyword"><br/>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-sm-12">
                        				<div class="pull-right">
                                        <button type="button" class="btn btn-success" onclick="submitEditor('addProductForm','post')">Submit</button>
                                        <a href="{{URL::previous()}}" class="btn btn-sm btn-danger px-3 py-1">Cancel</a>
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
    
</script>
<script src="../public/backend/vendors/ckeditor5/ckeditor.js"></script>
<script>
    $( document ).ready(function() {
        var editor = loadCKEditor('long_description');
    });
</script>
<!-- <script>
    $(document).ready(function () {
        
        
    });
       
</script> -->
