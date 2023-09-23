<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">
                                                Verification For Management: #{{ $mipo->po_no .' / '. $mipo->region->region_name ?? '' }} /  {{ $mipo->revision_no ?? ''}}
                               </h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                        <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    {{-- Mipo Deatils Tab Link--}}  
                                    <li class="nav-item">
                                        <a href="#admin_details" role="tab" id="admin_details-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="admin_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Mipo Details</span>
                                        </a>
                                    </li>
                                    {{-- Mipo User Mipo Template Tab Link--}}
                                    <li class="nav-item">
                                        <a href="#mipo_template" role="tab" id="mipo_template-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="mipo_template" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Mipo Template</span>
                                        </a>
                                    </li>
                                    {{-- Team Deatils Tab Link--}}
                                        <li class="nav-item">
                                            <a href="#team_details" role="tab" id="team_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="team_details" aria-selected="false">
                                                <i class="ft-info mr-1"></i>
                                                <span class="">Team Details</span>
                                            </a>
                                        </li>
                                    {{-- Mipo Approve reject Tab Link--}}
                                    <li class="nav-item">
                                        <a href="#mipo_verification_details" role="tab" id="mipo_verification_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="mipo_verification_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Mipo Verification</span>
                                        </a>
                                    </li>
                                    {{-- Estimator Head Approval Details Tab Link--}}
                                    <li class="nav-item">
                                        <a href="#estimator_head_verification_details" role="tab" id="estimator_head_verification_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="estimator_head_verification_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Estimator Head Verification</span>
                                        </a>
                                    </li>
                                    {{-- Mipo uploads Order approval sheet Tab Link--}}
                                    <li class="nav-item">
                                        <a href="#mipo_upload_sheet" role="tab" id="mipo_upload_sheet-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="mipo_upload_sheet" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Order Approval Sheet</span>
                                        </a>
                                    </li>
                                    {{-- Management Verification Tab Link--}}
                                    <li class="nav-item">
                                        <a href="#management_verification_details" role="tab" id="management_verification_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="management_verification_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Management Verification</span>
                                        </a>
                                    </li>
                                </ul>
                                @csrf
                                <div class="tab-content">       
                                    <div class="tab-pane fade mt-2 show active" id="admin_details" role="tabpanel"
                                         aria-labelledby="admin_details-tab">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <strong>Po No</strong>
                                                <dd>{{ $mipo->po_no ?? '' }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Enquiry No</strong>
                                                <dd>{{ $mipo->enquiry_no ?? '' }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Po Date</strong>
                                                <dd>{{$mipo->po_recv_date ? date('Y-m-d', strtotime($mipo->po_recv_date)) : '' }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Ho Date</strong>
                                                <dd>{{$mipo->ho_recv_date ? date('Y-m-d', strtotime($mipo->ho_recv_date)) : '' }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Po Type</strong>
                                                <dd>{{ strtoupper($mipo->po_type ?? '' ) }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Revision</strong>
                                                <dd>{{$mipo->revision_no ?? '' }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Client</strong>
                                                <dd>{{$mipo->client_name ?? '' }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Project</strong>
                                                <dd>{{$mipo->project_name ?? '' }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Region</strong>
                                                <dd>{{$mipo->region->region_name ?? '' }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Case Incharge</strong>
                                                <dd>{{$mipo->caseIncharge->nick_name ?? '' }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Engineer</strong>
                                                <dd>{{$mipo->estimateEngineer->nick_name ?? '' }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Product</strong>
                                                <dd>{{$mipo->product->product_code ?? '' }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Category</strong>
                                                <dd>{{$mipo->category->category_code ?? '' }}</dd>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Reference</strong>
                                                <dd>{{$mipo->reference ?? '' }}</dd>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                    "btn btn-outline-danger  py-1 font-weight-bolder cancel-btn">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade mt-2" id="mipo_template" role="tabpanel" aria-labelledby="mipo_template-tab">
                                        <div class="row">
                                            <div class="col-sm-6 my-1">
                                                <strong>Case Incharge</strong>
                                                <dd>{{ $mipo->caseIncharge->nick_name ?? '-'}}</dd>
                                            </div>
                                            <div class="col-sm-6 my-1">
                                                <strong>Estimator Engineer</strong>
                                                <dd>{{ $mipo->estimateEngineer->nick_name ?? '-'}}</dd>
                                            </div>
                                            <div class="col-sm-6 my-1">
                                                <strong>Commercial</strong>
                                                <dd>{{ $mipo->commercial->nick_name ?? '-'}}</dd>
                                            </div>
                                            <div class="col-sm-6 my-1">
                                                <strong>Is FRP</strong>
                                                <dd>{{ $mipo->is_frp == 1 ? 'Yes' : 'No'}}</dd>
                                            </div>
                                            @if($mipo->is_frp == 1)
                                                <div class="col-sm-6 my-1">
                                                    <strong>Purchase Team</strong>
                                                    <dd>{{ $mipo->purchaseTeam->nick_name ?? '-'}}</dd>
                                                </div>
                                            @endif
                                            <div class="col-sm-6 my-1">
                                                <strong>Client PO Number</strong>
                                                <dd>{{ $mipo->client_po_no ?? '-' }}</dd>
                                            </div>
                                            <div class="col-sm-6 my-1">
                                                <strong>Client PO Date</strong>
                                                <dd>{{ $mipo->client_po_date ?? '-' }}</dd>
                                            </div>
                                            <div class="col-sm-6 my-1">
                                                <strong>PO Amount</strong>
                                                <dd>{{ $mipo->po_amount ?? '-' }}</dd>
                                            </div>
                                            <div class="col-sm-6 my-1">
                                                <strong>PO Quantity</strong>
                                                <dd>{{ $mipo->po_quantity ?? '-' }}</dd>
                                            </div>
                                            <div class="col-sm-6 my-1">
                                                <strong>Liquidated Damages</strong>
                                                <dd>{{ $mipo->liquidated_damages ?? '-' }}</dd>
                                            </div>
                                            <div class="col-sm-6 my-1">
                                                <strong>Delivery Date</strong>
                                                <dd>{{ $mipo->delivery_date ? date('d-m-Y', strtotime($mipo->delivery_date)) : '-'; }}</dd>
                                            </div>
                                            <div class="col-sm-6 my-1">
                                                <strong>Freight</strong>
                                                <dd>{{ $mipo->freight ?? '-' }}</dd>
                                            </div>
                                            <div class="col-sm-6 my-1">
                                                <strong>Engineering Input Status</strong>
                                                <dd>{{ $mipo->engineering_input_status ?? '-' }}</dd>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                    "btn btn-outline-danger  py-1 font-weight-bolder cancel-btn">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade mt-2" id="team_details" role="tabpanel" aria-labelledby="team_details-tab">
                                            
                                            {{--  case incharge table--}}
                                            <div class="row my-3">
                                                <div class="col-12">
                                                    <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Case Incharge {{$mipo->caseIncharge->nick_name}} Deatils</h5>

                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <tr>
                                                                <td><strong>DCL Document</strong></td>
                                                                <td>@if(count($dclDocumentsSrcArr))
                                                                        @foreach($dclDocumentsSrcArr as $key => $url)
                                                                            @php
                                                                                $uniqueKey = ++$key;
                                                                            @endphp
                                                                            <div class="d-flex mb-1  dcl-document-div-{{$uniqueKey}}">
                                                                                <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                                <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <dd>Document Not uploaded</dd>
                                                                    @endif</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>MI Document</strong></td>
                                                                <td>@if(count($miDocumentsSrcArr))
                                                                        @foreach($miDocumentsSrcArr as $key => $url)
                                                                            @php
                                                                                $uniqueKey = ++$key;
                                                                            @endphp
                                                                            <div class="d-flex mb-1 mi-document-div-{{$uniqueKey}}">
                                                                                <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                                <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2  px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <dd>Document Not uploaded</dd>
                                                                    @endif</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Extra Document</strong></td>
                                                                <td>@if(count($extraCiDocumentsSrcArr))
                                                                        @foreach($extraCiDocumentsSrcArr as $key => $url)
                                                                            @php
                                                                                $uniqueKey = ++$key;
                                                                            @endphp
                                                                            <div class="d-flex mb-1 extra-document-div-{{$uniqueKey}}">
                                                                                <input type="text"
                                                                                       class="form-control input-sm document-border bg-white "
                                                                                       value="{{ basename(explode('?',$url)[0]) }}"
                                                                                       readonly
                                                                                       style="color: black!important;">
                                                                                <a href="{{explode('||',$url)[0]}}"
                                                                                   class="btn btn-primary mx-2  px-2"
                                                                                   target="_blank"><i
                                                                                            class="fa ft-eye"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <dd>Document Not uploaded</dd>
                                                                    @endif</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>First Engineering Input
                                                                        Date</strong></td>
                                                                <td>{{ $mipo->first_engg_input_date ? \Carbon\Carbon::parse($mipo->first_engg_input_date)->format('d-m-Y') : '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Last Engineering Input
                                                                        Date</strong></td>
                                                                <td>{{ $mipo->last_engg_input_date ? \Carbon\Carbon::parse($mipo->last_engg_input_date)->format('d-m-Y') : '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Number of Days for
                                                                        Approval</strong></td>
                                                                <td>{{ $mipo->no_of_days_for_approval ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Case Incharge Remark</strong>
                                                                </td>
                                                                <td>{{ $mipo->ci_remarks ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Case Incharge Approval
                                                                        Status</strong></td>
                                                                <td>@if($mipo->ci_approval_status == 'accepted')
                                                                        <span class="text-success font-weight-bold">Approved</span>
                                                                    @elseif($mipo->ci_approval_status == 'rejected')
                                                                        <span class="text-danger font-weight-bold">Rejected</span>
                                                                    @else
                                                                        <span class="text-warning font-weight-bold">Pending</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Case Incharge Document Upload Date</strong></td>
                                                                <td>{{ $mipo->ci_document_upload_dt ?? '-' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--  Estimator table--}}
                                            <div class="row my-3">
                                                <div class="col-12">
                                                    <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Estimator Engineer {{$mipo->estimateEngineer->nick_name}} Deatils</h5>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <tr>
                                                                <td><strong>Uploaded PO cost sheet Document</strong></td>
                                                                <td>@if(isset($poCostSheetDocumentsSrcArr))
                                                                        @foreach($poCostSheetDocumentsSrcArr as $key => $url)
                                                                            @php
                                                                                $uniqueKey = ++$key;
                                                                            @endphp
                                                                            <div class="d-flex mb-1  po-cost-sheet-document-div-{{$uniqueKey}}">
                                                                                <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                                <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <p>Documents not uploaded</p>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Uploaded Extra Document</strong></td>
                                                                <td>@if(isset($extraEstimatorDocumentsSrcArr) && count($extraEstimatorDocumentsSrcArr))
                                                                        @foreach($extraEstimatorDocumentsSrcArr as $key => $url)
                                                                            @php
                                                                                $uniqueKey = ++$key;
                                                                            @endphp
                                                                            <div class="d-flex mb-1  estimator-extra-document-div-{{$uniqueKey}}">
                                                                                <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                                <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <p>Documents not uploaded</p>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Is GR</strong></td>
                                                                <td>{{ $mipo->is_gr == 1 ? 'Yes' : 'No'}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Design Engineer</strong></td>
                                                                <td>{{ $mipo->designEngineer->nick_name ?? '-'}} / {{ $mipo->designEngineer->admin_name ?? '-'}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Design Engineer Remark</strong></td>
                                                                <td>{{ $mipo->drawing_remarks ??  '-'}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Design Drawing Document Upload Date</strong></td>
                                                                <td>{{ $mipo->drawing_document_upload_dt ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Estimator Engineer Approval Status</strong></td>
                                                                <td>
                                                                    @if($mipo->engg_approval_status == "accepted")
                                                                        <span class="text-success font-weight-bold">Approved</span>
                                                                    @elseif($mipo->engg_approval_status == "rejected")
                                                                        <span class="text-danger font-weight-bold"> Rejected</span>
                                                                    @else
                                                                        <span class="text-warning font-weight-bold"> Pending</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Engineer Remark</strong></td>
                                                                <td>{{ $mipo->engg_remarks ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Engineer Document Upload Date</strong></td>
                                                                <td>{{ $mipo->engg_document_upload_dt ?? '-' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            {{--  Designer table--}}
                                            @if($mipo->is_gr == 1)
                                            <div class="row my-3">
                                                <div class="col-12">
                                                    <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Design Engineer {{$mipo->designEngineer->nick_name}} Deatils</h5>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <tr>
                                                                <td width="35%"><strong>Uploaded Design Drawing Document</strong></td>
                                                                <td>@if(count($designDrawingDocumentsSrcArr))
                                                                        @foreach($designDrawingDocumentsSrcArr as $key => $url)
                                                                            @php
                                                                                $uniqueKey = ++$key;
                                                                            @endphp
                                                                            <div class="d-flex mb-1  vendor-po-document-div-{{$uniqueKey}}">
                                                                                <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                                <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <dd>Document Not uploaded</dd>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            {{--  Commercial table--}}
                                            <div class="row my-3">
                                                <div class="col-12">
                                                    <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Commercial {{$mipo->commercial->nick_name}} Deatils</h5>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <tr>
                                                                <td><strong>Uploaded Templates</strong></td>
                                                                <td>@if(count($templateDocumentsSrcArr))
                                                                        @foreach($templateDocumentsSrcArr as $key => $url)
                                                                            @php
                                                                                $uniqueKey = ++$key;
                                                                            @endphp
                                                                            <div class="d-flex mb-1  template-document-div-{{$uniqueKey}}">
                                                                                <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                                <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <dd>Document Not uploaded</dd>
                                                                    @endif</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Uploaded PO details</strong></td>
                                                                <td>@if(count($poDetailDocumentsSrcArr))
                                                                        @foreach($poDetailDocumentsSrcArr as $key => $url)
                                                                            @php
                                                                                $uniqueKey = ++$key;
                                                                            @endphp
                                                                            <div class="d-flex mb-1  po-detail-document-div-{{$uniqueKey}}">
                                                                                <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                                <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <dd>Document Not uploaded</dd>
                                                                    @endif</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Uploaded Extra Documents</strong></td>
                                                                <td>@if(count($extraCommercialDocumentsSrcArr))
                                                                        @foreach($extraCommercialDocumentsSrcArr as $key => $url)
                                                                            @php
                                                                                $uniqueKey = ++$key;
                                                                            @endphp
                                                                            <div class="d-flex mb-1  extra-document-div-{{$uniqueKey}}">
                                                                                <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                                <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <dd>Document Not uploaded</dd>
                                                                    @endif</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Commercial Approval Status</strong></td>
                                                                <td>
                                                                    @if($mipo->commercial_approval_status == "accepted")
                                                                        <span class="text-success font-weight-bold">Approved</span>
                                                                    @elseif($mipo->commercial_approval_status == "rejected")
                                                                        <span class="text-danger font-weight-bold"> Rejected</span>
                                                                    @else
                                                                        <span class="text-warning font-weight-bold"> Pending</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Commercial Remark</strong></td>
                                                                <td>{{ $mipo->commercial_remarks ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Commercial Document Upload Date</strong></td>
                                                                <td>{{ $mipo->commercial_document_upload_dt ?? '-' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                
                                            {{--  Purchase Team table--}}
                                            @if($mipo->is_frp == 1)
                                            <div class="row my-3">
                                                <div class="col-12">
                                                    <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Purchase Team {{$mipo->purchaseTeam->nick_name}} Deatils</h5> 
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <tr>
                                                                <td><strong>Uploaded Vendor PO Document</strong></td>
                                                                <td>@if(count($vendorPoDocumentsSrcArr))
                                                                        @foreach($vendorPoDocumentsSrcArr as $key => $url)
                                                                            @php
                                                                                $uniqueKey = ++$key;
                                                                            @endphp
                                                                            <div class="d-flex mb-1  vendor-po-document-div-{{$uniqueKey}}">
                                                                                <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                                <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <dd>Document Not uploaded</dd>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Uploaded Extra Documents</strong></td>
                                                                <td>@if(count($extraPurchaseDocumentsSrcArr))
                                                                        @foreach($extraPurchaseDocumentsSrcArr as $key => $url)
                                                                            @php
                                                                                $uniqueKey = ++$key;
                                                                            @endphp
                                                                            <div class="d-flex mb-1  extra-document-div-{{$uniqueKey}}">
                                                                                <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                                <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <dd>Document Not uploaded</dd>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Purchase Team Approval Status</strong></td>
                                                                <td>
                                                                    @if($mipo->purchase_approval_status == "accepted")
                                                                        <span class="text-success font-weight-bold">Approved</span>
                                                                    @elseif($mipo->purchase_approval_status == "rejected")
                                                                        <span class="text-danger font-weight-bold"> Rejected</span>
                                                                    @else
                                                                        <span class="text-warning font-weight-bold"> Pending</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Purchase Team Remark</strong></td>
                                                                <td>{{ $mipo->purchase_remarks ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Purchase Team Document Upload Date</strong></td>
                                                                <td>{{ $mipo->purchase_document_upload_dt ?? '-' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="pull-right">
                                                        <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                        "btn btn-outline-danger  py-1 font-weight-bolder cancel-btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="tab-pane fade mt-2" id="mipo_verification_details" role="tabpanel" aria-labelledby="mipo_verification_details-tab">
                                        <div class="row">
                                            <div class="col-sm-12 my-2">
                                                <strong>Allocated Estimator Head</strong>
                                                <input type="hidden" id="estimator_head" name="estimator_head" value="{{ $mipo->headEngineer->nick_name ?? ''}}">
                                                <dd>{{ $mipo->headEngineer->nick_name ?? '-'}} </dd>
                                            </div>
                                            <div class="col-sm-12 my-2">
                                                <strong>Mipo Remarks</strong>
                                                <input type="hidden" id="mipo_remarks" name="mipo_remarks" value="{{ $mipo->mipo_remarks ?? ''; }}">
                                                <dd>{{ $mipo->mipo_remarks ?? '-'}} </dd>
                                            </div>
                                            <div class="col-sm-12 my-2">
                                                <strong>Mipo Verification Status</strong>
                                                <input type="hidden" id="mipo_verification_status" name="mipo_verification_status" value="{{ $mipo->mipo_verification_status ?? ''}}">
                                                @if($mipo->mipo_verification_status == "accepted")
                                                <dd class="text-success font-weight-bolder">Approved</dd>
                                                @elseif($mipo->mipo_verification_status == "rejected")
                                                    <dd class="text-danger font-weight-bolder">Rejected</dd>
                                                @else
                                                    <dd class="text-warning font-weight-bolder">Pending</dd>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-3 mb-2">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                    "btn btn-outline-danger  py-1 font-weight-bolder cancel-btn">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade mt-2" id="estimator_head_verification_details" role="tabpanel" aria-labelledby="estimator_head_verification_details-tab">
                                        <div class="row">
                                            <div class="col-sm-12 my-2">
                                                <strong>Estimator Head Remarks</strong>
                                                <input type="hidden" id="head_engg_remarks" name="head_engg_remarks" value="{{ $mipo->head_engg_remarks ?? ''; }}">
                                                <dd>{{ $mipo->head_engg_remarks ?? '-'}} </dd>
                                            </div>
                                            <div class="col-sm-12 my-2">
                                                <strong>Estimator Head Verification Status</strong>
                                                <input type="hidden" id="head_engg_approval_status" name="head_engg_approval_status" value="{{ $mipo->head_engg_approval_status ?? ''}}">
                                                @if($mipo->head_engg_approval_status == "accepted")
                                                    <dd class="text-success font-weight-bolder">Approved</dd>
                                                @elseif($mipo->head_engg_approval_status == "rejected")
                                                    <dd class="text-danger font-weight-bolder">Rejected</dd>
                                                @else
                                                    <dd class="text-warning font-weight-bolder">Pending</dd>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-3 mb-2">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                    "btn btn-outline-danger  py-1 font-weight-bolder cancel-btn">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade mt-2" id="mipo_upload_sheet" role="tabpanel" aria-labelledby="mipo_upload_sheet-tab">
                                        <form id="addMipoOrderApprovalSheet" method="post" action="save_mipo_order_approval_form">
                                            @csrf
                                            <input type="hidden" name="mipo_id" id="mipoId" value="{{ $mipo->id ?? '' }}">
                                            <input type="hidden" name="mipo_order_sheet_approval_status" value="">
                                            <input type="hidden" name="mipo_order_sheet_reject_status" value="">
                                            <div class="row my-4">
                                                <div class="col-md-6 col-sm-12 my-2">
                                                    <p class="font-weight-bold">Uploaded Order Approval Sheet</p>
                                                    <p class="order-sheet-file-count"></p>
                                                    <div class="mt-2">
                                                        @if(count($orderApprovalSheetDocumentsSrcArr))
                                                            @foreach($orderApprovalSheetDocumentsSrcArr as $key => $url)
                                                                @php
                                                                    $uniqueKey = ++$key;
                                                                @endphp
                                                                <div class="d-flex mb-1  order-sheet-document-div-{{$uniqueKey}}">
                                                                    <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                    <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            Documents not uploaded
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 my-2">
                                                    <strong>Allocated Management User</strong>
                                                    <input type="hidden" id="management_user" name="management_user" value="{{ $mipo->managementUser->nick_name ?? ''}}">
                                                    <dd>{{ $mipo->managementUser->nick_name ?? '-'}} </dd>
                                                </div>
                                                <div class="col-sm-12 my-2">
                                                    <strong>Mipo Team Remarks</strong>
                                                    <input type="hidden" id="order_sheet_remarks" name="mipo_remarks" value="{{ $mipo->order_sheet_remarks ?? ''; }}">
                                                    <dd>{{ $mipo->order_sheet_remarks ?? '-'}} </dd>
                                                </div>
                                                <div class="col-sm-12 my-2">
                                                    <strong>Mipo Order Sheet Approval Status</strong>
                                                        <input type="hidden" id="order_sheet_approval_status" name="order_sheet_approval_status" value="{{ $mipo->order_sheet_approval_status ?? ''}}">
                                                    @if($mipo->order_sheet_approval_status == "accepted")
                                                        <dd class="text-success font-weight-bolder">Approved</dd>
                                                    @elseif($mipo->order_sheet_approval_status == "rejected")
                                                        <dd class="text-danger font-weight-bolder">Rejected</dd>
                                                    @else
                                                        <dd class="text-warning font-weight-bolder">Pending</dd>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="pull-right">
                                                        <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                        "btn btn-outline-danger  py-1 font-weight-bolder cancel-btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade mt-2" id="management_verification_details" role="tabpanel" aria-labelledby="management_verification_details-tab">
                                        <form id="addManagementVerificationForm" method="post" action="save_management_verification">
                                            @csrf
                                            <input type="hidden" name="mipo_id" id="mipoId" value="{{ $mipo->id ?? '' }}">
                                            <input type="hidden" name="management_approval_status" value="">
                                            <input type="hidden" name="management_reject_status" value="">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Management Remarks</label>
                                                    <textarea class="form-control" id="management_remarks" name="management_remarks" rows="4" {{$mipo->management_approval_status != "pending" ? "readonly" : ''}}>{{$mipo->management_remarks ?? ''}}</textarea><br/>
                                                </div>
                                            </div>
                                            <div class="row mt-3 mb-2">
                                                <div class="col-sm-12">
                                                    <div class="pull-right">
                                                        @if($mipo->management_approval_status == "pending")
                                                        <button type="button" class="btn btn-success font-weight-bolder accept-btn mr-4 management_approval_status">Approve & forward</button>
                                                        <button type="button" class="reject-btn btn btn-danger py-1 mr-4 font-weight-bolder management_reject_status">Reject</button>
                                                        @endif
                                                        <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                        "btn btn-outline-danger  py-1 font-weight-bolder cancel-btn">Cancel</a>
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
        </div>
    </div>
</section>
<script>
    $('.select2').select2();

    $('.management_approval_status').click(function () {

        $("input[name='management_approval_status']").val('approve');
        $("input[name='management_reject_status']").val('');

        submitForm('addManagementVerificationForm','post')

    });

    $('.management_reject_status').click(function () {

        $("input[name='management_reject_status']").val('rejected');
        $("input[name='management_approval_status']").val('');

        submitForm('addManagementVerificationForm','post')

    });

</script>
 

