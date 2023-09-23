<div class="row payment_term_div">
    <div class="col-3">
        <select class="select2 required"  name="payment_terms[]" style="width: 100%">
            @foreach($payment_terms as $payment_term)
                <option value="{{$payment_term->id}}" class="payment_days" data-payment-days="{{$payment_term->no_of_days}}">{{ $payment_term->payment_terms}}</option>
            @endforeach
        </select><br/>
    </div>
    <div class="col-3">
        <input class="form-control required payment_value" type="number" name="payment_percentage[]" oninput="validatePercentage(this)"><br/>
    </div>
    <div class="col-3">
        <div class="py-1">
            <a href="javascript:void(0)" class="btn btn-danger btn-sm remove_payment_term_item"><i class="fa fa-trash"></i></a>
        </div>
    </div>
</div>
