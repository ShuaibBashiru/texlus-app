<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesItemsRequestBatch extends FormRequest
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
            'records.*.item' => 'required',
            'records.*.price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'records.*.price.required' => 'The :attribute provided is invalid',
            'records.*.item.required' => 'The :attribute provided is invalid',
        ];
    }
    public function attributes()
    {
        return [
            'records.*.item' => 'Route link',
            'records.*.price' => 'Description',
        ];
    }

}
