<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Copy Product :  {{$name->en}}</h5>
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
                            <form id="copyProductForm" method="post" action="saveProduct">
                            
                            @csrf
                            <div class="tab-content">
                                <div class="tab-pane fade mt-2 show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                                    <div class="row">
                                        <div class="col-sm-6">
                        				    <label>Product Name<span style="color:#ff0000">*</span></label>
                            				<input class="form-control required" type="text" id="product_name" name="product_name" value="{{$name->en}}"><br/>
                            			</div>
                                        <div class="col-sm-6">
                            				<label>Product SKU Code<span style="color:#ff0000">*</span></label>
                            				<input class="form-control required" type="text" id="sku_code" name="sku_code" value="{{ $data->sku_code }}"><br/>
                            			</div>
                                        <div class="col-sm-6">
                        	    			<label>Current Stock<span style="color:#ff0000">*</span></label>
                        		    		<input class="form-control required" type="text" id="current_stock" name="current_stock" value="{{ $data->current_stock }}"><br/>
                        			    </div>
                                        <div class="col-sm-6">
                                            <label>Product Image<span style="color:#ff0000">*</span></label>
                                            <p style="color:blue;">Note : Upload file size <?php echo  config('global.DIMENTIONS.PRODUCT'); ?></p>
                                            <input type="file" id="product_image" name="product_image[]" class="form-control" accept="product_image/jpg, product_image/jpeg" onchange="checkFiles(this.files)" multiple>
                                            @if($data->num_of_imgs > 0 && $images != '')
                                                @foreach($images as $image)
                                                    @php 
                                                        $img_path=array();
                                                    @endphp
                                                    <div class="main-del-section" data-url="dfg" style="position: relative; border: 1px solid #999; border-radius: 5px; padding: 5px; margin-right: 10px; display: inline-block;">
                                                        <img src="{{explode('||',$image)[0]}}" width="100px" height="auto">
                                                        <span class="delimg bg-danger text-center" id="delimg_{{explode('||',$image)[1]}}" data-id="{{explode('_',explode('||',$image)[1])[1]}}" data-url="deleteProductImage?id={{explode('_',explode('||',$image)[1])[0]}}&extension={{explode('.',explode('||',$image)[0])[1]}}" style="padding: 0 5px; position: absolute; top: -8px; right: -8px; border-radius: 50%; cursor: pointer;"><i class="fa fa-times text-light"></i></span>
                                                    </div>
                                                    @php 
                                                    array_push($img_path,explode('||',$image)[0]);
                                                    @endphp
                                                @endforeach
                                                @php
                                                    $impt = implode(',',$img_path);
                                                @endphp
                                                <input type="hidden" id="copy_id" name="copy_id" value="{{$data->id}}">
                                                <input type="hidden" id="images_path" name="images_path" value="{{$impt}}">
                                            @endif
                                            <br/>
                                            <br/>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                            <div class="custom-switch custom-control-inline mb-1 mb-xl-0">
                                                <input type="checkbox" class="custom-control-input" id="listing_visible" name="listing_visible"  <?php echo ($data->listing_visible == 1) ? 'checked' : ''; ?>>
                                                <label class="custom-control-label mr-1" for="listing_visible">
                                                    <span>Listing Visible</span>
                                                </label>
                                            </div> 
                                            <br/><br/>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="custom-switch custom-control-inline mb-1 mb-xl-0">
                                                <input type="checkbox" class="custom-control-input" id="search_visible" name="search_visible"  <?php echo ($data->search_visible == 1) ? 'checked' : ''; ?>>
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
                                                <input type="checkbox" class="custom-control-input" id="has_variations" name="has_variations"  <?php echo ($data->has_variations == 1) ? 'checked' : ''; ?>>
                                                <label class="custom-control-label mr-1" for="has_variations">
                                                    <span>Bundle</span>
                                                </label>
                                            </div> 
                                            <br/><br/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Product To Bundle </label>
                            				<select class="select2" id="map_variations" name="map_variations[]" style="width: 100% !important;" multiple>
                                                <option value="">Select</option>
                                                @foreach($product as $products)
                                                    @if (in_array($products->id,$map_variations))
                                                        <option value="{{$products->id}}" selected>{{json_decode($products->product_name)->en}}</option>
                                                    @else
                                                        <option value="{{$products->id}}">{{json_decode($products->product_name)->en}}</option>
                                                    @endif
                                                @endforeach
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
                                                @if ($categories->id == $data->category_id)
                                                    <option value="{{$categories->id}}" selected>{{$categories->category_name}}</option>
                                                @else
                                                    <option value="{{$categories->id}}">{{$categories->category_name}}</option>
                                                @endif
                                            @endforeach
                                        </select><br/><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Sub Category<span style="color:#ff0000">*</span></label>
                        				<select class="select2 required" id="product_sub_category" name="product_sub_category"  style="width: 100% !important;">
                                            <option value="">Select</option>
                                            @foreach($sub_category as $value)
                                                @if ($value->id == $data->sub_category_id)
                                                    <option value="{{$value->id}}" selected>{{$value->sub_category_name}}</option>
                                                @else
                                                    <option value="{{$value->id}}">{{$value->sub_category_name}}</option>
                                                @endif
                                            @endforeach
                                        </select><br/><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Brand<span style="color:#ff0000">*</span></label>
                        				<select class="select2 required" id="brand" name="brand" style="width: 100% !important;">
                                            <option value="">Select</option>
                                           @foreach($brand as $brands)
                                                @if ($brands->id == $data->brand_id)
                                                    <option value="{{$brands->id}}" selected>{{$brands->name}}</option>
                                                @else
                                                    <option value="{{$brands->id}}">{{$brands->name}}</option>
                                                @endif
                                            @endforeach
                                        </select><br/><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Collection</label>
                        				<select class="select2 required" id="collection" name="collection[]" style="width: 100% !important;" multiple>
                                        @foreach ($collectionall as $c)
                                                @if( in_array($c->id,$collection) )
                                                    <option selected value="{{ $c->id }}">{{ $c->title }}</option>
                                                @else
                                                    <option value="{{ $c->id }}">{{ $c->title }}</option>
                                                @endif
                                            @endforeach
                                           
                                        </select><br/><br/>
                        			</div>
                                </div>
                                <input type="hidden" name="optionvalue" id="optionvalue" value="{{$data->options}}">
                                <div class="row" id="attributes">


                        		</div><br/>
                            </div>
                            <div class="tab-pane fade mt-2" id="price" role="tabpanel" aria-labelledby="price-tab">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Sale Price<span style="color:#ff0000">*</span></label>
                                        <input class="form-control" type="text" id="sale_price" name="sale_price" value="{{ $data->sale_price }}" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Purchase Price<span style="color:#ff0000">*</span></label>
                                        <input class="form-control" type="text" id="purchase_price" name="purchase_price" value="{{ $data->purchase_price }}" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Shipping Cost<span style="color:#ff0000">*</span></label>
                                        <input class="form-control" type="text" id="shipping_cost" name="shipping_cost" value="{{ $data->shipping_cost }}" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Discount (in %)</label>
                                        <input class="form-control" type="text" id="discount" name="discount" value="{{ $data->discount }}" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="tab-pane fade mt-2" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <div class="row">
                                    <div class="col-sm-6">
                                    		<label>Product Weight(in gms)<span style="color:#ff0000">*</span></label>
                        				<input class="form-control required" type="text" id="product_weight" name="product_weight" value="{{ $data->weight }}" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'><br/>
                        		    </div>
                                   
                                    <div class="col-sm-6">
                        				<label>Video URL<span style="color:#ff0000">*</span></label>
                        				<input class="form-control required" type="text" id="video" name="video" value="{{ $data->video }}"><br/>
                        			</div>
                                   
                                    <div class="col-sm-6">
                        				<label>Short Description<span style="color:#ff0000">*</span></label>
                        				<input class="form-control required" type="text" id="short_description" name="short_description" value="{{ $product_details->short_description }}"><br/>
                        			</div>
                                    <div class="col-sm-6">
                        				<label>Long Description<span style="color:#ff0000">*</span></label>
                        				<textarea class="form-control required" type="text" id="long_description" name="long_description">{{ $product_details->long_description }}</textarea><br/>
                        			</div>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-2" id="page_description" role="tabpanel" aria-labelledby="page_description-tab">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Meta Title</label>
                                        <input class="form-control" type="text" id="meta_title" name="meta_title" value="{{ $data->meta_title }}"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Meta Description</label>
                                        <input class="form-control" type="text" id="meta_description" name="meta_description" value="{{ $data->meta_description }}"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Meta Keyword</label>
                                        <input class="form-control" type="text" id="meta_keyword" name="meta_keyword" value="{{ $data->meta_keyword }}"><br/>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-sm-12">
                        				<div class="pull-right">
                                        <button type="button" class="btn btn-success" onclick="submitEditor('copyProductForm','post')">Submit</button>
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

        var sub_category_id = $('#product_sub_category').val();
                   
         var optionvalue=$('#optionvalue').val(); 
         if(sub_category_id ){
            fetcAttr(sub_category_id,optionvalue);
        }
    });
</script>

