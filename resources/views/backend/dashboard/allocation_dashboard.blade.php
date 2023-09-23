@extends('backend.layouts.app')
@section('content')
<div class="wrapper">
    <div class="main-panel">
        <div class="main-content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <section id="minimal-statistics">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="content-header">Welcome to Indiana Allocator Panel</h1>
                            <hr style="border: none; border-bottom: 1px solid black;">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{$total_allocated_enquiries}}</h3>
                                                <span>Total Allocated Enquiries</span><br><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-users success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 warning">{{$enquiries_allocated_today}}</h3>
                                                <span>Enquries Allocated Today</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-user-plus warning font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-4 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 primary">{{$enquiries_pending_allocation}}</h3>
                                                <span>Enquries Pending Allocation</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-briefcase primary font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-12">
                            <div class="card shopping-cart">
                                <div class="card-header pb-2">
                                    <h4 class="card-title mb-1">Enquiry Needs Action </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table text-center m-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Enq No.</th>
                                                        <th>Region</th>
                                                        <th>ENQ Date</th>
                                                        <th>ENQ Due Date</th>
                                                        <th>Category</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($enquiries_need_action) && count($enquiries_need_action)>0)
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach($enquiries_need_action as $enquiry)
                                                         <tr>
                                                            <td>{{$i}}</td>
                                                            <td>{{$enquiry->enq_no}}</td>
                                                            <td>{{$enquiry->region->region_name}}</td>
                                                            <td>{{$enquiry->enq_register_date ? date('d-m-Y', strtotime($enquiry->enq_register_date)) : '-'}}</td>
                                                            <td>{{$enquiry->enq_due_date ? date('d-m-Y', strtotime($enquiry->enq_due_date)) : '-'}}</td>
                                                            @if ($enquiry->category_id)
                                                                <td>{{$enquiry->category->category_name}}</td>
                                                            @else
                                                                <td>-</td>
                                                            @endif
                                                            <td>
                                                                <a href="enquiry_form/{{$enquiry->id}}" class="btn btn-success btn-sm src_data" title="Update"><i class="ft-arrow-right"></i></a>
                                                            </td>
                                                        </tr>
                                                        @php
                                                        $i++;
                                                        @endphp
                                                        @endforeach

                                                    @else
                                                        <tr>
                                                            <td colspan="8">No Records Found</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
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
    </div>
</div>
@endsection
