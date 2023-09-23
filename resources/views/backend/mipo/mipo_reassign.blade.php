<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Reassign Mipo : #{{ $mipo->po_no .' / '. $mipo->region->region_name ?? '' }} /  {{ $mipo->revision_no ?? ''}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                        <div class="card-body">
                            <form id="saveMipoReverifyDetailsData" method="post" action="save_mipo_reassign_details">
                                <h4 class="form-section"><i class="ft-info"></i>Details</h4>
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Team Users<span class="text-danger">*</span></label>
                                        <select class="select2 required" id="user_id" name="user_id" style="width: 100% !important;">
                                            <option value="">Select</option>
                                            @foreach($userListArray as $key => $data)
                                                <option value="{{$key}}">{{$data}}</option>
                                            @endforeach
                                        </select><br/>
                                    </div>
                                    <input type="hidden" name="mipo_id" value="{{ $mipo->id }}">
                                </div><br/>
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-success mr-4" onclick="submitForm('saveMipoReverifyDetailsData','post')">Reassign</button>

                                            <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1 mr-4"> Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between px-3 mt-4">
                                            <strong>CaseIncharge Approval Status</strong>
                                            @if($mipo->ci_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->ci_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                            <div class="col-sm-6 col-md-6 px-3 mt-1">
                                                <p><span class="text-bold-500">CaseIncharge Remark : </span>{{ $mipo->ci_remarks ?? '' }}</p>
                                            </div>
                                        <div class="d-flex justify-content-between px-3 mt-4">
                                            <strong>Estimator Engineer Approval Status</strong>
                                            @if($mipo->engg_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->engg_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                            <div class="col-sm-6 col-md-6 px-3 mt-1">
                                                <p><span class="text-bold-600">Estimator Engineer Remark : </span>{{ $mipo->engg_remarks ?? '' }}</p>
                                            </div>
                                        <div class="d-flex justify-content-between px-3 mt-4">
                                            <strong>Commercial Approval Status</strong>
                                            @if($mipo->commercial_approval_status == "accepted")

                                                <span class="text-success font-weight-bold">Approved</span>
                                            @elseif($mipo->commercial_approval_status == "rejected")
                                                <span class="text-danger font-weight-bold"> Rejected</span>
                                            @else
                                                <span class="text-warning font-weight-bold"> Pending</span>
                                            @endif
                                        </div>
                                            <div class="col-sm-6 col-md-6 px-3 mt-1">
                                                <p><span class="text-bold-600">Commercial  Remark : </span>{{ $mipo->commercial_remarks ?? '' }}</p>
                                            </div>
                                        @if($mipo->is_frp == 1)
                                            <div class="d-flex justify-content-between px-3 mt-4">
                                                <strong>Purchase Team Approval Status</strong>
                                                @if($mipo->purchase_approval_status == "accepted")

                                                    <span class="text-success font-weight-bold">Approved</span>
                                                @elseif($mipo->purchase_approval_status == "rejected")
                                                    <span class="text-danger font-weight-bold"> Rejected</span>
                                                @else
                                                    <span class="text-warning font-weight-bold"> Pending</span>
                                                @endif
                                            </div>
                                                <div class="col-sm-6 col-md-6 px-3 mt-1">
                                                    <p><span class="text-bold-600">Purchase Team Remark : </span>{{ $mipo->purchase_remarks ?? '' }}</p>
                                                </div>
                                        @endif
                                        
                                        @if(checkIsAllRolesApprovedMipo($mipo))
                                          {{-- Mipo User final varifaction status --}}
                                            <div class="d-flex justify-content-between px-3 mt-4">
                                                <strong>Mipo Final Verification Status</strong>
                                                @if($mipo->mipo_verification_status == "accepted")

                                                    <span class="text-success font-weight-bold">Approved</span>
                                                @elseif($mipo->mipo_verification_status == "rejected")
                                                    <span class="text-danger font-weight-bold"> Rejected</span>
                                                @else
                                                    <span class="text-warning font-weight-bold"> Pending</span>
                                                @endif
                                            </div>
                                            <div class="col-sm-6 col-md-6 px-3 mt-1">
                                                <p><span class="text-bold-600">Mipo Team Remark : </span>{{ $mipo->mipo_remarks ?? '' }}</p>
                                            </div>
                                           {{--  Head Engg. status--}}
                                            <div class="d-flex justify-content-between px-3 mt-4">
                                                <strong>Head Engineer Approval  Status</strong>
                                                @if($mipo->head_engg_approval_status == "accepted")

                                                    <span class="text-success font-weight-bold">Approved</span>
                                                @elseif($mipo->head_engg_approval_status == "rejected")
                                                    <span class="text-danger font-weight-bold"> Rejected</span>
                                                @else
                                                    <span class="text-warning font-weight-bold"> Pending</span>
                                                @endif
                                            </div>
                                            <div class="col-sm-6 col-md-6 px-3 mt-1">
                                                <p><span class="text-bold-600">Head Engineer  Remark : </span>{{ $mipo->head_engg_remarks ?? '' }}</p>
                                            </div>
                                            {{--  Mipo order sheet  approval status--}}
                                            <div class="d-flex justify-content-between px-3 mt-4">
                                                <strong> Mipo Order Sheet  Approval Status </strong>
                                                @if($mipo->order_sheet_approval_status == "accepted")

                                                    <span class="text-success font-weight-bold">Approved</span>
                                                @elseif($mipo->order_sheet_approval_status == "rejected")
                                                    <span class="text-danger font-weight-bold"> Rejected</span>
                                                @else
                                                    <span class="text-warning font-weight-bold"> Pending</span>
                                                @endif
                                            </div>
                                            <div class="col-sm-6 col-md-6 px-3 mt-1">
                                                <p><span class="text-bold-600">Mipo Order Sheet  Remark : </span>{{ $mipo->order_sheet_remarks ?? '' }}</p>
                                            </div>
                                            {{--  Management team approval status--}}
                                            <div class="d-flex justify-content-between px-3 mt-4">
                                                <strong> Management Team Approval Status </strong>
                                                @if($mipo->management_approval_status == "accepted")

                                                    <span class="text-success font-weight-bold">Approved</span>
                                                @elseif($mipo->management_approval_status == "rejected")
                                                    <span class="text-danger font-weight-bold"> Rejected</span>
                                                @else
                                                    <span class="text-warning font-weight-bold"> Pending</span>
                                                @endif
                                            </div>
                                            <div class="col-sm-6 col-md-6 px-3 mt-1">
                                                <p><span class="text-bold-600">Management Team  Remark : </span>{{ $mipo->management_remarks ?? '' }}</p>
                                            </div>
                                        @endif
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
</script>
