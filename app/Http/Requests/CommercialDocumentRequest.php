<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CommercialDocumentRequest extends FormRequest
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
        if($this->commercial_approval_status == "rejected"){
            return [
                'commercial_remarks' => 'required',
            ];
        }

        if (! count(file_view('commercial', 'template_'.$this->input('mipo_id'),
                null)) && ! count(file_view('commercial', 'po-detail_'.$this->input('mipo_id'),
                null)) && empty($this->commercial_remarks)) {
            return [
                'commercialTemplateDocument.*'                          => 'file',
                'commercialPoDetailDocument.*'                          => 'file',
                'commercialTemplateDocument|commercialPoDetailDocument' => 'required_without_all:commercialTemplateDocument,commercialPoDetailDocument',
            ];
        }
        if (is_null($this->commercial_approval_status) || empty($this->commercial_approval_status)) {
            return [
                'commercialTemplateDocument|commercialPoDetailDocument|commercialExtraDocument' =>
                    'required_without_all:commercialTemplateDocument,commercialPoDetailDocument,commercialExtraDocument',
            ];
        }

        return [];
    }

    function messages()
    {
        return [
            'commercialTemplateDocument|commercialPoDetailDocument.required_without_all' => 'Please upload either a template document or a PO detail document.',
            'commercial_remarks.required'                                                => 'The Remark field is required.',
            'commercialTemplateDocument|commercialPoDetailDocument|commercialExtraDocument.required_without_all'
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
