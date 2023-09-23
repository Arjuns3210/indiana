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
                            <h1 class="content-header">Welcome to Indiana Estimator Panel</h1>
                            <hr style="border: none; border-bottom: 1px solid black;">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{$total_mapped_enquiries}}</h3>
                                                <span>Total Mapped Enquiries</span><br><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-users success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 warning">{{$enquiries_mapped_today}}</h3>
                                                <span>Enquries Mapped Today</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-user-plus warning font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 primary">{{$enquiries_acted_today}}</h3>
                                                <span>Enquries Acted Today</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-briefcase primary font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 primary">{{$enquiries_due_today}}</h3>
                                                <span>Enquries Due Today</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-briefcase primary font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PO card--}}
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 success">{{$total_mapped_po}}</h3>
                                                <span>Mapped PO</span><br><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-users success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 warning">{{$po_mapped_today}}</h3>
                                                <span>Po Mapped Today</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-user-plus warning font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 primary">{{$totalMipoProcess}}</h3>
                                                <span>PO In Process</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-briefcase primary font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content" style="height:150px;">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body text-left">
                                                <h3 class="mb-1 primary">{{$totalMipoComplete}}</h3>
                                                <span>PO completed</span><br><br>
                                            </div>
                                            <div class="media-right align-self-center">
                                                <i class="ft-briefcase primary font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--End PO card--}}

                        <div class="col-xl-12 col-lg-12 col-12">
                            <div class="card shopping-cart">
                                <div class="card-header pb-2">
                                    <h4 class="card-title mb-1">Overall Enquiry Status Count </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table text-center m-0">
                                                <tbody>
                                                    @if (isset($enquiries_status_count) && count($enquiries_status_count)>0)
                                                          
                                                        <thead>
                                                                @foreach($enquiries_status_count as $key => $value)
                                                                        <th>
                                                                            {{($key == '') ? 'BLANK' : $key}}
                                                                        </th>
                                                                @endforeach
                                                        </thead>
                                                        <tbody>
                                                                @foreach($enquiries_status_count as $key => $value)
                                                                        <td>
                                                                            {{$value ?? 0}}
                                                                        </td>
                                                                @endforeach
                                                        </tbody>
                                                                

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
                                                        {{-- <th>#</th> --}}
                                                        <th>Enq No.</th>
                                                        <th>Region</th>
                                                        <th>E. Due Date</th>
                                                        <th>ENQ Date</th>
                                                        <th>Client</th>
                                                        <th>Status</th>
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
                                                            {{-- <td>{{$i}}</td> --}}
                                                            <td>{{$enquiry->enq_no}}</td>
                                                            <td>{{$enquiry->region_name}}</td>
                                                            <td>{{$enquiry->enq_reminder_date ? date('d-m-Y', strtotime($enquiry->enq_reminder_date)) : '-'}}</td>
                                                            <td>{{$enquiry->enq_register_date ? date('d-m-Y', strtotime($enquiry->enq_register_date)) : '-'}}</td>
                                                            <td>{{$enquiry->client_name}}</td>
                                                            <td>{{$enquiry->engineer_status_name ?? '-'}}</td>
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

     
                        {{-- updated vikas showing hold status on dashboard 2-02-2023 : start     --}}
                        
                        <div class="col-xl-12 col-lg-12 col-12">
                            <div class="card shopping-cart">
                                <div class="card-header pb-2">
                                    <h4 class="card-title mb-1">Enquiry On Hold </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table text-center m-0">
                                                <thead>
                                                    <tr>
                                                        {{-- <th>#</th> --}}
                                                        <th>Enq No.</th>
                                                        <th>Region</th>
                                                        <th>E. Due Date</th>
                                                        <th>ENQ Date</th>
                                                        <th>Client</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($enquiries_on_hold) && count($enquiries_on_hold)>0)
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach($enquiries_on_hold as $enquiry)
                                                         <tr>
                                                            {{-- <td>{{$i}}</td> --}}
                                                            <td>{{$enquiry->enq_no}}</td>
                                                            <td>{{$enquiry->region_name}}</td>
                                                            <td>{{$enquiry->enq_reminder_date ? date('d-m-Y', strtotime($enquiry->enq_reminder_date)) : '-'}}</td>
                                                            <td>{{$enquiry->enq_register_date ? date('d-m-Y', strtotime($enquiry->enq_register_date)) : '-'}}</td>
                                                            <td>{{$enquiry->client_name}}</td>
                                                            <td>{{$enquiry->engineer_status_name ?? '-'}}</td>
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
     {{-- updated vikas showing hold status on dashboard 2-02-2023 : end     --}}

                        {{-- PO table--}}
                        <div class="col-xl-12 col-lg-12 col-12">
                            <div class="card shopping-cart">
                                <div class="card-header pb-2">
                                    <h4 class="card-title mb-1">Po Needs Action </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table text-center m-0">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Po No.</th>
                                                    <th>Region</th>
                                                    <th>Revision</th>
                                                    <th>Po Date</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if (isset($po_need_action) && count($po_need_action)>0)

                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach($po_need_action as $po)
                                                        <tr>
                                                            <td>{{$i}}</td>
                                                            <td>{{$po->po_no}}</td>
                                                            <td>{{$po->region->region_name}}</td>
                                                            <td>{{$po->revision_no}}</td>
                                                            <td>{{$po->po_recv_date ? date('d-m-Y', strtotime($po->po_recv_date)) : '-'}}</td>
                                                            <td>
                                                                <a href="mipo_edit/{{$po->id}}" class="btn btn-success btn-sm src_data" title="Update"><i class="ft-arrow-right"></i></a>

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
                        {{-- End PO table--}}
                        
                    </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
