<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AbpFormRequest extends FormRequest
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
            'product_id' => 'required',
            'client_name' => 'required',
            'budget_type' => 'required',
            'net_margin_budget' => 'required|numeric',  
            'order_value_budget' => 'required|numeric',
            'time_budget' => 'required|date_format:m-Y',
            'remarks_budget' => 'required',
            'payment_terms.*' => 'required',
            'payment_percentage.*' => 'required|numeric',
        ];
    }

    function messages()
    {
        return [    
            'product_id.required' => 'The Product field is required.',
            'client_name.required' => 'The Client field is required.',
            'net_margin_budget.required' => 'The Net Margin field is required.',
            'order_value_budget.required' => 'The Order Value field is required.',
            'remarks_budget.required' => 'The Remark field is required.',
            'payment_terms.required' => 'The Payment Terms field is required.',
            'payment_percentage.required' => 'The Payment Percentage field is required.',
            'time_budget.date_format' => 'The time must be in the format MM-YYYY.',
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

