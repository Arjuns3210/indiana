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
                                            <h5 class="pt-2">Manage Daily Remarks</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <button class="btn btn-sm btn-outline-danger px-3 py-1 mr-2" id="listing-filter-toggle"><i class="fa fa-filter"></i> Filter</button>
                                            @if($data['remark_add'])
                                                <a href="remark_add" class="btn btn-sm btn-outline-primary px-3 py-1 src_data"><i class="fa fa-plus"></i> Add Daily Remark</a>
                                               @endif
                                        </div>
                                    </div>
                                </div>
                            	<div class="card-body">
                                    <div class="row mb-2" id="listing-filter-data" style="display: none;">
                                        @if(session('data')['role_id']==1)
                                        <div class="col-md-4">
                                            <label>Engineer</label>
                                            <select class="form-control mb-3 select2" id="search_admin_id" name="search_admin_id" style="width: 100% !important;">
                                                <option value="">Select</option>
                                                @foreach($admins as $admin)
                                                    <option value="{{$admin->id}}">{{$admin->nick_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                       @endif
                                        <div class="col-md-4">
                                            <label>Remark Date</label>
                                            <input class="form-control mb-3 date" type="date" id="search_remark_date" name="search_remark_date" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46'>

                                        </div>
                                        <div class="col-md-4">
                                            <label>&nbsp;</label>
                                            <input class="btn btn-md btn-primary px-3 py-1 mb-3" id="clear-form-data" type="reset" value="Clear Search">
                                        </div>
                                    </div>
                            		<div class="table-responsive">
                                        <table class="table tabl
                                        
                                        e-bordered table-striped datatable" id="dataTable" width="100%" cellspacing="0" data-url="remark_data">
				                            <thead>
				                                <tr>
				                                    <th class="sorting_disabled" id="id" data-orderable="false" data-searchable="false">Id</th>
				                                    <th class="sorting_disabled" id="admin" data-orderable="false" data-searchable="false">Date</th>
                                                    <th id="activity_remarks" data-orderable="false" data-searchable="false">Remarks</th>
                                                     @if($data['remark_status'] || $data['remark_edit'] ||$data['remark_view'] ||$data['remark_delete'])
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
@endsection