<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateMipoRequest extends FormRequest
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
        return [
            'po_type'          => 'required|in:new,cn',
            'po_recv_date'     => 'nullable|date',
            'revision_mipo_id' => 'required_if:po_type,cn',
            'product_id'       => 'required',
            'ho_recv_date'     => 'nullable|date',
            'enquiry_id'       => 'required',
        ];
    }

    function messages()
    {
        return [
            'enquiry_id.required'          => 'The Enquiry field is required.',
            'po_recv_date.date'            => 'The Po Date field is not valid format.',
            'revision_mipo_id.required_if' => 'The  mipo  field is required when po type is CN.',
            'revision_no.required'         => 'The Revision field is required.',
            'ho_recv_date.date'            => 'The Ho Received Date field is not valid format.',
            'po_type.required'             => 'The Po Type field is required.',
            'product_id.required'          => 'The Product field is required.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @throws ValidationException
     * @return void
     *
     */

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
