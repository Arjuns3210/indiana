<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class PurchaseTeamDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->purchase_approval_status == "rejected"){
            return [
                'purchase_remarks' => 'required',
            ];
        }

        if (! count(file_view('purchase-team', 'vendor-po_'.$this->input('mipo_id'),
                null)) && empty($this->purchase_remarks)) {
            return [
                'purchaseVendorPoDocument'   => 'required',
                'purchaseVendorPoDocument.*' => 'file',
            ];
        }

        if (is_null($this->purchase_approval_status) || empty($this->purchase_approval_status)) {
            return [
                'purchaseVendorPoDocument|purchaseExtraDocument' => 'required_without_all:purchaseVendorPoDocument,purchaseExtraDocument',
            ];
        }

        return [];
    }

    function messages()
    {
        return [
            'purchaseVendorPoDocument.required' => 'Please upload Purchase Vendor PO detail document.',
            'purchase_remarks.required'         => 'The Remark field is required.',
            'purchaseVendorPoDocument|purchaseExtraDocument.required_without_all'
                                                => 'Please upload at least one Document.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => 0,
            'message' => $validator->errors()->all(),
        ]);


        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());

    }
}
