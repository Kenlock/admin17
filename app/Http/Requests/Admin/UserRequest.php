<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'=>'required|min:5|max:30',
            'username'=>'required|min:5|max:30|unique:users,username,'.\Admin::getId(),
            'email'=>'required|min:5|max:50|unique:users,email,'.\Admin::getId(),
            'password'=>'required|min:5',
            'verify_password'=>'same:password',
            'avatar'=>'image',
            'role_id'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'role_id.required'=>'Role is Required',
        ];
    }
}
