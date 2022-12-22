<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AuthRequest extends FormRequest
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
            'userid' => 'required|regex:/^[0-9A-Za-z.\-_@]+$/|min:11|max:100|email',
            'pwd' => 'required|regex:/^[0-9A-Za-z.\-_]+$/|min:6|max:100',
        ];
    }


    public function messages()
    {
        return [
            'userid.required' => 'A valid email address is required',
            'pwd.required' => 'A valid user password is required',
        ];
    }
    public function attributes()
    {
        return [
            'userid' => 'Email address',
            'pwd' => 'Password',
        ];
    }

}
