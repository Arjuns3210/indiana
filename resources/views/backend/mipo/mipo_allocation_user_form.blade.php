<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Allocation Users For Mipo: #{{ $mipo->po_no .' / '. $mipo->region->region_name ?? '' }} /  {{ $mipo->revision_no ?? ''}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                        <div class="card-body">
                            <form id="addMipoAllocationForm" method="post" action="save-mipo-allocation">
                                <input type="hidden" name="mipo_id" id="mipoId" value="{{ $mipo->id ?? '' }}">
                                <ul class="nav nav-tabs" role="tablist">
                                    {{-- PO Order details Tab Link --}}
                                    <li class="nav-item">
                                        <a href="#admin_details" role="tab" id="admin_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="admin_details" aria-selected="true">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Mipo Details</span>
                                        </a>
                                    </li>
                                    {{-- Mipo User Mipo Template Tab Link--}}
                                    <li class="nav-item">
                                        <a href="#mipo_template" role="tab" id="mipo_template-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="mipo_template" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Mipo Template</span>
                                        </a>
                                    </li>
                                    @if($mipo->ci_approval_status == "accepted" && $mipo->engg_approval_status == "accepted" && $mipo->commercial_approval_status == "accepted" && $mipo->purchase_approval_status == "accepted")
                                        {{-- Team Deatils Tab Link--}}
                                        <li class="nav-item">
                                            <a href="#team_details" role="tab" id="team_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="team_details" aria-selected="false">
                                                <i class="ft-info mr-1"></i>
                                                <span class="">Team Details</span>
                                            </a>
                                        </li>
                                    @else
                                    @if(!is_null($mipo->allocation_completion_dt))
                                    {{-- Case Incharge Details Tab Link--}}
                                    <li class="nav-item">
                                        <a href="#case_incharge_details" role="tab" id="case_incharge_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="case_incharge_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Case Incharge Details</span>
                                        </a>
                                    </li>   
                                    {{-- Estimator Engineer Details Tab Link--}}
                                    <li class="nav-item">
                                        <a href="#estimator_engineer_details" role="tab" id="estimator_engineer_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="estimator_engineer_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Estimator Details</span>
                                        </a>
                                    </li>
                                    {{-- Design Engineer Details Tab Link--}}
                                    @if($mipo->is_gr == 1)
                                    <li class="nav-item">
                                        <a href="#design_engineer_details" role="tab" id="design_engineer_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="design_engineer_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Designer Details</span>
                                        </a>
                                    </li>
                                    @endif
                                    {{-- Commercial Details Tab Link--}}
                                    <li class="nav-item">
                                        <a href="#commercial_details" role="tab" id="commercial_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="commercial_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Commercial Details</span>
                                        </a>
                                    </li>
                                    {{-- Purchase Team Details Tab Link--}}
                                    @if($mipo->is_frp == 1)
                                    <li class="nav-item">
                                        <a href="#purchase_team_details" role="tab" id="purchase_team_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="purchase_team_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Purchase Details</span>
                                        </a>
                                    </li>
                                    @endif
                                    @endif
                                    @endif
                                </ul>

                                @csrf
                                <div class="tab-content">
                                    <div class="tab-pane fade mt-2" id="admin_details" role="tabpanel" aria-labelledby="admin_details-tab">
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
                                    </div>
                                    <div class="tab-pane fade mt-2 show active" id="mipo_template" role="tabpanel" aria-labelledby="mipo_template-tab">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Case Incharge<span style="color:#ff0000">*</span></label>
                                                <select class="select2 required" id="case_incharge_id" name="case_incharge_id" style="width: 100% !important;" {{ $mipo->ci_approval_status != "pending" ? 'readonly': '' }}>
                                                    <option value="">Select Case Incharge</option>
                                                    @foreach($caseIncharges  as $user)
                                                        <option value="{{$user->id}}" {{ (isset($mipo) && $mipo->case_incharge_id == $user->id) ? 'selected' : '' }}>{{ $user->nick_name }}</option>
                                                    @endforeach
                                                </select><br/><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <h6 class="mt-sm-4">
                                                    @if(isset($mipo->caseIncharge->nick_name))
                                                        Currently Allocated CaseIncharge is
                                                        <strong>{{ $mipo->caseIncharge->nick_name }}</strong>
                                                    @endif
                                                </h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Estimator Engineer<span style="color:#ff0000">*</span></label>
                                                <select class="select2 required" id="engineer_id" name="engineer_id" style="width: 100% !important;" {{ $mipo->engg_approval_status != "pending" ? 'readonly': '' }}>
                                                    <option value="">Select Estimator Engineer</option>
                                                    @foreach($engineers  as $user)
                                                        <option value="{{$user->id}}" {{ (isset($mipo) && $mipo->engineer_id == $user->id) ? 'selected' : '' }}>{{ $user->nick_name }}</option>
                                                    @endforeach
                                                </select><br/><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <h6 class="mt-sm-4">
                                                    @if(isset($mipo->estimateEngineer->nick_name))
                                                        Currently Allocated Estimator Engineer is
                                                        <strong>{{ $mipo->estimateEngineer->nick_name }}</strong>
                                                    @endif
                                                </h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>commercial<span style="color:#ff0000">*</span></label>
                                                <select class="select2 required" id="commercial_id" name="commercial_id" style="width: 100% !important;" {{ $mipo->commercial_approval_status != "pending" ? 'readonly': ''}}>
                                                    <option value="">Select Commercial</option>
                                                    @foreach($commercial  as $user)
                                                        <option value="{{$user->id}}" {{ (isset($mipo) && $mipo->commercial_id == $user->id) ? 'selected' : '' }}>{{ $user->nick_name }}</option>
                                                    @endforeach
                                                </select>
                                                <br/><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <h6 class="mt-sm-4">
                                                    @if(isset($mipo->commercial->nick_name))
                                                        Currently Allocated commercial is
                                                        <strong>{{ $mipo->commercial->nick_name }}</strong>
                                                    @endif
                                                </h6>
                                            </div>
                                                @if($mipo->is_frp == 0 || ($mipo->is_frp == 1 && $mipo->purchase_approval_status == "pending"))
                                            <div class="col-sm-6 mb-2">
                                                <label class="d-block">Is FRP<span style="color:#ff0000">*</span></label>
                                                <div class="d-inline-block mr-2">
                                                    <div class="radio radio-success">
                                                        <input type="radio" name="is_frp" id="color-radio-3" value="1" {{$mipo->is_frp == 1 ? 'checked' : ''}}>
                                                        <label for="color-radio-3">Yes</label>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block mr-2">
                                                    <div class="radio radio-warning">
                                                        <input type="radio" name="is_frp" id="color-radio-4" value="0"  {{$mipo->is_frp == 0 ? 'checked' : ''}}>
                                                        <label for="color-radio-4">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6"></div>
                                            <div class="col-sm-6">
                                                <div class="purchase-team {{ $mipo->is_frp == 0 ? 'd-none' : '' }}">
                                                    <label>Purchase Team<span style="color:#ff0000">*</span></label>
                                                    <select class="select2 {{ $mipo->is_frp == 1 ? 'required' : '' }}" id="purchase_id" name="purchase_id" style="width: 100% !important;">
                                                        <option value="">Select Purchase Team</option>
                                                        @foreach($purchaseTeams as $user)
                                                            <option value="{{$user->id}}" {{ (isset($mipo) && $mipo->purchase_id == $user->id) ? 'selected' : '' }}>{{ $user->nick_name }}</option>
                                                        @endforeach
                                                    </select><br/><br/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="purchase-team {{ $mipo->is_frp == 0 ? 'd-none' : '' }}">
                                                    <h6 class="mt-sm-4">
                                                        @if(isset($mipo->purchaseTeam->nick_name))
                                                            Currently Allocated Purchase Team is
                                                            <strong>{{ $mipo->purchaseTeam->nick_name }}</strong>
                                                        @endif
                                                    </h6>
                                                </div>
                                            </div>
                                                @else
                                                    <div class="col-12">
                                                        <strong>Is FRP</strong>
                                                        <dd>{{$mipo->is_frp == 1 ? 'Yes' : 'No' }}</dd>
                                                    </div>
                                                    @if($mipo->is_frp == 1)
                                                        <div class="col-12">
                                                            <strong>Purchase Team</strong>
                                                            <dd>{{$mipo->purchaseTeam->nick_name ?? '-' }}</dd>
                                                        </div>
                                                    @endif
                                                @endif
                                            <div class="col-sm-6">
                                                <label>Negotiation Margin</label>
                                                <input type="text" id="negotiation_margin" name="negotiation_margin" value="{{ $mipo->negotiation_margin ?? '' }}" class="form-control" placeholder="Negotiation Margin">
                                                @if (!empty($client_histories))
                                                    <br>
                                                    @php
                                                        $negotiation_margins = array_column($client_histories->toArray(), 'negotiation_margin', 'created_at');
                                                    @endphp
                                                    @if(!empty($negotiation_margins))
                                                        <ul class="accordion-list">
                                                            @foreach($negotiation_margins as $created_at => $negotiation_margin)
                                                                <li class="accordion-child">
                                                                    <h3><p>Previous Negotiation Margin: {{ date('Y-m-d h:i A', strtotime($created_at)) }}</p></h3>
                                                                    <div class="answer">
                                                                        {{$negotiation_margin}}
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Payment Terms</label>
                                                <textarea id="payment_terms" name="payment_terms" class="form-control" placeholder="Payment Terms">{{ $mipo->payment_terms ?? '' }}</textarea>
                                                <div class="mt-2">
                                                    @if (!empty($client_histories))
                                                        @php
                                                            $payment_terms = array_column($client_histories->toArray(), 'payment_terms', 'created_at');
                                                        @endphp
                                                        @if(!empty($payment_terms))
                                                            <ul class="accordion-list">
                                                                @foreach($payment_terms as $created_at => $payment_term)
                                                                    <li class="accordion-child">
                                                                        <h3><p>Previous Negotiation Margin: {{ date('Y-m-d H:i A', strtotime($created_at)) }}</p></h3>
                                                                        <div class="answer">
                                                                            {{$payment_term}}
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Client PO Number</label>
                                                <input type="text" name="client_po_no" id="client_po_no" class="form-control" placeholder="Enter Client PO Number" value="{{ $mipo->client_po_no ?? '' }}">
                                                <br>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Client PO Date</label>
                                                <input type="date" id="client_po_date" name="client_po_date" class="form-control" value="{{ $mipo->client_po_date ?? '' }}">
                                                <br>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>PO Amount</label>
                                                <input type="number" name="po_amount" id="po_amount" class="form-control" placeholder="Enter PO Amount" value="{{ $mipo->po_amount ?? '' }}">
                                                <br>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>PO Quantity</label>
                                                <input type="number" name="po_quantity" id="po_quantity" class="form-control" placeholder="Enter PO Quantity" value="{{ $mipo->po_quantity ?? '' }}">
                                                <br>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Liquidated Damages</label>
                                                <input type="text" id="liquidated_damages" name="liquidated_damages" value="{{ $mipo->liquidated_damages ?? '' }}" class="form-control" placeholder="Liquidated Damages">
                                                <br>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Delivery Date</label>
                                                <input type="date" id="delivery_date" name="delivery_date" value="{{ $mipo->delivery_date ?? '' }}" class="form-control">
                                                <br>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Freight</label>
                                                <input type="text" id="freight" name="freight" class="form-control" value="{{ $mipo->freight ?? '' }}" placeholder="Enter Freight">
                                                <br>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Engineering Input Status</label>
                                                <input type="text" id="engineering_input_status" name="engineering_input_status" class="form-control" value="{{ $mipo->engineering_input_status ?? '' }}" placeholder="Enter Engineering Input Status">
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade mt-2" id="team_details" role="tabpanel" aria-labelledby="team_details-tab">

                                        {{--  case incharge table--}}
                                        <div class="row my-3">
                                            <div class="col-12">
                                                <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Case Incharge {{$mipo->caseIncharge->nick_name ?? '-'}} Deatils</h5>

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
                                                                                   value="{{ basename(explode('?',$url)[0]) }}" readonly
                                                                                   style="color: black!important;">
                                                                            <a href="{{explode('||',$url)[0]}}"
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
                                                            <td width="35%"><strong>Case Incharge Approval Status</strong></td>
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
                                                <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Commercial {{$mipo->commercial->nick_name ?? ''}} Deatils</h5>
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
                                                    <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Purchase Team {{$mipo->purchaseTeam->nick_name ?? ''}} Deatils</h5>
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

                                     </div>
                                    <div class="tab-pane fade mt-2" id="case_incharge_details" role="tabpanel" aria-labelledby="case_incharge_details-tab">
                                        <div class="row my-3">
                                            <div class="col-md-4 col-lg-4 col-md-4 border-right text-center">
                                                <p class="font-weight-bold">Uploaded DCL Document</p>
                                                <div class="mt-2">
                                                    @if(count($dclDocumentsSrcArr))
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
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-md-4 border-right text-center">
                                                <p class="font-weight-bold">Uploaded MI Document</p>
                                                <div class="mt-2">
                                                    @if(count($miDocumentsSrcArr))
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
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-md-4 col-md-4 text-center">
                                                <p class="font-weight-bold">Uploaded Extra Document</p>
                                                <div class="mt-2">
                                                    @if(count($extraCiDocumentsSrcArr))
                                                        @foreach($extraCiDocumentsSrcArr as $key => $url)
                                                            @php
                                                                $uniqueKey = ++$key;
                                                            @endphp
                                                            <div class="d-flex mb-1 extra-document-div-{{$uniqueKey}}">
                                                                <input type="text"
                                                                       class="form-control input-sm document-border bg-white "
                                                                       value="{{ basename(explode('?',$url)[0]) }}" readonly
                                                                       style="color: black!important;">
                                                                <a href="{{explode('||',$url)[0]}}"
                                                                   class="btn btn-primary mx-2  px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <dd>Document Not uploaded</dd>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Case Incharge Approval Status</strong>
                                            @if($mipo->ci_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->ci_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Estimator Engineer Approval Status</strong>
                                            @if($mipo->engg_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->engg_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Commercial Approval Status</strong>
                                            @if($mipo->commercial_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->commercial_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                        @if($mipo->is_frp == 1)
                                            <div class="d-flex justify-content-between p-3">
                                                <strong>Purchase Team Approval Status</strong>
                                                @if($mipo->purchase_approval_status == "accepted")

                                                    <span class="text-success font-weight-bold">Approved</span>
                                                @elseif($mipo->purchase_approval_status == "rejected")
                                                    <span class="text-danger font-weight-bold"> Rejected</span>
                                                @else
                                                    <span class="text-warning font-weight-bold"> Pending</span>
                                                @endif
                                            </div>
                                        @endif
                                     </div>

                                    <div class="tab-pane fade mt-2" id="estimator_engineer_details" role="tabpanel" aria-labelledby="estimator_engineer_details-tab">
                                        <div class="row my-4">
                                            <div class="col-md-6 col-sm-12 text-center border-right">
                                                <p class="font-weight-bold">Uploaded PO cost sheet Document</p>
                                                <p class="po-cost-sheet-file-count"></p>
                                                <div class="mt-2">
                                                    @if(count($poCostSheetDocumentsSrcArr))
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
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 text-center">
                                                <p class="font-weight-bold">Uploaded Extra Document</p>
                                                <p class="estimator-extra-file-count"></p>
                                                <div class="mt-2">
                                                    @if(count($extraEstimatorDocumentsSrcArr))
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Is GR</strong>
                                            <strong>{{ $mipo->is_gr == 1 ? 'Yes' : 'No'}}</strong>
                                        </div>
                                        @if($mipo->is_gr == 1)
                                            <div class="d-flex justify-content-between p-3">
                                                <strong>Design Engineer</strong>
                                                <strong>{{ $mipo->designEngineer->nick_name ?? '-'}}</strong>
                                            </div>
                                        @endif
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Case Incharge Approval Status</strong>
                                            @if($mipo->ci_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->ci_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Estimator Engineer Approval Status</strong>
                                            @if($mipo->engg_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->engg_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Commercial Approval Status</strong>
                                            @if($mipo->commercial_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->commercial_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                        @if($mipo->is_frp == 1)
                                            <div class="d-flex justify-content-between p-3">
                                                <strong>Purchase Team Approval Status</strong>
                                                @if($mipo->purchase_approval_status == "accepted")

                                                    <span class="text-success font-weight-bold">Approved</span>
                                                @elseif($mipo->purchase_approval_status == "rejected")
                                                    <span class="text-danger font-weight-bold"> Rejected</span>
                                                @else
                                                    <span class="text-warning font-weight-bold"> Pending</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    @if($mipo->is_gr == 1)
                                        <div class="tab-pane fade mt-2" id="design_engineer_details" role="tabpanel" aria-labelledby="design_engineer_details-tab">
                                            <div class="row my-4">
                                                <div class="col-md-6  text-center">
                                                    <p class="font-weight-bold">Uploaded Design Drawing</p>
                                                    <p class="design-drawing-file-count"></p>
                                                    <div class="mt-2">
                                                        @if(count($designDrawingDocumentsSrcArr))
                                                            @foreach($designDrawingDocumentsSrcArr as $key => $url)
                                                                @php
                                                                    $uniqueKey = ++$key;
                                                                @endphp
                                                                <div class="d-flex mb-1  design-document-document-div-{{$uniqueKey}}">
                                                                    <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                    <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <p>Documents not uploaded</p>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="d-flex justify-content-between p-3">
                                                <strong>Case Incharge Approval Status</strong>
                                                @if($mipo->ci_approval_status == "accepted")

                                                    <span class="text-success font-weight-bold">Approved</span>
                                                @elseif($mipo->ci_approval_status == "rejected")
                                                    <span class="text-danger font-weight-bold"> Rejected</span>
                                                @else
                                                    <span class="text-warning font-weight-bold"> Pending</span>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-between p-3">
                                                <strong>Estimator Engineer Approval Status</strong>
                                                @if($mipo->engg_approval_status == "accepted")

                                                    <span class="text-success font-weight-bold">Approved</span>
                                                @elseif($mipo->engg_approval_status == "rejected")
                                                    <span class="text-danger font-weight-bold"> Rejected</span>
                                                @else
                                                    <span class="text-warning font-weight-bold"> Pending</span>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-between p-3">
                                                <strong>Commercial Approval Status</strong>
                                                @if($mipo->commercial_approval_status == "accepted")

                                                    <span class="text-success font-weight-bold">Approved</span>
                                                @elseif($mipo->commercial_approval_status == "rejected")
                                                    <span class="text-danger font-weight-bold"> Rejected</span>
                                                @else
                                                    <span class="text-warning font-weight-bold"> Pending</span>
                                                @endif
                                            </div>
                                            @if($mipo->is_frp == 1)
                                                <div class="d-flex justify-content-between p-3">
                                                    <strong>Purchase Team Approval Status</strong>
                                                    @if($mipo->purchase_approval_status == "accepted")

                                                        <span class="text-success font-weight-bold">Approved</span>
                                                    @elseif($mipo->purchase_approval_status == "rejected")
                                                        <span class="text-danger font-weight-bold"> Rejected</span>
                                                    @else
                                                        <span class="text-warning font-weight-bold"> Pending</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="tab-pane fade mt-2" id="commercial_details" role="tabpanel" aria-labelledby="commercial_details-tab">
                                        <div class="row my-4">
                                            <div class="col-md-4 col-lg-4 col-md-4 text-center border-right">
                                                <p class="font-weight-bold">Uploaded Templates</p>
                                                <p class="template-file-count"></p>
                                                <div class="mt-2">
                                                    @if(count($templateDocumentsSrcArr))
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
                                                        <p>Documents not uploaded</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-md-4 text-center border-right">
                                                <p class="font-weight-bold">Uploaded PO details</p>
                                                <p class="po-detail-file-count"></p>
                                                <div class="mt-2">
                                                    @if(count($poDetailDocumentsSrcArr))
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
                                                        <p>Documents not uploaded</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-md-4 text-center">
                                                <p class="font-weight-bold">Uploaded Extra Documents</p>
                                                <p class="extra-file-count"></p>
                                                <div class="mt-2">
                                                    @if(count($extraCommercialDocumentsSrcArr))
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
                                                        <p>Documents not uploaded</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Case Incharge Approval Status</strong>
                                            @if($mipo->ci_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->ci_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Estimator Engineer Approval Status</strong>
                                            @if($mipo->engg_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->engg_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Commercial Approval Status</strong>
                                            @if($mipo->commercial_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->commercial_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                        @if($mipo->is_frp == 1)
                                            <div class="d-flex justify-content-between p-3">
                                                <strong>Purchase Team Approval Status</strong>
                                                @if($mipo->purchase_approval_status == "accepted")

                                                    <span class="text-success font-weight-bold">Approved</span>
                                                @elseif($mipo->purchase_approval_status == "rejected")
                                                    <span class="text-danger font-weight-bold"> Rejected</span>
                                                @else
                                                    <span class="text-warning font-weight-bold"> Pending</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    @if($mipo->is_frp == 1)
                                    <div class="tab-pane fade mt-2" id="purchase_team_details" role="tabpanel" aria-labelledby="purchase_team_details-tab">
                                        <div class="row my-4">
                                            <div class="col-md-6 col-sm-12 text-center border-right">
                                                <p class="font-weight-bold">Uploaded Vendor PO Document</p>
                                                <p class="vendor-po-file-count"></p>
                                                <div class="mt-2">
                                                    @if(count($vendorPoDocumentsSrcArr))
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
                                                        <p>Documents not uploaded</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 text-center">
                                                <p class="font-weight-bold">Uploaded Extra Document</p>
                                                <p class="extra-file-count"></p>    
                                                <div class="mt-2">
                                                    @if(count($extraPurchaseDocumentsSrcArr))
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
                                                        <p>Documents not uploaded</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Case Incharge Approval Status</strong>
                                            @if($mipo->ci_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->ci_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Estimator Engineer Approval Status</strong>
                                            @if($mipo->engg_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->engg_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Commercial Approval Status</strong>
                                            @if($mipo->commercial_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->commercial_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                        @if($mipo->is_frp == 1)
                                            <div class="d-flex justify-content-between p-3">
                                                <strong>Purchase Team Approval Status</strong>
                                                @if($mipo->purchase_approval_status == "accepted")

                                                    <span class="text-success font-weight-bold">Approved</span>
                                                @elseif($mipo->purchase_approval_status == "rejected")
                                                    <span class="text-danger font-weight-bold"> Rejected</span>
                                                @else
                                                    <span class="text-warning font-weight-bold"> Pending</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-success" onclick="submitForm('addMipoAllocationForm','post')">Submit</button>
                                            <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
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
<script>
    $('.select2').select2();

    $(document).ready(function() {

        $('input[type="radio"][name="is_frp"]').change(function() {
            if($(this).val() == '1') {
                $('.purchase-team').removeClass('d-none');
                $('#purchase_id').addClass('required');
            } else {
                $('.purchase-team').addClass('d-none');
                $('#purchase_id').removeClass('required');
            }
        });

        $('.accordion-list > li > .answer').hide();
        $('.accordion-list > li').on('click', function() {
            if ($(this).hasClass("active")) {
                $(this).removeClass("active").find(".answer").slideUp();
            } else {
                $(".accordion-list > li.active .answer").slideUp();
                $(".accordion-list > li.active").removeClass("active");
                $(this).addClass("active").find(".answer").slideDown();
            }

            return false;
        });
    });
</script>
