<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subject_id'                => 'required',
            'name'                      => 'required|string',
            'reg_no'                    => 'required|string',
            'email'                     => 'required|email|unique:students',
            'gender'                    => 'required|in:1,2',
            'current_address'           => 'required|string',
            'permanent_address'         => 'required|string',
            'monthly_salary'            => 'required|numeric',
            'contact_number'            => 'required|string',
            'profile'                   => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

    }

    public function messages(){
        return [
            'subject_id.required'           => 'Subject is required',
            'monthly_salary.numeric'        => 'Salary can not be string, Please give numeric number',
        ];
    }
}
