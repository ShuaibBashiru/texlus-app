<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'personal_id' => 'nullable|string|max:40|min:6|unique:admin_record',
            'lastname' => 'required',
            'firstname' => 'required',
            'othername' => 'nullable',
            'email_one' => 'required|email|unique:admin_record',
            'phone_code' => 'required',
            'phone_one' => 'required|numeric|unique:admin_record',
            'dob' => 'nullable|numeric',
            'mob' => 'nullable|numeric',
            'yob' => 'nullable|numeric',
            'gender_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'phone_one.numeric' => 'The :attribute provided is invalid.',
            'phone_code.required' => 'The :attribute provided is invalid.',
            'dob.numeric' => 'The :attribute provided is invalid.',
            'mob.numeric' => 'The :attribute provided is invalid.',
            'yob.numeric' => 'The :attribute provided is invalid.',
            'gender_id.required' => 'The :attribute provided is invalid.',
            'email_one.unique' => 'An account with the email address already exist, try another.',
            'phone_one.unique' => 'An account with the phone number already exist, try another.',

        ];
    }
    public function attributes()
    {
        return [
            'personal_id' => 'ACCOUNT ID',
            'lastname' => 'Surname',
            'firstname' => 'Firstname',
            'othername' => 'Othername',
            'email_one' => 'Email address',
            'phone_code' => 'Phone Code',
            'phone_one' => 'Phone number',
            'gender_id' => 'Gender',
            'dob' => 'Day of birth',
            'mob' => 'Month of birth',
            'yob' => 'Year of birth',
        ];
    }

}
