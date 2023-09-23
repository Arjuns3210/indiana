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
                                                <h5 class="pt-2">Manage Mipo List</h5>
                                            </div>
                                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                <button class="btn btn-sm btn-outline-danger px-3 py-1 mr-2" id="listing-filter-toggle"><i class="fa fa-filter"></i>&nbsp;Filter</button>
                                                @if($data['mipo_add'])
                                                    <a href="mipo-form" class="btn btn-sm btn-outline-primary px-3 py-1 src_data"><i class="fa fa-plus"></i> Add Mipo</a>&nbsp;
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2" id="listing-filter-data" style="display: none;">
                                            <div class="col-md-4">
                                                <label>PO No.</label>
                                                <input class="form-control mb-3" type="text" id="search_po_no" name="search_po_no">
                                            </div>
                                            <div class="col-md-4">
                                                <label>PO Date</label>
                                                <input class="form-control mb-3 date" type="date" id="po_recv_date" name="po_recv_date" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46'>
                                            </div>
                                            <div class="col-md-4">
                                                <label>PO Type</label>
                                                <select class="form-control mb-3 select2" id="search_po_type"
                                                        name="search_po_type" style="width: 100% !important;">
                                                    <option value="">Select</option>
                                                    <option value="new">NEW</option>
                                                    <option value="cn">CN</option>
                                                </select><br/>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Enquiry</label>
                                                <select class="form-control mb-3 select2" id="search_enquiry" name="search_enquiry" style="width: 100% !important;">
                                                    <option value="">Select</option>
                                                    @foreach($data['enquires'] as $enquire)
                                                        <option value="{{$enquire->id}}">{{ $enquire->enq_no.' / '. $enquire->region_code ." / ". $enquire->revision_no }}</option> 
                                                    @endforeach 
                                                </select><br/>
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
                                                </select><br/><br/>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Category</label>
                                                <select class="form-control mb-3 select2" id="search_category" name="search_category" style="width: 100% !important;">
                                                    <option value="">Select</option>
                                                    @foreach($data['categories'] as $category)
                                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                    @endforeach
                                                    <option value="0">Blank</option>
                                                </select><br/>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Is FRP</label>
                                                <select class="form-control mb-3 select2" id="search_is_frp" name="search_is_frp" style="width: 100% !important;">
                                                    <option value="">Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select><br/>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Mipo Status</label>
                                                <select class="form-control mb-3 select2" id="search_po_status" name="search_po_status[]" multiple style="width: 100% !important;">
                                                    @foreach($data['mipoStatus'] as $status)
                                                    <option value="{{$status->id}}">{{ $status->mipo_status_name }}</option>
                                                    @endforeach
                                                </select><br/>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <input class="btn btn-md btn-primary px-3 py-1 mb-3" id="clear-form-data" type="reset" value="Clear Search">
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped datatable" id="dataTable" width="100%" cellspacing="0" data-url="mipo_data">
                                                <thead>
                                                <tr>
                                                    <th class="sorting_disabled" id="id" data-orderable="false" data-searchable="false">#</th>
                                                    <th id="po_no" data-orderable="false" data-searchable="false">MIPO No.</th>
                                                    <th id="po_type" data-orderable="false" data-searchable="false">Po Type</th>
                                                    <th id="revision_no" data-orderable="false" data-searchable="false">Revision</th>
                                                    <th id="product_name" data-orderable="false" data-searchable="false">Product</th>
                                                    <th id="enquiry_no" data-orderable="false" data-searchable="false">Enquiry No</th>
                                                    <th id="region_name" data-orderable="false" data-searchable="false">Region</th>
                                                    <th id="action" data-orderable="false" data-searchable="false" width="130px">Action</th>
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
@endsection

