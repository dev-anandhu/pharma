<?php

namespace App\Http\Requests\Employee;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest {

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
            'id'   => 'present',
            'first_name'   => 'required|min:3|max:20',
            'last_name'   => 'required|min:3|max:20',
            'email' => 'required|min:3|max:30|email|unique:users,email,'.request()->id.',id,deleted_at,NULL',
            'password' => 'required_if:id,null',
            'type' => 'required|numeric',
            'department' => 'required_if:type,2|required_if:type,3',
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
            'department.required_if' => 'The department field is required when user type is other than admin.',
        ];

    }
}
