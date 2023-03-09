<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UpdateStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name'              => 'required|string',
            'email'             => "required|email|unique:students,email,{$this->student->id}",
            'gender'            => 'required|in:1,2',
            'current_address'   => 'required|string',
            'permanent_address' => 'required|string',
            'contact_number'    => 'required|string',
            'parent_contact'    => 'required|string',
            'profile'           => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'batch_id'          => 'required|integer',
            'gender'            => 'required|integer'
        ];
    }
}
