<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccessRequestBatch extends FormRequest
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
            'records.*.routeLink' => 'required',
            'records.*.route_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'records.*.routeLink.required' => 'The :attribute provided is invalid',
            'records.*.route_name.required' => 'The :attribute provided is invalid',
        ];
    }
    public function attributes()
    {
        return [
            'records.*.routeLink' => 'Route link',
            'records.*.route_name' => 'Route Name',
        ];
    }

}
