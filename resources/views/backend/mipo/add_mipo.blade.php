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
                                    <h5 class="pt-2">Edit Mipo: #{{ $mipo->po_no .' / '. $mipo->region->region_name ?? '' }} /  {{ $mipo->revision_no ?? ''}}</h5>
                                    @else
                                        <h5 class="pt-2">Add Mipo</h5>  
                                    @endif
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{ route('mipo.index') }}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                               <li class="nav-item">
                                   <a href="#admin_details" role="tab" id="admin_details-tab" class="nav-link d-flex align-items-center active" data-toggle="tab" aria-controls="admin_details" aria-selected="true">
                                       <i class="ft-info mr-1"></i>
                                       <span class="">Mipo Details</span>   
                                   </a>
                               </li>
                                {{-- Mipo User Mipo Template Tab Link--}}
                                <li class="nav-item">
                                    <a href="#mipo_template" role="tab" id="mipo_template-tab" class="nav-link d-flex align-items-center " data-toggle="tab" aria-controls="mipo_template" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <span class="">Mipo Template</span>
                                    </a>
                                </li>
                                @if(isset($mipo) && $mipo->ci_approval_status == "accepted" && $mipo->engg_approval_status == "accepted" && $mipo->commercial_approval_status == "accepted" && $mipo->purchase_approval_status == "accepted")   
                                    {{-- Team Deatils Tab Link--}}
                                    <li class="nav-item">   
                                        <a href="#team_details" role="tab" id="team_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="team_details" aria-selected="false">
                                            <i class="ft-info mr-1"></i>
                                            <span class="">Team Details</span>
                                        </a>
                                    </li>
                                @else
                               <li class="nav-item">
                                   <a href="#case_incharge_details" role="tab" id="case_incharge_details-tab" class="nav-link d-flex align-items-center " data-toggle="tab" aria-controls="case_incharge_details" aria-selected="true">
                                       <i class="ft-info mr-1"></i>
                                       <span class="">Case Incharge Details</span>
                                   </a>
                               </li>
{{--                                 Estimator Engineer Details Tab Link--}}
                                <li class="nav-item">
                                    <a href="#estimator_engineer_details" role="tab" id="estimator_engineer_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="estimator_engineer_details" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <span class="">Estimator Details</span>
                                    </a>
                                </li>
                                {{-- Design Engineer Details Tab Link--}}
                                @if(isset($mipo) && $mipo->is_gr == 1)
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
                                @if(isset($mipo) && $mipo->is_frp == 1)
                                <li class="nav-item">
                                    <a href="#purchase_team_details" role="tab" id="purchase_team_details-tab" class="nav-link d-flex align-items-center" data-toggle="tab" aria-controls="purchase_team_details" aria-selected="false">
                                        <i class="ft-info mr-1"></i>
                                        <span class="">Purchase Details</span>
                                    </a>
                                </li>
                                @endif
                                @endif
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade mt-2 show active" id="admin_details" role="tabpanel" aria-labelledby="admin_details-tab">
                                    <form id="addMipoDetailsForm" method="post" action="save-mipo-details">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Po Type<span style="color:#ff0000">*</span></label>
                                                <select class="select2 required" id="po_type" name="po_type"
                                                        style="width: 100% !important;" {{ isset($mipo) ? 'readonly' : '' }}>
                                                    @if(isset($mipo))
                                                        <option value="new" {{ $mipo->po_type == 'new' ? 'selected' : '' }}>  NEW </option>
                                                        <option value="cn" {{ $mipo->po_type == 'cn' ? 'selected' : '' }}> CN </option>
                                                    @else
                                                        <option value="new" selected>NEW</option>
                                                        <option value="cn">CN</option>
                                                    @endif
                                                </select><br/><br/>
                                            </div>
                                            <div class="col-sm-6 ">
                                                <div class="mipo-selection-div {{ (isset($mipo) && $mipo->po_type == 'cn') ? '' : 'd-none'  }}">
                                                    <label>Mipo<span style="color:#ff0000">*</span></label>
                                                    <fieldset class="form-group">
                                                        <div class="input-group">
                                                            <select class="select2" id="revision_mipo_id" style="width: 100% !important;" name="revision_mipo_id">
                                                                <option value="">Mipo</option>
                                                                @foreach($mipos as $mipoData)
                                                                    <option value="{{$mipoData->id}}" {{ (isset($mipo) && $mipo->po_type == 'cn'  && $mipo->po_no == $mipoData->po_no ) ? 'selected'  : ''  }}>
                                                                        {{ $mipoData->po_no .' / '.$mipoData->region->region_code .' / '. $mipoData->revision_no }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Client<span class="text-danger"></span></label>
                                                <input class="form-control " type="text" id="client_name" name="client_name" value="{{ $mipo->client_name ?? '' }}" autocomplete="off"> <br>
                                                <div id="clientList" class="col-sm-10"></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>REGION<span style="color:#ff0000"></span></label>
                                                <select class="select2" id="region_id" name="region_id" style="width: 100% !important;" >
                                                    <option value="">Select</option>
                                                    @foreach($regions as $region)
                                                        <option value="{{$region->id}}" {{ (isset($mipo) && $mipo->region_id == $region->id ) ? 'selected' : '' }}>{{ $region->region_name }}</option>
                                                    @endforeach
                                                </select><br/><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Enquiry<span style="color:#ff0000">*</span></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <select class="select2 required" id="enquiry_id" style="width: {{isset($mipo) ? '100%' :  '91%'}} !important;" name="enquiry_id">
                                                            <option value="">Enquiry</option>
                                                            @foreach($enquires as $enquire)
                                                                <option value="{{$enquire->id}}" {{ (isset($mipo) && $mipo->enquiry_id == $enquire->id) ? 'selected' : '' }}>{{ $enquire->enq_no.' / '. $enquire->region_code ." / ". $enquire->revision_no }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if(!isset($mipo))
                                                            <!-- Button to trigger the modal -->
                                                            <div class="input-group-append">
                                                                <label class="input-group-text" for="enquiry_id">
                                                                    <a href="add_mipo_enquiry_form/" class="modal_src_data" data-size="extra-large" data-title="Add Enquiry Details" title="Add Enquiry">
                                                                        <i class="fa fa-plus text-black-50"></i>
                                                                    </a>&nbsp;
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </fieldset>
                                                <input type="hidden" name="mipo_id" value="{{ $mipo->id ?? '' }}">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Enquiry No<span class="text-danger"></span></label>
                                                <input class="form-control" type="text" id="enquiry_no" name="enquiry_no" value="{{ $mipo->enquiry_no ?? '' }}" readonly>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Po Date <span style="color:#ff0000"></span></label>
                                                    <div class="input-group">
                                                        <input type='date' class="form-control date" placeholder="dd/mm/yyyy"   name="po_recv_date" id="po_recv_date" value="{{ (isset($mipo) && !empty($mipo->po_recv_date)) ? date('Y-m-d', strtotime($mipo->po_recv_date)) : date('Y-m-d') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Ho Received Date <span style="color:#ff0000"></span></label>
                                                    <div class="input-group">
                                                        <input type='date' class="form-control date" placeholder="dd/mm/yyyy"  name="ho_recv_date" id="ho_recv_date" value="{{ (isset($mipo) && !empty($mipo->ho_recv_date)) ? date('Y-m-d', strtotime($mipo->ho_recv_date)) :  date('Y-m-d') }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Project<span class="text-danger"></span></label>
                                                <input class="form-control " type="text" id="project_name" name="project_name"
                                                       value="{{ $mipo->project_name ?? '' }} " readonly><br>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>CASE INCHARGE<span style="color:#ff0000"></span></label>
                                                <select class="select2 " id="case_incharge_id" name="case_incharge_id"
                                                        style="width: 100% !important;" readonly>
                                                    <option value=""></option>
                                                    @foreach($caseIncharges as $caseIncharg)
                                                        <option value="{{$caseIncharg->id}}" {{ (isset($mipo) && $mipo->case_incharge_id == $caseIncharg->id ) ? 'selected' : '' }}>{{ $caseIncharg->nick_name }}</option>
                                                    @endforeach
                                                </select><br/><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Engineer<span style="color:#ff0000"></span></label>
                                                <select class="select2" id="engineer_id" name="engineer_id" style="width: 100% !important;" readonly>
                                                    <option value=""></option>
                                                    @foreach($engineers as $engineer)
                                                        <option value="{{$engineer->id}}" {{ (isset($mipo) && $mipo->engineer_id == $engineer->id ) ? 'selected' : '' }}>{{ $engineer->nick_name }}</option>
                                                    @endforeach
                                                </select><br/><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Product<span style="color:#ff0000">*</span></label>
                                                <select class="select2 required" id="product_id" name="product_id"  style="width: 100% !important;" >
                                                    <option value="">Product</option>
                                                    @foreach($products as $product)
                                                        <option value="{{$product->id}}" {{ (isset($mipo) && $mipo->product_id == $product->id ) ? 'selected' : '' }}>{{ $product->product_code }}</option>
                                                    @endforeach
                                                </select><br/><br/>
                                            </div>
                                            <div class="col-sm-6" hidden>
                                                <label>Category</label>
                                                <select class="select2" id="category_id" name="category_id" style="width: 100% !important;">
                                                    <option value="">Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}" {{ (isset($mipo) && $mipo->category_id == $category->id ) ? 'selected' : '' }}>{{ $category->category_code }}</option>
                                                    @endforeach
                                                </select><br/><br/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Reference</label>
                                                <textarea class="form-control" id="reference"
                                                          name="reference">{{ $mipo->reference ?? '' }}</textarea><br/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-right">
                                                    <button type="button" class="btn btn-success"
                                                            onclick="submitForm('addMipoDetailsForm','post')">Submit
                                                    </button>
                                                    <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade mt-2" id="mipo_template" role="tabpanel"   aria-labelledby="mipo_template-tab">
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
                                            @if(isset($mipo))
                                            <dd>{{ $mipo->is_frp == 1 ? 'Yes' : 'No'}}</dd>
                                            @else
                                                <dd>-</dd>
                                            @endif
                                        </div>
                                        @if(isset($mipo) && $mipo->is_frp == 1)
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
                                            <dd>{{ !empty($mipo->delivery_date) ? date('d-m-Y', strtotime($mipo->delivery_date)) : '-'; }}</dd>
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
                                                <button type="button" class="btn btn-success"
                                                        onclick="submitForm('addMipoDetailsForm','post')">Submit
                                                </button>
                                                <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(isset($mipo))
                                <div class="tab-pane fade mt-2" id="team_details" role="tabpanel" aria-labelledby="team_details-tab">

                                    {{--  case incharge table--}}
                                    <div class="row my-3">
                                        <div class="col-12">
                                            <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> CaseIncharge {{$mipo->caseIncharge->nick_name ?? '-'}} Deatils</h5>

                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <td><strong>DCL Document</strong></td>
                                                        <td>@if(isset($dclDocumentsSrcArr) && count($dclDocumentsSrcArr))
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
                                                        <td>@if(isset($miDocumentsSrcArr) && count($miDocumentsSrcArr))
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
                                                        <td>@if(isset($extraCiDocumentsSrcArr) && count($extraCiDocumentsSrcArr))
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
                                                        <td width="35%"><strong>CaseIncharge Remark</strong></td>
                                                        <td>{{ $mipo->ci_remarks ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="35%"><strong>CaseIncharge Approval Status</strong></td>
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
                                                        <td width="35%"><strong>CaseIncharge Document Upload Date</strong></td>
                                                        <td>{{ $mipo->ci_document_upload_dt ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{--  Estimator table--}}
                                    <div class="row my-3">
                                        <div class="col-12">
                                            <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Estimator Engineer {{$mipo->estimateEngineer->nick_name ?? ''}} Deatils</h5>
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
                                                <h5 class="mb-2 text-bold-500"><i class="ft-info mr-2"></i> Design Engineer {{$mipo->designEngineer->nick_name ?? ''}} Deatils</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered">
                                                        <tr>
                                                            <td width="35%"><strong>Uploaded Design Drawing Document</strong></td>
                                                            <td>@if(isset($designDrawingDocumentsSrcArr) && count($designDrawingDocumentsSrcArr))
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
                                                        <td>@if(isset($templateDocumentsSrcArr) && count($templateDocumentsSrcArr))
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
                                                        <td>@if(isset($poDetailDocumentsSrcArr) && count($poDetailDocumentsSrcArr))
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
                                                        <td>@if(isset($extraCommercialDocumentsSrcArr) && count($extraCommercialDocumentsSrcArr))
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
                                                            <td>@if(isset($vendorPoDocumentsSrcArr) && count($vendorPoDocumentsSrcArr))
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
                                                            <td>@if(isset($extraPurchaseDocumentsSrcArr) && count($extraPurchaseDocumentsSrcArr))
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
                                                <button type="button" class="btn btn-success"
                                                        onclick="submitForm('addMipoDetailsForm','post')">Submit
                                                </button>
                                                <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @endif
                                <div class="tab-pane fade mt-2" id="case_incharge_details" role="tabpanel" aria-labelledby="case_incharge_details-tab">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-4 col-md-4 border-right text-center">
                                                <p class="font-weight-bold"> DCL Document</p>
                                                <div class="mt-2">
                                                    @if(isset($dclDocumentsSrcArr) && count($dclDocumentsSrcArr))
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
                                                <p class="font-weight-bold"> MI Document</p>
                                                <div class="mt-2">
                                                    @if(isset($miDocumentsSrcArr)  && count($miDocumentsSrcArr))
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
                                                <p class="font-weight-bold"> Extra Document</p>
                                                <div class="mt-2">
                                                    @if(isset($extraCiDocumentsSrcArr) && count($extraCiDocumentsSrcArr))
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
                                    @if(isset($mipo))
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
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success"
                                                        onclick="submitForm('addMipoDetailsForm','post')">Submit
                                                </button>
                                                <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
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
                                                @if(isset($poCostSheetDocumentsSrcArr) && count($poCostSheetDocumentsSrcArr))   
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
                                                @if(isset($extraEstimatorDocumentsSrcArr) && count($extraEstimatorDocumentsSrcArr))
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
                                    @if(isset($mipo))
                                    <div class="d-flex justify-content-between p-3">
                                        <strong>Is GR</strong>
                                        <strong>{{ $mipo->is_gr == 1 ? 'Yes' : 'No'}}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between p-3">
                                        <strong>Design Engineer</strong>
                                        <strong>{{ $mipo->designEngineer->nick_name ?? '-'}}</strong>
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
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success"
                                                        onclick="submitForm('addMipoDetailsForm','post')">Submit
                                                </button>
                                                <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if(isset($mipo) && $mipo->is_gr == 1)
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
                                                    <button type="button" class="btn btn-success"
                                                            onclick="submitForm('addMipoDetailsForm','post')">Submit
                                                    </button>
                                                    <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="tab-pane fade mt-2" id="commercial_details" role="tabpanel"
                                     aria-labelledby="commercial_details-tab">
                                    <div class="row my-4">
                                        <div class="col-md-4 col-lg-4 col-md-4 text-center border-right">
                                            <p class="font-weight-bold">Uploaded Templates</p>
                                            <p class="template-file-count"></p>
                                            <div class="mt-2">
                                                @if(isset($templateDocumentsSrcArr) && count($templateDocumentsSrcArr))
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
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-md-4 text-center border-right">
                                            <p class="font-weight-bold">Uploaded PO details</p>
                                            <p class="po-detail-file-count"></p>
                                            <div class="mt-2">
                                                @if(isset($poDetailDocumentsSrcArr) && count($poDetailDocumentsSrcArr))
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
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-md-4 text-center">
                                            <p class="font-weight-bold">Uploaded Extra Documents</p>
                                            <p class="extra-file-count"></p>
                                            <div class="mt-2">
                                                @if(isset($extraCommercialDocumentsSrcArr) && count($extraCommercialDocumentsSrcArr))
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
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    @if(isset($mipo))
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
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success"
                                                        onclick="submitForm('addMipoDetailsForm','post')">Submit
                                                </button>
                                                <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(isset($mipo) && $mipo->is_frp == 1)
                                <div class="tab-pane fade mt-2" id="purchase_team_details" role="tabpanel"
                                     aria-labelledby="purchase_team_details-tab">
                                    <div class="row my-4">
                                        <div class="col-md-6 col-sm-12 text-center border-right">
                                            <p class="font-weight-bold">Uploaded Vendor PO Document</p>
                                            <p class="vendor-po-file-count"></p>
                                            <div class="mt-2">
                                                @if(isset($vendorPoDocumentsSrcArr) && count($vendorPoDocumentsSrcArr))
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
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 text-center">
                                            <p class="font-weight-bold">Uploaded Extra Document</p>
                                            <p class="extra-file-count"></p>
                                            <div class="mt-2">
                                                @if(isset($extraPurchaseDocumentsSrcArr) && count($extraPurchaseDocumentsSrcArr))
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
                                            </div>
                                        </div>
                                    </div>
                                    @if(isset($mipo))
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
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-success"
                                                        onclick="submitForm('addMipoDetailsForm','post')">Submit
                                                </button>
                                                <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    window.is_enquiry = 'false';
    // $('.select2').select2();
    $('.select2').select2();

    $(document).on('change','#region_id',function () {
        let region_id = $(this).val();
        let enquiry_id = $('#enquiry_id').val();
        let client_name = $('#client_name').val();

        if (is_enquiry == 'true') {
            window.is_enquiry = 'false';
            return false;
        }

        $.ajax({
            url:"{{route('mipo.get-client_name') }}",
            method:'post',
            data:{region_id:region_id,client_name:client_name},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            success:function(data) {
                $('#enquiry_no').val('');
                $('#project_name').val('');
                $('#case_incharge_id').val('').trigger('change');
                $('#engineer_id').val('').trigger('change');
                $('#product_id').val('').trigger('change');
                $('#category_id').val('').trigger('change');
                $('#enquiry_id').empty();
                $('#enquiry_id').append($('<option>Enquiry</option>'));
                $.each(data.enquires, function(key, value) {
                    var enq = value.enq_no + " / " + value.region_code + " / " + value.revision_no
                    $('#enquiry_id').append($('<option></option>').val(value.id).text(enq));
                });
            }
        });
    });

    $(document).on('change', '#enquiry_id', function () {
        let enquiryId = $(this).val();
        if (enquiryId) {
            $.ajax({
                type: 'POST',
                url: "{{ route('mipo-form.get-enquiry-data') }}",
                data: { enquiryId: enquiryId },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function (data) {
                    window.is_enquiry = 'true';
                    if (data.result) {
                        $('#enquiry_no').val(data.data.enq_no);
                        $('#client_name').val(data.data.client_name);
                        $('#project_name').val(data.data.project_name);
                        $('#case_incharge_id').val(data.data.case_incharge_id).trigger('change');
                        $('#engineer_id').val(data.data.engineer_id).trigger('change');
                        $('#region_id').val(data.data.region_id).trigger('change');
                        $('#product_id').val(data.data.product_id).trigger('change');
                        $('#category_id').val(data.data.category_id).trigger('change');
                    } else {
                        $('#enquiry_no').val('');
                        $('#client_name').val('');
                        $('#project_name').val('');
                        $('#case_incharge_id').val('').trigger('change');
                        $('#engineer_id').val('').trigger('change');
                        $('#region_id').val('').trigger('change');
                        $('#product_id').val('').trigger('change');
                        $('#category_id').val('').trigger('change');
                    }
                },
            });
        } else {
            $('#enquiry_no').val('');
            $('#client_name').val('');
            $('#project_name').val('');
            $('#case_incharge_id').val('').trigger('change');
            $('#engineer_id').val('').trigger('change');
            $('#region_id').val('').trigger('change');
            $('#product_id').val('').trigger('change');
            $('#category_id').val('').trigger('change');
        }
    });
    $(document).on('change', '#revision_mipo_id', function () {
        let mipoId = $(this).val();
        let currentDate = moment().format('YYYY-MM-DD');
        
        if (is_enquiry == 'true') {
            window.is_enquiry = 'false';
            return false;
        }

        if (mipoId) {
            $.ajax({
                type: 'POST',
                url: "{{ route('mipo-form.get-mipo-data') }}",
                data: { mipoId: mipoId },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function (data) {
                    window.is_enquiry = 'true';
                    if (data.result) {
                        $("#enquiry_id").val(data.data.enquiry_id).trigger('change.select2');
                        $('#enquiry_no').val(data.data.enquiry_no);
                        $('#po_recv_date').val(data.data.po_recv_date);
                        $('#ho_recv_date').val(data.data.ho_recv_date);
                        $('#client_name').val(data.data.client_name);
                        $('#project_name').val(data.data.project_name);
                        $('#case_incharge_id').val(data.data.case_incharge_id).trigger('change');
                        $('#engineer_id').val(data.data.engineer_id).trigger('change');
                        $('#region_id').val(data.data.region_id).trigger('change');
                        $('#product_id').val(data.data.product_id).trigger('change');
                        $('#category_id').val(data.data.category_id).trigger('change');
                    } else {
                        $("#enquiry_id").val('').trigger('change.select2');
                        $('#enquiry_no').val('');
                        $('#client_name').val('');
                        $('#project_name').val('');
                        $('#case_incharge_id').val('').trigger('change');
                        $('#engineer_id').val('').trigger('change');
                        $('#region_id').val('').trigger('change');
                        $('#product_id').val('').trigger('change');
                        $('#category_id').val('').trigger('change');
                        $('#po_recv_date , #ho_recv_date').val(currentDate);
                    }
                },
            });
        } else {
            $("#enquiry_id").val('').trigger('change.select2');
            $('#enquiry_no').val('');
            $('#client_name').val('');
            $('#project_name').val('');
            $('#case_incharge_id').val('').trigger('change');
            $('#engineer_id').val('').trigger('change');
            $('#region_id').val('').trigger('change');
            $('#product_id').val('').trigger('change');
            $('#category_id').val('').trigger('change');
            $('#po_recv_date , #ho_recv_date').val(currentDate);
        }
    });
    $(document).on('change', '#po_type', function () {
        let poTypeValue = $(this).val();
        $('#revision_mipo_id').val('').trigger('change');
        if (poTypeValue == 'new') {
            $('.mipo-selection-div').addClass('d-none');
            $('#revision_mipo_id').removeClass('required');
            $('#enquiry_id,#enquiry_no,#client_name,#project_name,#case_incharge_id ,#engineer_id, #region_id, #product_id').attr('readonly', false);
        } else {
            $('.mipo-selection-div').removeClass('d-none');
            $('#revision_mipo_id').addClass('required');
            $('#enquiry_id,#enquiry_no,#client_name,#project_name,#case_incharge_id ,#engineer_id, #region_id, #product_id').attr('readonly', true);
        }
    });
    $(document).on('click', '.add-enquiry-btn', function () {
        $('.enquiry-menu').addClass('active');
        $('.mipo-menu').removeClass('active');
    });

    $(document).ready(function(){
        $('#client_name').keyup(function(){
        var query = $(this).val();
        var client_for_mipo =true;

        if(query != '')
        {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{route('enquiry_form.autoData') }}",
                method:'post',
                data:{query:query,client_for_mipo:client_for_mipo,_token:_token},
                success:function(data) {
                    if (data) {
                        $("#clientList").show();
                        $('#clientList').html(data);
                        document.getElementsByClassName("autoData")[0].addEventListener("click",(e)=>{
                            let text=e.target.innerText

                            if(text){
                                document.getElementById("client_name").value=text;
                                console.log(text);
                                $.ajax({
                                    url:"{{route('mipo.get-client_name') }}",
                                    method:'post',
                                    data:{client_name:text,_token:_token},
                                    success:function(data) {
                                        // console.log(data);
                                        // $('#region_id').val(data.enquires[0].region_code).trigger('change');
                                        $('#enquiry_no').val('');
                                        // $('#client_name').val('');
                                        $('#project_name').val('');
                                        $('#case_incharge_id').val('').trigger('change');
                                        $('#engineer_id').val('').trigger('change');
                                        $('#product_id').val('').trigger('change');
                                        $('#category_id').val('').trigger('change');
                                        $('#enquiry_id').empty();
                                        $('#enquiry_id').append($('<option>Enquiry</option>'));
                                        $.each(data.enquires, function(key, value) {
                                            var enq = value.enq_no + " / " + value.region_code + " / " + value.revision_no
                                            $('#enquiry_id').append($('<option></option>').val(value.id).text(enq));
                                        });
                                    }
                                });
                            }
                            $("#clientList").hide();
                        })
                        $("#client_name").click(function(){
                            $("#clientList").show();
                        });
                    } else {
                        $("#clientList").hide();
                    }
                }
            });
        } else {
            $("#clientList").hide();
        }
    });
        
    $("#client_name").on("blur", function() {
        $("body").click(function(e) {
            if(e.target.id !== 'clientList'){
                $("#clientList").hide();
            }
        });
    });

});
</script>
