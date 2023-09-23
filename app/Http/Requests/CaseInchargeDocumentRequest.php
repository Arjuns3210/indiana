<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CaseInchargeDocumentRequest extends FormRequest
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
        if($this->ci_approval_status == "rejected"){
            return [
              'ci_remarks' => 'required',
            ];
        }

        if (! count(file_view('caseincharge', 'dcl_'.$this->input('mipo_id'),
                null)) && ! count(file_view('caseincharge', 'mi_'.$this->input('mipo_id'),
                null)) && empty($this->ci_remarks)) {
            return [
                'caseInchargeDclDocument.*'                      => 'file',
                'caseInchargeMiDocument.*'                       => 'file',
                'caseInchargeDclDocument|caseInchargeMiDocument' => 'required_without_all:caseInchargeDclDocument,caseInchargeMiDocument',
            ];
        }

        if (is_null($this->ci_approval_status) || empty($this->ci_approval_status)) {
            return [
                'caseInchargeDclDocument|caseInchargeMiDocument|caseInchargeExtraDocument' => 'required_without_all:caseInchargeDclDocument,caseInchargeMiDocument,caseInchargeExtraDocument',
            ];
        }

        return [];
    }

    function messages()
    {
        return [
            'caseInchargeDclDocument|caseInchargeMiDocument.required_without_all'
                                  => 'Please upload either a DCL document or a MI document.',
            'ci_remarks.required' => 'The Remark field is required.',
            'caseInchargeDclDocument|caseInchargeMiDocument|caseInchargeExtraDocument.required_without_all'
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
