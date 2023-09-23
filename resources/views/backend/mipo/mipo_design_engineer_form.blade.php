<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Upload Commercial Documents For Mipo: #{{ $mipo->po_no .' / '. $mipo->region->region_name ?? '' }} /  {{ $mipo->revision_no ?? ''}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                        <div class="card-body">
                            <form id="addDesignerMipoForm" method="post" action="save_designer_mipo_form" enctype="multipart/form-data">
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
                                        <a href="#mipo_template" role="tab" id="mipo_template-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="mipo_template" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Mipo Template</span>
                                        </a>
                                    </li>
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
                                            <a href="#design_engineer_details" role="tab" id="design_engineer_details-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="design_engineer_details" aria-selected="false">
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

                                </ul>
                                @csrf
                                <div class="tab-content">
                                    <div class="tab-pane fade mt-2" id="admin_details" role="tabpanel"
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
                                                <p class="font-weight-bold">Uploaded Mi Document</p>
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
                                                                   class="btn btn-primary mx-2  px-2" target="_blank"><i
                                                                            class="fa ft-eye"></i></a>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <dd>Document Not uploaded</dd>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between p-3">
                                            <strong>First Engineering Input Date</strong>
                                            <span class="font-weight-bold">{{ $mipo->first_engg_input_date ? \Carbon\Carbon::parse($mipo->first_engg_input_date)->format('d-m-Y') : '-' }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Last Engineering Input Date</strong>
                                            <span class="font-weight-bold">{{ $mipo->last_engg_input_date ? \Carbon\Carbon::parse($mipo->last_engg_input_date)->format('d-m-Y') : '-' }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>Number of Days for Approval</strong>
                                            <span class="font-weight-bold">{{ $mipo->no_of_days_for_approval ?? '-' }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between p-3">
                                            <strong>CaseIncharge Approval Status</strong>
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
                                        @endif                                       <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                    "btn btn-outline-danger  py-1 font-weight-bolder cancel-btn">Cancel</a>
                                                </div>
                                            </div>
                                        </div>

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
                                            <strong>CaseIncharge Approval Status</strong>
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
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                    "btn btn-outline-danger  py-1 font-weight-bolder cancel-btn">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($mipo->is_gr == 1)
                                        <div class="tab-pane fade mt-2 show active" id="design_engineer_details"
                                             role="tabpanel" aria-labelledby="design_engineer_details-tab">
                                            <div class="row my-4">
                                                <div class="col-md-6  text-center">
                                                    <p class="font-weight-bold">Upload Design Drawing</p>
                                                    <div class="shadow bg-white rounded d-inline-block">
                                                        <div class="input-file">
                                                            <label class="label-input-file">
                                                                Choose Files &nbsp;&nbsp;&nbsp;<i
                                                                        class="ft-upload font-medium-1"></i>
                                                                <input type="file" multiple
                                                                       name="designerDrawingDocument[]"
                                                                       class="design-drawing-document"
                                                                       id="designerDrawingDocument">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p id="files-area">
	<span id="designFilesList">
		<span id="design-files-names"></span>
	</span>
                                                    </p>
                                                    <div class="mt-2">
                                                        @if(count($designDrawingDocumentsSrcArr))
                                                            @foreach($designDrawingDocumentsSrcArr as $key => $url)
                                                                @php
                                                                    $uniqueKey = ++$key;
                                                                @endphp
                                                                <div class="d-flex mb-1  design-document-document-div-{{$uniqueKey}}">
                                                                    <input type="text" class="form-control input-sm bg-white document-border" value="{{ basename(explode('?',$url)[0]) }}" readonly style="color: black !important;">
                                                                    <a href="{{explode('||',$url)[0]}}" class="btn btn-primary mx-2 px-2" target="_blank"><i class="fa ft-eye"></i></a>
                                                                    @if($mipo->drawing_approval_status == "pending" || $mipo->drawing_approval_status == "rejected")
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-danger delete-design-drawing-document  px-2" data-url="{{$url}}" data-id="{{ $uniqueKey }}"><i class="fa ft-trash"></i></a>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12 my-2">
                                                    <label class="d-block">Is IG-Breakup<span style="color:#ff0000">*</span></label>
                                                    <div class="d-inline-block mr-2">
                                                        <div class="radio radio-success">
                                                            <input type="radio" name="ig_breakup" id="color-radio-3" value="1" {{ $mipo->ig_breakup == 1 ? 'selected' : ''}}>
                                                            <label for="color-radio-3">Yes</label>
                                                        </div>
                                                    </div>
                                                    <div class="d-inline-block mr-2">
                                                        <div class="radio radio-warning">
                                                            <input type="radio" name="ig_breakup" id="color-radio-4" value="0" {{ $mipo->ig_breakup == 0 ? 'selected' : '' }}>
                                                            <label for="color-radio-4">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 my-2">
                                                    <label class="d-block">Currently availability of inputs<span style="color:#ff0000">*</span></label>
                                                    <textarea type="text" class="form-control" name="input_availability">{{ $mipo->input_availability ?? '' }}</textarea>
                                                </div>
                                            </div>

                                            <div class="row mb-3 mt-5">
                                                <div class="col-sm-12">
                                                    <div class="pull-right">
                                                        @if($mipo->drawing_approval_status == "pending" || $mipo->drawing_approval_status == "rejected")
                                                        <button type="button" class="btn btn-success mr-4 font-weight-bolder accept-btn" onclick="submitForm('addDesignerMipoForm','post')">Upload Docs</button>
                                                        <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                        "btn btn-outline-danger  py-1 font-weight-bolder cancel-btn">Cancel</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!empty($mipo->drawing_remarks))
                                                <div class="d-flex justify-content-between p-3">
                                                    <strong>Estimator Rejected Remarks</strong>
                                                    <span class="ml-3">{{$mipo->drawing_remarks}}</span>
                                                </div>
                                            @endif
                                            <div class="d-flex justify-content-between p-3">
                                                <strong>CaseIncharge Approval Status</strong>
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
                                            <strong>CaseIncharge Approval Status</strong>
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
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                    "btn btn-outline-danger  py-1 font-weight-bolder cancel-btn">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
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
                                                <strong>CaseIncharge Approval Status</strong>
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

                                            <div class="row mt-3">
                                                <div class="col-sm-12">
                                                    <div class="pull-right">
                                                        <a href="{{URL::previous()}}" style="background: none !important;color: #F55252 !important" class=
                                                        "btn btn-outline-danger  py-1 font-weight-bolder cancel-btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endif

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

 
    $('.delete-design-drawing-document').click(function(){
        let data = {
            url : $(this).attr('data-url'),
            path : 'design-engineer'
        }
        let uniqueId = $(this).attr('data-id');
        deleteDocuments (data,uniqueId,'.design-document-document-div-')
    });

    function deleteDocuments (data,uniqueId,removeClassName) {
        bootbox.confirm({
            message: "Are you sure you want to delete this Document?",
            buttons: {
                confirm: {
                    label: 'Yes, I confirm',
                    className: 'btn-primary'
                },
                cancel: {
                    label: 'Cancel',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {

                    $.ajax({
                        type:'POST',
                        url: "{{route('delete-mipo-document')}}",
                        data: data,
                        headers:{
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success:function(result){
                            if (result) {
                                $(removeClassName + uniqueId).remove();
                            }
                        }
                    });
                }
            }
        });
    }

    const designData = new DataTransfer();

    function handleDesignAttachmentChange () {
        const attachmentInput = document.getElementById('designerDrawingDocument');

        attachmentInput.addEventListener('change', function (e) {
            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const fileBloc = $('<span/>', { class: 'file-block' });
                const fileName = $('<span/>', { class: 'name', text: file.name });

                fileBloc.append('<span class="file-delete design-file-delete"><span>+</span></span>').append(fileName);

                $('#designFilesList > #design-files-names').append(fileBloc);
                designData.items.add(file);
            }

            this.files = designData.files;

            $('span.design-file-delete').click(function () {
                const name = $(this).next('span.name').text();
                $(this).parent().remove();

                for (let i = 0; i < designData.items.length; i++) {
                    if (name === designData.items[i].getAsFile().name) {
                        designData.items.remove(i);
                        break;
                    }
                }

                document.getElementById('designerDrawingDocument').files = designData.files;
            });
        });
    }

    handleDesignAttachmentChange();

</script>