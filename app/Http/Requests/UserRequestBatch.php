<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequestBatch extends FormRequest
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
            'records'=>'present|array',
            'records.*.personal_id' => 'required|string|max:30|min:6',
            'records.*.lastname' => 'required',
            'records.*.firstname' => 'required',
            'records.*.othername' => 'nullable',
            'records.*.email_one' => 'required|email',
            'records.*.phone_one' => 'required',
            'records.*.phone_code' => 'required',
            'records.*.date_of_birth' => 'required|string',
            'records.*.gender_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'records.*.personal_id.required' => 'The :attribute provided is invalid',
            'records.*.lastname.required' => 'The :attribute provided is invalid',
            'records.*.firstname.required' => 'The :attribute provided is invalid',
            'records.*.othername.required' => 'The :attribute provided is invalid',
            'records.*.email_one.required' => 'An account with the email address already exist, try another.',
            'records.*.phone_one.required' => 'An account with the phone number already exist, try another.',
            'records.*.phone_code.required' => 'The :attribute provided is invalid',
            'records.*.date_of_birth.required' => 'The :attribute provided is invalid',
            'records.*.gender_id.required' => 'The :attribute provided is invalid',
        ];
    }
    public function attributes()
    {
        return [
            'records.*.personal_id' => 'ACCOUNT ID(s)',
            'records.*.lastname' => 'Surname',
            'records.*.firstname' => 'Firstname',
            'records.*.othername' => 'Othername',
            'records.*.email_one' => 'Email address',
            'records.*.phone_one' => 'Phone number',
            'records.*.phone_code' => 'Phone country code',
            'records.*.date_of_birth' => 'Date of birth',
            'records.*.gender_id' => 'Gender',
        ];
    }

}
