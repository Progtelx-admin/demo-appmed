<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLaboratoryRequest extends FormRequest
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
        if (isset($this->laboratory) && $this->laboratory == 1) {
            return [
                'ResultMasterFK' => [
                    Rule::unique('laboratories'),
                ],
                'AnalyzerNo' => [
                    'AnalyzerNo',
                    Rule::unique('laboratories'),
                ],
                'SampleNo' => [
                    'SampleNo',
                    Rule::unique('laboratories'),
                ],
                'ResultTransferDtTm' => [
                    'ResultTransferDtTm',
                    Rule::unique('laboratories'),
                ],
                'AnalyzerTestParam' => [
                    'AnalyzerTestParam',
                    Rule::unique('laboratories'),
                ],
                'ResultValue' => [
                    'ResultValue',
                    Rule::unique('laboratories'),
                ],
            ];
        } else {
            return [
                'ResultMasterFK' => [
                    Rule::unique('laboratories'),
                ],
                'AnalyzerNo' => [
                    'AnalyzerNo',
                    Rule::unique('laboratories'),
                ],
                'SampleNo' => [
                    'SampleNo',
                    Rule::unique('laboratories'),
                ],
                'ResultTransferDtTm' => [
                    'ResultTransferDtTm',
                    Rule::unique('laboratories'),
                ],
                'AnalyzerTestParam' => [
                    'AnalyzerTestParam',
                    Rule::unique('laboratories'),
                ],
                'ResultValue' => [
                    'ResultValue',
                    Rule::unique('laboratories'),
                ],
            ];
        }
    }
}
