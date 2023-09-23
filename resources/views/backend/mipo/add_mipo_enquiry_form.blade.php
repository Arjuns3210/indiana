<!-- Modal -->

<div class="container">
    <form id="mipo_add_enquiry_form" method="POST" action="save_mipo_enquiry">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <label>Client<span class="text-danger">*</span></label>
                <input class="form-control required" type="text" id="client_name" name="client_name" value="{{ $enq_details->client_name ?? '';}}" ><br/>
                <div id="clientList" class="col-sm-10"></div>
            </div>
            <div class="col-sm-6">
                <label>Project<span class="text-danger">*</span></label>
                <input class="form-control required" type="text" id="project_name" name="project_name" value="{{ $enq_details->project_name ?? '';}}"><br/>
            </div>
            <div class="col-sm-6">
                <label>Product<span style="color:#ff0000">*</span></label>
                <select class="select2 required" id="product_id1" name="product_id" style="width: 100% !important;">
                    <option value="">Select</option>
                    @if(isset($products))
                    @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->product_name}}</option>
                    @endforeach
                    @endif
                </select><br/><br/>
            </div>
            <div class="col-sm-6">
                <label>Case Incharge<span style="color:#ff0000">*</span></label>
                <select class="select2 required" id="case_incharge_id1" name="case_incharge_id" style="width: 100% !important;">
                    <option value="">Select</option>
                    @if(isset($case_incharge))
                    @foreach($case_incharge as $ci)
                        <option value="{{$ci->id}}">{{$ci->nick_name}}</option>
                    @endforeach
                    @endif
                </select><br/><br/>
            </div>
            <div class="col-sm-6">
                <label>Engineer<span style="color:#ff0000">*</span></label>
                <select class="select2 required" id="engineer_id1" name="engineer_id" style="width: 100% !important;">
                    <option value="">Select</option>
                    @foreach($engineers as $engineer)
                        <option value="{{$engineer->id}}" @isset($enq_details) {{ ($engineer->id == $enq_details->engineer_id) ? 'selected':'';}} @endisset>{{$engineer->nick_name}}</option>
                    @endforeach
                </select><br/><br/>
            </div>
            <div class="col-sm-6">
                <label>Sales Remark</label>
                <textarea class="form-control" id="sales_remark" name="sales_remark" readonly>Added for MIPO purpose as order received</textarea><br/>
            </div>
        </div>
    </form>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="off">Close</button>
        <button type="button" onclick="submitMipoEnquiry('mipo_add_enquiry_form','post')" class="btn btn-success" id="submitBtn">Submit</button>
    </div>
</div>
<script>
    $('.select2').select2();
</script>
