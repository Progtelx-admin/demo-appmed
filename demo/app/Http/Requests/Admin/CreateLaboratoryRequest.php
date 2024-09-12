<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateLaboratoryRequest extends FormRequest
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
            'ResultMasterFK' => 'required|unique:laboratories',
            'AnalyzerNo' => 'required|unique:laboratories',
            'SampleNo' => 'required',
            'ResultTransferDtTm' => 'required',
            'AnalyzerTestParam' => 'required',
            'ResultValue' => 'required',
            'ResultValue2' => 'required',
            'ResultValueFlag' => 'required',
            'SampleType' => 'required',
            'ResultUnit' => 'required',
            'ReferenceRange' => 'required',
            'IsResultValueRead' => 'required',
            'LIMSTestParam' => 'required',
            'LIMSData1' => 'required',
            'LIMSData2' => 'required',
            'LIMSData3' => 'required',
        ];
    }
}
