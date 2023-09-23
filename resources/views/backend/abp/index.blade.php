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
                                                <h5 class="pt-2">Manage OBP List</h5>
                                            </div>
                                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                <button class="btn btn-sm btn-outline-danger px-3 py-1 mr-2" id="listing-filter-toggle"><i class="fa fa-filter"></i>&nbsp;Filter</button>
                                                @if($data['abp_add'] && checkCiRegionApproved($data['user_id']))
                                                    <a href="abp_form" class="btn btn-sm btn-outline-primary px-3 py-1 src_data"><i class="fa fa-plus"></i> Add Abp</a>&nbsp;
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2" id="listing-filter-data" style="display: none;">
                                            <div class="col-md-4">
                                                <label>Product</label>
                                                <select class="form-control mb-3 select2" id="search_product" name="search_product" style="width: 100% !important;">
                                                    <option value="">Select</option>
                                                    @foreach($data['products'] as $product)
                                                        <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                    @endforeach
                                                </select><br/><br/>
                                            </div>
                                            @if($data['role_id'] != 3)
                                            <div class="col-md-4">
                                                <label>Region</label>
                                                <select class="form-control mb-3 select2" id="search_region" name="search_region" style="width: 100% !important;">
                                                    <option value="">Select</option>
                                                    @foreach($data['regions'] as $region)
                                                        <option value="{{$region->id}}">{{$region->region_name}}</option>
                                                    @endforeach
                                                </select><br/>
                                            </div>
                                            @endif
                                            <div class="col-md-4">
                                                <label>Time (B)</label>
                                                <input class="form-control" type="text" id="search_time" name="search_time" autocomplete="off">
                                                <br/>
                                            </div>
                                            @if($data['role_id'] != 3)
                                            <div class="col-md-4">
                                                <label>Case Incharge</label>
                                                <select class="form-control mb-3 select2" id="search_ci" name="search_ci" style="width: 100% !important;">
                                                    <option value="">Select</option>
                                                    @foreach($data['case_incharges'] as $ci)
                                                        <option value="{{$ci->id}}">{{$ci->nick_name}}</option>
                                                    @endforeach
                                                </select><br/>
                                            </div>
                                            @endif
                                            <div class="col-md-4 mt-3">
                                                <input class="btn btn-md btn-primary px-3 py-1 mb-3" id="clear-form-data" type="reset" value="Clear Search">
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped datatable" id="dataTable" width="100%" cellspacing="0" data-url="abp_data">
                                                <thead>
                                                <tr>
                                                    <th class="sorting_disabled" id="id" data-orderable="false" data-searchable="false">#</th>
                                                    <th id="product_id" data-orderable="false" data-searchable="false">Product Name</th>
                                                    <th id="client_name" data-orderable="false" data-searchable="false">Client<Name></Name></th>
{{--                                                    <th id="region_id" data-orderable="false" data-searchable="false">Region<Name></Name></th>--}}
                                                    @if($data['role_id'] != 3)
                                                    <th id="ci_id" data-orderable="false" data-searchable="false">Case Incharge<Name></Name></th>
                                                    @endif
                                                    <th id="net_margin_budget" data-orderable="false" data-searchable="false">Net Margin</th>
                                                    <th id="order_value_budget" data-orderable="false" data-searchable="false">Order Value</th>
                                                    <th id="credit_days_budget" data-orderable="false" data-searchable="false">Credit Days</th> 
                                                    <th id="time_budget" data-orderable="false" data-searchable="false">Time (B)</th>
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

    <script>

        $(document).ready(function(){
            $('#search_time').datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
            });
        });

        $('#search_time').on('change',function (){
            $('#search_product').trigger('change');  
        })

    </script>
@endsection


