@extends('backend.layouts.app')
@section('content')
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <section class="users-list-wrapper">
                <div class="users-list-table">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-12 col-sm-7">
                                                <h5 class="pt-2">Manage Enquiry List</h5>
                                            </div>
                                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                <button class="btn btn-sm btn-outline-danger px-3 py-1 mr-2" id="listing-filter-toggle"><i class="fa fa-filter"></i>&nbsp;Filter</button>
                                           @if($data['enquiry_add'])
                                                <a href="enquiry_form/-1" class="btn btn-sm btn-outline-primary px-3 py-1 src_data"><i class="fa fa-plus"></i> Add Enquiry</a>&nbsp;
                                            @endif
                                             @if($data['enquiry_import'])
                                                    <a href="import_enquiry" class="btn btn-success btn-sm px-3 py-1"><i class="ft-upload"></i> Import</a>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2" id="listing-filter-data" style="display: none;">
                                            <div class="col-md-4">
                                                <label>ENQ No.</label>
                                                <input class="form-control mb-3" type="text" id="search_enq_no" name="search_enq_no">
                                            </div>
                                            <div class="col-md-4">
                                                <label>ENQ Date</label>
                                                <input class="form-control mb-3 date" type="date" id="search_enq_register_date" name="search_enq_register_date" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46'>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Client</label>
                                                <input class="form-control mb-3" type="text" id="search_client_name" name="search_client_name">
                                            </div>
                                            <div class="col-md-4">
                                            <label>Region</label>
                                            <select class="form-control mb-3 select2" id="search_region" name="search_region" style="width: 100% !important;">
                                                  <option value="">Select</option>
                                                            @foreach($data['regions'] as $region)
                                                                <option value="{{$region->id}}">{{$region->region_name}}</option>
                                                            @endforeach                                             
                                            </select><br/>
                                            </div>
                                            <div class="col-md-4">
                                            <label>Product</label>
                                            <select class="form-control mb-3 select2" id="search_product" name="search_product" style="width: 100% !important;">
                                                  <option value="">Select</option>
                                                            @foreach($data['products'] as $product)
                                                                <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                            @endforeach                                             
                                            </select><br/>
                                            </div>
                                            <div class="col-md-4 ">
                                                <label>Category</label>
                                                <select class="form-control mb-3 select2" id="search_category" name="search_category" style="width: 100% !important;">
                                                    <option value="">Select</option>
                                                        @foreach($data['categories'] as $category)
                                                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                        @endforeach                                            
                                                    <option value="0">Blank</option>
                                                </select><br/>
                                            </div>
                                           @if($data['role_id'] == 5 || $data['role_id'] == 1)
                                                <div class="col-md-4 mt-3">
                                                    <label>Engineer Status</label>
                                                    <select class="form-control mb-3 select2" id="search_engineer_status" name="search_engineer_status" style="width: 100% !important;">
                                                        <option value="">Select</option>
                                                            @foreach($data['engineer_statuses'] as $engineerStatus)
                                                                <option value="{{$engineerStatus->id}}">{{$engineerStatus->engineer_status_name}}</option>
                                                            @endforeach    
                                                        <option value="blank">Blank</option>
                                                    </select><br/>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label>Allocation Date</label>
                                                    <input class="form-control mb-3 date" type="date" id="search_allocation_date" name="search_allocation_date" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46'>
                                                </div>
                                            @endif
                                           @if($data['role_id'] == 5 || $data['role_id'] == 1 || $data['role_id'] == 6)
                                            <div class="col-md-4 mt-3">
                                                <label>Typist Status</label>
                                                <select class="form-control mb-3 select2" id="search_typist_status" name="search_typist_status" style="width: 100% !important;">
                                                    <option value="">Select</option>
                                                        @foreach($data['typist_statuses'] as $typistStatus)
                                                            <option value="{{$typistStatus->id}}">{{$typistStatus->typist_status_name}}</option>
                                                        @endforeach                                            
                                                        <option value="blank">Blank</option>
                                                </select><br/>
                                            </div>
                                            @endif
                                           @if($data['role_id'] == 3 || $data['role_id'] == 1)
                                            <div class="col-md-4 mt-3">
                                                <label>ENQ Due Date</label>
                                                <input class="form-control mb-3 date" type="date" id="search_enq_due_date" name="search_enq_due_date" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46'>
                                            </div>
                                            @endif
                                            <div class="col-md-4">
                                                <br/>
                                                <label>&nbsp;</label>
                                                <input class="btn btn-md btn-primary px-3 py-1 mb-3" id="clear-form-data" type="reset" value="Clear Search">
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped datatable" id="dataTable" width="100%" cellspacing="0" data-url="enquiry_data">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting_disabled" id="id" data-orderable="false" data-searchable="false">#</th>
                                                        <th id="enq_no" data-orderable="false" data-searchable="false">Enq No.</th>
                                                        <th id="region_name" data-orderable="false" data-searchable="false">Region</th>
                                                        <th id="revision_no" data-orderable="false" data-searchable="false">Revision</th>
                                                        <th id="enq_register_date" data-orderable="false" data-searchable="false">ENQ Date</th>
                                                        {{-- <th id="enq_due_date" data-orderable="false" data-searchable="false">ENQ DUE Date</th> --}}
                                                        <th id="client_name" data-orderable="false" data-searchable="false">Client</th>
                                                        <th id="project_name" data-orderable="false" data-searchable="false">Project</th>
                                                        @if($data['enquiry_view'])
                                                            <th id="action" data-orderable="false" data-searchable="false" width="130px">Action</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script>
    // $('.date').val(new Date().toJSON().slice(0,10));
                <?php if($data['role_id'] == 5 ) {?>
                    var date = new Date();
                    var date_minus_one = date.setDate(date.getDate() - 1);
                        $('#search_allocation_date').val(new Date(date_minus_one).toJSON().slice(0,10));
                    <?php }?>
</script>
@endsection

