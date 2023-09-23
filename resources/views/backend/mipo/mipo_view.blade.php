<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    @if(isset($mipo))
                                        <h5 class="pt-2">View Mipo: #{{ $mipo->po_no .' / '. $mipo->region->region_name ?? '' }} /  {{ $mipo->revision_no ?? ''}}</h5>
                                    @endif
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#admin_details" role="tab" id="admin_details-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="admin_details" aria-selected="true">
                                        <i class="ft-info mr-1"></i>
                                        <span class="d-none d-sm-block">Mipo Details</span>
                                    </a>
                                </li>
                                {{-- Mipo User Mipo Template Tab Link--}}
                                <li class="nav-item">
                                    <a href="#mipo_template" role="tab" id="mipo_template-tab" class="nav-link d-flex align-items-center " data-toggle="tab" aria-controls="mipo_template" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <span class="d-none d-sm-block">Mipo Template</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#case_incharge_details" role="tab" id="case_incharge_details-tab" class="nav-link d-flex align-items-center " data-toggle="tab" aria-controls="case_incharge_details" aria-selected="true">
                                        <i class="ft-info mr-1"></i>
                                        <span class="d-none d-sm-block">Case Incharge Details</span>
                                    </a>
                                </li>
                                {{--Estimator Engineer Details Tab Link--}}
                                <li class="nav-item">
                                    <a href="#estimator_engineer_details" role="tab" id="estimator_engineer_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="estimator_engineer_details" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <span class="d-none d-sm-block">Estimator Details</span>
                                    </a>
                                </li>
                                {{--Designer Engineer Details Tab Link--}}
                                @if(isset($mipo) && $mipo->is_gr == 1)
                                    <li class="nav-item">
                                        <a href="#design_engineer_details" role="tab" id="design_engineer_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="design_engineer_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="d-none d-sm-block">Designer Details</span>
                                        </a>
                                    </li>
                                @endif
                                {{-- Commercial Details Tab Link--}}
                                <li class="nav-item">
                                    <a href="#commercial_details" role="tab" id="commercial_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="commercial_details" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <span class="d-none d-sm-block">Commercial Details</span>
                                    </a>
                                </li>
                                {{-- Purchase Team Details Tab Link--}}
                                <li class="nav-item">
                                    @if($mipo->is_frp == 1)
                                        <a href="#purchase_team_details" role="tab" id="purchase_team_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="purchase_team_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="d-none d-sm-block">Purchase Details</span>
                                        </a>
                                    @endif
                                </li>
                                {{-- Mipo Verification Tab Link --}}
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
                            <div class="tab-content">
                                <div class="tab-pane fade mt-2 show active" id="admin_details" role="tabpanel" aria-labelledby="admin_details-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <td><strong>Mipo User</strong></td>
                                                        <td>{{ $mipo->user->admin_name ." / ". $mipo->user->nick_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Enquiry No</strong></td>
                                                        <td>{{ $mipo->enquiry_no . " / " . $mipo->region->region_code . " / " . $mipo->revision_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Po Date</strong></td>
                                                        <td>{{ $mipo->po_recv_date ? date('d-m-Y', strtotime($mipo->po_recv_date)) : '-'; }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Ho Received Date</strong></td>
                                                        <td>{{ $mipo->ho_recv_date ? date('d-m-Y', strtotime($mipo->ho_recv_date)) : '-'; }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Po Type</strong></td>
                                                        <td>{{ strtoupper($mipo->po_type) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Revision</strong></td>
                                                        <td>{{ $mipo->revision_no ?? 0  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Client</strong></td>
                                                        <td>{{ $mipo->client_name ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Project</strong></td>
                                                        <td>{{ $mipo->project_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Region</strong></td>
                                                        <td>{{ $mipo->region->region_code ?? '-'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Enquiry Assigned To Case Incharge</strong></td>
                                                        <td>{{ $mipo->caseIncharge->admin_name ?? '-';}} / {{ $mipo->caseIncharge->nick_name ?? '-';}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Enquiry Assigned To Estimator Engineer</strong></td>
                                                        <td>{{ $mipo->estimateEngineer->admin_name ?? '-';}} / {{ $mipo->estimateEngineer->nick_name ?? '-';}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Product</strong></td>
                                                        <td>{{ $mipo->product->product_code ?? '-';}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Category</strong></td>
                                                        <td>{{ $mipo->category->category_code ?? '-'}} </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Created At</strong></td>
                                                        <td>{{ $mipo->created_at ? date('d-m-Y H:i:s', strtotime($mipo->created_at)) : '-'; }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Reference</strong></td>
                                                        <td>{{ $mipo->reference ?? '' }} </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="mipo_template" role="tabpanel"   aria-labelledby="mipo_template-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <td><strong>Mipo Assigned To Case Incharge</strong></td>
                                                        <td>{{ $mipo->caseIncharge->admin_name ?? '-';}} / {{ $mipo->caseIncharge->nick_name ?? '-'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Mipo Assigned To Estimator Engineer</strong></td>
                                                        <td>{{ $mipo->estimateEngineer->admin_name ?? '-';}} / {{ $mipo->estimateEngineer->nick_name ?? '-'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Commercial</strong></td>
                                                        <td>{{ $mipo->commercial->admin_name  ?? '-';}} / {{ $mipo->commercial->nick_name  ?? '-';}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Allocation Date</strong></td>
                                                        <td>{{ $mipo->mipo_user_allocation_dt  ? date('d-m-Y H:i:s', strtotime($mipo->mipo_user_allocation_dt)) : '-';}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Is FRP</strong></td>
                                                        <td>@if(isset($mipo))
                                                            <dd>{{ $mipo->is_frp == 1 ? 'Yes' : 'No'}}</dd>
                                                            @else
                                                            <dd>-</dd>
                                                        @endif</td>
                                                    </tr>
                                                    @if($mipo->is_frp == 1)
                                                    <tr>
                                                        <td><strong>Purchase Team</strong></td>
                                                        <td>{{ $mipo->purchaseTeam->nick_name ?? '-';}}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td><strong>Negotiation Margin</strong></td>
                                                        <td>{{ $mipo->negotiation_margin ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Payment Terms</strong></td>
                                                        <td>{{ $mipo->payment_terms ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Liquidated Damages</strong></td>
                                                        <td>{{ $mipo->liquidated_damages ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Delivery Date</strong></td>
                                                        <td>{{ $mipo->delivery_date ? date('d-m-Y', strtotime($mipo->delivery_date)) : '-'; }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Freight</strong></td>
                                                        <td>{{ $mipo->freight ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Engineering Input Status</strong></td>
                                                        <td>{{ $mipo->engineering_input_status ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>PO Amount</strong></td>
                                                        <td>{{ $mipo->po_amount ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>PO Quantity</strong></td>
                                                        <td>{{ $mipo->po_quantity ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Client PO Number</strong></td>
                                                        <td>{{ $mipo->client_po_no ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Client PO Date</strong></td>
                                                        <td>{{ $mipo->client_po_date ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="case_incharge_details" role="tabpanel" aria-labelledby="case_incharge_details-tab">
                                    <div class="row">
                                        <div class="col-12">
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
                                                                <a href="{{$url}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
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
                                                                <a href="{{$url}}" class="btn btn-primary mx-2  px-2" target="_blank"><i class="fa ft-eye"></i></a>
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
                                                                       class="form-control input-sm document-border bg-white"
                                                                       value="{{ basename(explode('?', $url)[0]) }}" readonly
                                                                       style="color: black!important;">
                                                                <a href="{{$url}}"
                                                                   class="btn btn-primary mx-2  px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                            </div>
                                                                @endforeach
                                                            @else
                                                                <dd>Document Not uploaded</dd>
                                                            @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Case Incharge Remark</strong></td>
                                                        <td>{{ $mipo->ci_remarks ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>First Engineering Input Date</strong>
                                                        </td>
                                                        <td>{{ $mipo->first_engg_input_date ? \Carbon\Carbon::parse($mipo->first_engg_input_date)->format('d-m-Y') : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Last Engineering Input Date</strong>
                                                        </td>
                                                        <td>{{ $mipo->last_engg_input_date ? \Carbon\Carbon::parse($mipo->last_engg_input_date)->format('d-m-Y') : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Number of Days for Approval</strong>
                                                        </td>
                                                        <td>{{ $mipo->no_of_days_for_approval ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Case Incharge Approval Status</strong>
                                                        </td>
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
                                                        <td width="35%"><strong>Case Incharge Approval Date</strong></td>
                                                        <td>{{ $mipo->ci_document_upload_dt ? date('d-m-Y', strtotime($mipo->ci_document_upload_dt)) : '-'; }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="estimator_engineer_details" role="tabpanel"
                                     aria-labelledby="estimator_engineer_details-tab">
                                    <div class="row">
                                        <div class="col-12">
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
                                                                    <a href="{{$url}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
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
                                                                <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('||',$url)[0]) }}" readonly style="color: black !important;">
                                                                <a href="{{$url}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
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
                                                    @if($mipo->is_gr == 1)
                                                    <tr>
                                                        <td width="35%"><strong>Design Engineer</strong></td>
                                                        <td>{{ $mipo->designEngineer->nick_name ?? '-'}} / {{ $mipo->designEngineer->admin_name ?? '-'}}
                                                        </td>
                                                    </tr>
                                                    @endif
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
                                                        <td width="35%"><strong>Engineer Approval Date</strong></td>
                                                        <td>{{ $mipo->engg_document_upload_dt ? date('d-m-Y', strtotime($mipo->engg_document_upload_dt)) : '-'; }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(isset($mipo) && $mipo->is_gr == 1)
                                    <div class="tab-pane fade mt-2" id="design_engineer_details" role="tabpanel"
                                         aria-labelledby="design_engineer_details-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered">
                                                        <tr>
                                                            <td><strong>Uploaded Design Drawing Document</strong></td>
                                                            <td>@if(count($designDrawingDocumentsSrcArr))
                                                                    @foreach($designDrawingDocumentsSrcArr as $key => $url)
                                                                        @php
                                                                            $uniqueKey = ++$key;
                                                                        @endphp
                                                                        <div class="d-flex mb-1  vendor-po-document-div-{{$uniqueKey}}">
                                                                            <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?', $url)[0]) }}" readonly style="color: black !important;">
                                                                            <a href="{{$url}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <dd>Document Not uploaded</dd>
                                                                @endif
                                                            </td>
                                                            <tr>
                                                                <td width="35%"><strong>Designer Remark</strong></td>
                                                                <td>{{ $mipo->drawing_remarks ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Designer Approval Status</strong></td>
                                                                <td>
                                                                    @if($mipo->drawing_approval_status == 'accepted')
                                                                        <span class="text-success font-weight-bold">Approved</span>
                                                                    @elseif($mipo->drawing_approval_status == 'rejected')
                                                                        <span class="text-danger font-weight-bold">Rejected</span>
                                                                    @else
                                                                        <span class="text-warning font-weight-bold">Pending</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="35%"><strong>Designer Approval Date</strong></td>
                                                                <td>{{ $mipo->drawing_document_upload_dt ?? '-' }}</td>
                                                            </tr>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="tab-pane fade mt-2" id="commercial_details" role="tabpanel"
                                     aria-labelledby="commercial_details-tab">
                                    <div class="row">
                                        <div class="col-12">
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
                                                            <a href="{{$url}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
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
                                                            <a href="{{$url}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
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
                                                            <a href="{{$url}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
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
                                                        <td width="35%"><strong>Commercial Approval Date</strong></td>
                                                        <td>{{ $mipo->commercial_document_upload_dt ? date('d-m-Y', strtotime($mipo->commercial_document_upload_dt)) : '-'; }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="purchase_team_details" role="tabpanel"
                                     aria-labelledby="purchase_team_details-tab">
                                    <div class="row">
                                        <div class="col-12">
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
                                                                    <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('||',$url)[0]) }}" readonly style="color: black !important;">
                                                                    <a href="{{$url}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
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
                                                                    <a href="{{$url}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                </div>
                                                                @endforeach
                                                                @else
                                                                <dd>Document Not uploaded</dd>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                        <td width="35%"><strong>Purchase Approval Date</strong></td>
                                                        <td>{{ $mipo->purchase_document_upload_dt ? date('d-m-Y', strtotime($mipo->purchase_document_upload_dt)) : '-'; }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Purchase Approval Remark</strong></td>
                                                        <td>{{ $mipo->purchase_remarks ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Purchase Approval Status</strong></td>
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
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="mipo_verification_details" role="tabpanel" aria-labelledby="mipo_verification_details-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <td width="35%"><strong>Mipo Verification Status Date</strong></td>
                                                        <td>{{ $mipo->mipo_verification_status_dt ? date('d-m-Y', strtotime($mipo->mipo_verification_status_dt)) : '-'; }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Mipo Verification Remark</strong></td>
                                                        <td>{{ $mipo->mipo_remarks ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Mipo Verification Status</strong></td>
                                                        <td>
                                                            @if($mipo->mipo_verification_status == "accepted")
                                                                <span class="text-success font-weight-bold">Approved</span>
                                                            @elseif($mipo->mipo_verification_status == "rejected")
                                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                                            @else
                                                                <span class="text-warning font-weight-bold"> Pending</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="estimator_head_verification_details" role="tabpanel" aria-labelledby="estimator_head_verification_details-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <td width="35%"><strong>Allocated Estimator Head</strong></td>
                                                        <td>{{ $mipo->headEngineer->nick_name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                    <td width="35%"><strong>Estimator Head Approval Date</strong></td>
                                                    <td>{{ $mipo->head_engg_status_dt ? date('d-m-Y', strtotime($mipo->head_engg_status_dt)) : '-'; }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Estimator Head Approval Remark</strong></td>
                                                        <td>{{ $mipo->head_engg_remarks ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Estimator Head Approval Status</strong></td>
                                                        <td>
                                                            @if($mipo->head_engg_approval_status == "accepted")
                                                                <span class="text-success font-weight-bold">Approved</span>
                                                            @elseif($mipo->head_engg_approval_status == "rejected")
                                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                                            @else
                                                                <span class="text-warning font-weight-bold"> Pending</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="mipo_upload_sheet" role="tabpanel" aria-labelledby="mipo_upload_sheet-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <td><strong>Uploaded Mipo Order Sheet Approval Document</strong></td>
                                                        <td>@if(count($orderApprovalSheetDocumentsSrcArr))
                                                                @foreach($orderApprovalSheetDocumentsSrcArr as $key => $url)
                                                                    @php
                                                                        $uniqueKey = ++$key;
                                                                    @endphp
                                                                    <div class="d-flex mb-1  order-sheet-document-div-{{$uniqueKey}}">
                                                                        <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                        <a href="{{$url}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <dd>Document Not uploaded</dd>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Mipo Order Sheet Approval Date</strong></td>
                                                        <td>{{ $mipo->order_sheet_status_dt ? date('d-m-Y', strtotime($mipo->order_sheet_status_dt)) : '-'; }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Mipo Order Sheet Approval Remark</strong></td>
                                                        <td>{{ $mipo->order_sheet_remarks ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Mipo Order Sheet Approval Status</strong></td>
                                                        <td>
                                                            @if($mipo->order_sheet_approval_status == "accepted")
                                                                <span class="text-success font-weight-bold">Approved</span>
                                                            @elseif($mipo->order_sheet_approval_status == "rejected")
                                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                                            @else
                                                                <span class="text-warning font-weight-bold"> Pending</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="management_verification_details" role="tabpanel" aria-labelledby="management_verification_details-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <td width="35%"><strong>Allocated Management User</strong></td>
                                                        <td>{{ $mipo->managementUser->nick_name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Management Approval Date</strong></td>
                                                        <td>{{ $mipo->management_status_dt ? date('d-m-Y', strtotime($mipo->management_status_dt)) : '-'; }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Management Approval Remark</strong></td>
                                                        <td>{{ $mipo->management_remarks ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>Management Approval Status</strong></td>
                                                        <td>
                                                            @if($mipo->management_approval_status == "accepted")
                                                                <span class="text-success font-weight-bold">Approved</span>
                                                            @elseif($mipo->management_approval_status == "rejected")
                                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                                            @else
                                                                <span class="text-warning font-weight-bold"> Pending</span>
                                                            @endif
                                                        </td>
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
