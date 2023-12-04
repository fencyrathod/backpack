<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
                'Name' => 'required',
             'Phone'=>'required|numeric|digits:10',
             'City'=>'required',
             'Email'=>'required|Email',
             'Password'=>'required'
                ];
            return $rules;
        }
     else if(\CRUD::getCurrentOperation()=="update")
        {
            $rules= [
                'Name' => 'required',
                'Phone'=>'required|numeric|digits:10',
                'City'=>'required',
                'Email'=>'required|Email',
            
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
