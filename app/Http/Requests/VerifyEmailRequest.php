<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
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
            'email' => 'required|regex:/^[0-9A-Za-z.\-_@]+$/|min:11|max:100|email',
            'username' => 'required|min:3|max:100',
        ];
    }


    public function messages()
    {
        return [
            'email.required' => 'A valid email address is required',
            'username.required' => 'A username is required',
        ];
    }
    public function attributes()
    {
        return [
            'email' => 'Email address',
            'username' => 'Username',
        ];
    }

}
