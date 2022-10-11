<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'subject_id'            => 'required',
            'name'                  => "required|string",
            'email'                 => "required|email|unique:teachers,email,{$this->teacher->id}",
            // 'password'              => 'confirmed',
            'gender'                => 'required|in:1,2',
            'current_address'       => 'required|string',
            'permanent_address'     => 'required|string',
            'contact_number'        => 'required|string',
            'profile'               => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
