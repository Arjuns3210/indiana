<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class EstimatorDocumentRequest extends FormRequest
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
        if($this->designer_approval_status == "designer_rejected"){
            return [
                'drawing_remarks' => 'required',
            ];
        }

        if($this->estimator_approval_status == "estimator_rejected"){
            return [
                'engg_remarks' => 'required',
            ];
        }

        if (! count(file_view('estimator-engineer', 'po-cost-sheet_'.$this->input('mipo_id'), null))) {
            return [
                'estimatorPoSheetDocument'   => 'required',
                'estimatorPoSheetDocument.*' => 'file',
            ];
        }

        if (is_null($this->estimator_approval_status) || empty($this->estimator_approval_status)) {
            return [
                'estimatorPoSheetDocument|estimatorExtraDocument' =>
                    'required_without_all:estimatorPoSheetDocument,estimatorExtraDocument',
            ];
        }

        return [];
    }
    
    function messages()
    {
        return [
            'estimatorPoSheetDocument.required' => 'Please upload PO Cost Sheet Document.',
            'drawing_remarks.required'          => 'The Remark field is required.',
            'engg_remarks.required'             => 'The Remark field is required.',
            'estimatorPoSheetDocument|estimatorExtraDocument.required_without_all'
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
