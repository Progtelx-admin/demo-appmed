<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PathologyRequest extends FormRequest
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
            'name' => 'required_without:patient_id',
            'phone' => 'required_without:patient_id',
            'gender' => [
                'required_without:patient_id',
                Rule::in(['male', 'female']),
            ],
            'address' => 'required_without:patient_id',
            //'dob'=>'required_without:patient_id|date_format:Y-m-d',
            'email' => 'required_without:patient_id|email'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'dob' => 'date of birth',
        ];
    }
}
