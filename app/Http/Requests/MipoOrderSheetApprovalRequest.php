<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class MipoOrderSheetApprovalRequest extends FormRequest
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
        if (!count(file_view('mipo-team', 'order-approval-sheet_'.$this->input('mipo_id'), null))) {
            return [
                'mipoOrderApprovalSheetDocument' => 'required',
                'mipoOrderApprovalSheetDocument.*' => 'file',
            ];
        }
        if ($this->mipo_order_sheet_approval_status == "approve"){
            return [
                'management_id' => 'required',
            ];
        }
        if ($this->mipo_order_sheet_reject_status == "rejected") {
            return [
                'management_id'       => 'required',
                'order_sheet_remarks' => 'required',
            ];
        }

        if (is_null($this->mipo_order_sheet_reject_status) || empty($this->mipo_order_sheet_reject_status)) {
            return [
                'mipoOrderApprovalSheetDocument' => 'required',
            ];
        }

        return [];
    }

    function messages()
    {
        return [
            'mipoOrderApprovalSheetDocument.required' => 'Please upload Order Approval Sheet document.',
            'order_sheet_remarks.required' => 'The Mipo Team remarks field is required.',
            'management_id.required' => 'The Management User field is required.',
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
