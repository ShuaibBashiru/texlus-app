<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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
            'email_id' => 'required|regex:/^[0-9A-Za-z.\-_@]+$/|min:11|max:100|email',
        ];
    }


    public function messages()
    {
        return [
            'email_id.required' => 'A valid email address is required',
        ];
    }
    public function attributes()
    {
        return [
            'email_id' => 'Email address',
        ];
    }

}
