<?php

namespace App\Http\Requests\Patient;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;

class GroupOwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $group = Group::where('id', $this->id)->first();

        return auth()->guard('patient')->user()['id'] == $group['patient_id'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
