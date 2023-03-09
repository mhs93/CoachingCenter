<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                 => 'required|string',
            'reg_no'               => 'required|string|unique:students',
            'email'                => 'required|email|unique:students',
            'gender'               => 'required|in:1,2',
            'current_address'      => 'required|string',
            'permanent_address'    => 'required|string',
            'contact_number'       => 'required|string',
            'parent_information'   => 'required|string',
            'parent_contact'       => 'required|string',
            'guardian_information' => 'required|string',
            'guardian_contact'     => 'required|string',
            'profile'              => 'image|mimes:jpeg,png,jpg|max:2048',
            'batch_id'             => 'required|integer',
            'initial_amount'       => 'required|string',
            'adjustment_type'      => 'nullable|integer',
            'adjustment_balance'   => 'nullable|string',
            'adjustment_cause'     => 'nullable|string',
            'total_amount'         => 'required|string',
            'monthly_fee'          => 'nullable|string',
            'note'                 => 'nullable|string',
        ];
    }

    public function messages(){
        return [
            'batch_id.required'             => 'Batch is required',
            'monthly_fee.numeric'           => 'Monthly fee can not be string, Please give numeric number',
        ];
    }
}
