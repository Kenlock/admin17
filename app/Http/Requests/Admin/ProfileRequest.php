<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'username'=>'required|min:5|max:30|unique:users,username,'.\Admin::getUser()->id,
            'email'=>'required|min:5|max:50|unique:users,email,'.\Admin::getUser()->id,
            'old_password'=>'required',
            'password'=>'required|min:5',
            'verify_password'=>'same:password',
            'avatar'=>'image',
        ];
    }
}
