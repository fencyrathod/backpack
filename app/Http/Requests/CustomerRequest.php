<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (\CRUD::getCurrentOperation() == "create") {
            $rules = [
                'Name' => 'required',
                'Email' => 'required|Email',
                'Phone' => 'required|numeric|digits:10',
                'Address' => 'required',
                'City' => 'required',
                'Gender' => 'required',
                'State' => 'required',
                'Zipcode' => 'required|min:6|max:8',
                'Password' => 'required',
            ];
            return $rules;
        } else if (\CRUD::getCurrentOperation() == "update") {
            $rules = [
                'Name' => 'required',
                'Email' => 'required|Email',
                'Phone' => 'required|numeric|digits:10',
                'Address' => 'required',
                'City' => 'required',
                'Gender' => 'required',
                'State' => 'required',
                'Zipcode' => 'required|min:6|max:8',

            ];
            return $rules;
        }

    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
