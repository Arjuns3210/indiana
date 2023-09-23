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
                                                <h5 class="pt-2">Enquiry Details : #{{ $enquiries->enq_no }} / {{$enquiries->region_name}} / {{$enquiries->revision_no}}</h5>
                                            </div>
                                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                <a href="{{URL::to('/webadmin/enquiry_list')}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a href="#enquiry_details" role="tab" id="enquiry_details-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="details" aria-selected="true">
                                                    <i class="ft-info mr-1"></i>
                                                    <span class="d-none d-sm-block">Enquiry Details</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#category_details" role="tab" id="category_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="page_description" aria-selected="false">
                                                    <i class="ft-link mr-2"></i>
                                                    <span class="d-none d-sm-block">Category Details</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#allocation_details" role="tab" id="allocation_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="page_description" aria-selected="false">
                                                    <i class="ft-link mr-2"></i>
                                                    <span class="d-none d-sm-block">Allocation Details</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#status_details" role="tab" id="status_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="page_description" aria-selected="false">
                                                    <i class="ft-link mr-2"></i>
                                                    <span class="d-none d-sm-block">Status Details</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#amount_details" role="tab" id="amount_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="page_description" aria-selected="false">
                                                    <i class="ft-link mr-2"></i>
                                                    <span class="d-none d-sm-block">Amount Details</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade mt-2 show active" id="enquiry_details" role="tabpanel" aria-labelledby="enquiry_details-tab">
                                                 <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered">
                                                                 <tr>
                                                                    <td><strong>Enquiry No.</strong></td>
                                                                    <td>{{ $enquiries->enq_no ?? '-'}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Revision</strong></td>
                                                                    <td>{{ $enquiries->revision_no ?? '-'}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Region</strong></td>
                                                                    <td>{{ $enquiries->region_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Actual Enquiry Received Date</strong></td>
                                                                    <td>{{ $enquiries->enq_recv_date ? date('d-m-Y', strtotime($enquiries->enq_recv_date)) : '-'; }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Enquiry Date</strong></td>
                                                                    <td>{{ $enquiries->enq_register_date ? date('d-m-Y', strtotime($enquiries->enq_register_date)) : '-'; }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Enquiry Due Date</strong></td>
                                                                    <td>{{ $enquiries->enq_due_date ? date('d-m-Y', strtotime($enquiries->enq_due_date)) : '-'; }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>{{config('global.enq_minus_3')}}</strong></td>
                                                                    <td>{{ $enquiries->enq_reminder_date ? date('d-m-Y', strtotime($enquiries->enq_reminder_date)) : '-'; }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Days Old</strong></td>
                                                                    <td>{{ $old_days ?? 0 ; }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Client</strong></td>
                                                                    <td>{{ $enquiries->client_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Project</strong></td>
                                                                    <td>{{ $enquiries->project_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Product</strong></td>
                                                                    <td>{{ $enquiries->product_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Case Incharge</strong></td>
                                                                    <td>{{ $enquiries->case_incharge ?? '-';}} / {{$enquiries->case_incharge_nick_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Sales Remark</strong></td>
                                                                    <td>{{ $enquiries->sales_remark ?? '-';}} </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade mt-2" id="category_details" role="tabpanel" aria-labelledby="category_details-tab">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered">
                                                                <tr>
                                                                    <td><strong>Category</strong></td>
                                                                    <td>{{$enquiries->category_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Category Date</strong></td>
                                                                    <td>{{ $enquiries->category_mapped_date ? date('d-m-Y', strtotime($enquiries->category_mapped_date)) : '-'; }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Industry</strong></td>
                                                                    <td>{{$enquiries->industry_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>End User</strong></td>
                                                                    <td>{{$enquiries->actual_client ?? '-';}}</td>
                                                                </tr>
                                                                 <tr>
                                                                    <td><strong>CI Remark</strong></td>
                                                                    <td>{{$enquiries->case_incharge_remark ?? '-';}}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>                                    
                                                </div>
                                            </div>
                                            <div class="tab-pane fade mt-2" id="allocation_details" role="tabpanel" aria-labelledby="allocation_details-tab">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered">
                                                                <tr>
                                                                    <td><strong>Allocation Date</strong></td>
                                                                    <td>{{ $enquiries->allocation_date ? date('d-m-Y', strtotime($enquiries->allocation_date)) : '-'; }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Engineer</strong></td>
                                                                    <td>{{$enquiries->engineer ?? '-';}} / {{$enquiries->engineer_nick_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Transfer From (Engg)</strong></td>
                                                                    <td>{{$enquiries->old_engineer ?? '-';}} / {{$enquiries->old_engineer_nick_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Engineer Transfer Date</strong></td>
                                                                    <td>{{ $enquiries->engg_transfer_date ? date('d-m-Y', strtotime($enquiries->engg_transfer_date)) : '-'; }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Typist</strong></td>
                                                                    <td>{{$enquiries->typist ?? '-'; }} / {{$enquiries->typist_nick_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Transfer From (Typist)</strong></td>
                                                                    <td>{{$enquiries->old_typist ?? '-';}} / {{$enquiries->old_typist_nick_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Typist Transfer Date</strong></td>
                                                                    <td>{{ $enquiries->typist_transfer_date ? date('d-m-Y', strtotime($enquiries->typist_transfer_date)) : '-'; }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Allocation Remark</strong></td>
                                                                    <td>{{ $enquiries->allocation_remark ?? '-'; }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>                                    
                                                </div>
                                            </div>
                                            <div class="tab-pane fade mt-2" id="status_details" role="tabpanel" aria-labelledby="status_details-tab">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered">
                                                                <tr>
                                                                    <td><strong>Engineer Status</strong></td>
                                                                    <td>{{$enquiries->engineer_status_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Estimated Date</strong></td>
                                                                    <td>{{ $enquiries->estimated_date ? date('d-m-Y', strtotime($enquiries->estimated_date)) : '-'; }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Engineer Remark</strong></td>
                                                                    <td>{{$enquiries->engineer_remark ?? '-';}}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>                                    
                                                </div>
                                            </div>
                                            <div class="tab-pane fade mt-2" id="amount_details" role="tabpanel" aria-labelledby="amount_details-tab">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered">
                                                                <tr>
                                                                    <td><strong>Typist Status</strong></td>
                                                                    <td>{{$enquiries->typist_status_name ?? '-';}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Typist Date</strong></td>
                                                                    <td>{{ $enquiries->typist_completed_date ? date('d-m-Y', strtotime($enquiries->typist_completed_date)) : '-'; }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>Amount</strong></td>
                                                                    <td>{{$enquiries->amount ?? '-'; }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td ><strong>Typist Remark</strong></td>
                                                                    <td>{{$enquiries->typist_remark ?? '-';}}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>                                    
                                                </div>
                                            </div>
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
