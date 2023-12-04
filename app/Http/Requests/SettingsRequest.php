<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
        if(\CRUD::getCurrentOperation()=="create")
        {
            $rules= [
                'shop_name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'pincode' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'gst_no' => 'required',
                'account_name' => 'required',
                'bank_name' => 'required',
                'account_no' => 'required',
                'ifsc_no' => 'required',
              
                'logo'=>'required|mimes:jpeg,jpg,png,gif|image|max:2048',
                ];
            return $rules;
        }
     else if(\CRUD::getCurrentOperation()=="update")
        {
            $rules= [
                'shop_name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'pincode' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'gst_no' => 'required',
                'account_name' => 'required',
                'bank_name' => 'required',
                'account_no' => 'required',
                'ifsc_no' => 'required',
                'logo'=>'file|mimes:jpeg,jpg,png,gif|image|max:2048',
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
