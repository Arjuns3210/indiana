<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Product :  {{$data->product_code}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                        <div class="card-body">
                            <form id="productData" method="post" action="saveProduct?id={{$data->id}}">
                                <h4 class="form-section"><i class="ft-info"></i>Details</h4>
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Product name<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="product_name" name="product_name" value="{{$data->product_name}}" readonly><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Product Code<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="product_code" name="product_code" value="{{$data->product_code}}" readonly><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="email_list" title="Enter a comma-separated list of email addresses">Email List: <i class="fa fa-question-circle-o fa-lg" aria-hidden="true"></i></label>
                                        <input type="email" id="email_list" name="email_list" class="form-control" value="{{$data->email_id ?? ''}}" autocomplete="off" multiple placeholder="Enter a comma-separated list of email addresses">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-success" onclick="submitForm('productData','post')">Update</button>
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
