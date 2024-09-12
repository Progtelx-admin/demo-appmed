<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientRequest extends FormRequest
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
    public function rules(Request $request)
    {
        if (isset($request['id'])) {
            return [
                'name' => [
                    'required',

                ],
                'gender' => [
                    'required',
                    Rule::in(['male', 'female']),
                ],
                'dob' => 'required|date_format:Y-m-d',
                'phone' => [
                    'required',
                ],
                'email' => [
                    'nullable',
                    'email',
                ],
                'national_id' => [
                    'nullable',
                    Rule::unique('patients')->ignore($request['id'])->whereNull('deleted_at'),
                ],
                'passport_no' => [
                    'nullable',
                ],
                'address' => 'nullable',
                'profession' => 'nullable',
                'city' => 'nullable',
                'vaccinated' => 'nullable',
                'vaccinemodel' => 'nullable',
                'datevaccine1' => 'nullable',
                'datevaccine2' => 'nullable',
                'datevaccine2' => 'nullable',
            ];
        }

        if ($this->patient) {
            return [
                'name' => [
                    'required',
                ],
                'gender' => [
                    'required',
                    Rule::in(['male', 'female']),
                ],
                'dob' => 'required|date_format:Y-m-d',
                'phone' => [
                    'required',
                ],
                'email' => [
                    'nullable',
                    'email',
                ],
                'national_id' => [
                    'nullable',
                    Rule::unique('patients')->ignore($this->patient)->whereNull('deleted_at'),
                ],
                'passport_no' => [
                    'nullable',
                ],
                'address' => 'nullable',
                'profession' => 'nullable',
                'city' => 'nullable',
                'vaccinated' => 'nullable',
                'vaccinemodel' => 'nullable',
                'datevaccine1' => 'nullable',
                'datevaccine2' => 'nullable',
                'datevaccine2' => 'nullable',
            ];
        } else {
            return [
                'name' => [
                    'required',
                ],
                'gender' => [
                    'required',
                    Rule::in(['male', 'female']),
                ],
                'dob' => 'required|date_format:Y-m-d',
                'phone' => [
                    'required',
                ],
                'email' => [
                    'nullable',
                    'email',
                ],
                'national_id' => [
                    'nullable',
                    Rule::unique('patients')->whereNull('deleted_at'),
                ],
                'passport_no' => [
                    'nullable',
                ],
                'address' => 'nullable',
                'profession' => 'nullable',
                'city' => 'nullable',
                'vaccinated' => 'nullable',
                'vaccinemodel' => 'nullable',
                'datevaccine1' => 'nullable',
                'datevaccine2' => 'nullable',
                'datevaccine2' => 'nullable',
            ];
        }

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
