<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInstrumentRequest extends FormRequest
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
        if (isset($this->instrument) && $this->instrument == 1) {
            return [
                'name' => [
                    Rule::unique('instruments')->ignore($this->instrument)->whereNull('deleted_at'),
                ],
                'model' => [
                    'model',
                    Rule::unique('instruments')->ignore($this->instrument)->whereNull('deleted_at'),
                ],
                'comment' => [
                    'comment',
                    Rule::unique('instruments')->ignore($this->instrument)->whereNull('deleted_at'),
                ],
            ];
        } else {
            return [
                'name' => [
                    Rule::unique('instruments')->ignore($this->instrument)->whereNull('deleted_at'),
                ],
                'model' => [
                    'model',
                    Rule::unique('instruments')->ignore($this->instrument)->whereNull('deleted_at'),
                ],
                'comment' => [
                    'comment',
                    Rule::unique('instruments')->ignore($this->instrument)->whereNull('deleted_at'),
                ],
                'branches' => 'required',
            ];
        }
    }
}
