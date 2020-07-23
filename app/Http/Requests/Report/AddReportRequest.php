<?php

namespace App\Http\Requests\Report;
use Illuminate\Foundation\Http\FormRequest;

class AddReportRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
    */
    public function authorize() {  
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules() {
        return [
            'description' => 'required_if:file,NULL',
            'file' => 'required_if:description,NULL|file|mimes:jpeg,bmp,png,pdf', //,doc,docx,xlsx
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {

        return [
        ];

    }
}
