<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobsRequest extends FormRequest
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
                'Customer_Name' => 'required',
                'Service_Type' => 'required',
                'Job_Type' => 'required',
                'Device_Type' => 'required',
                'Device_Brand' => 'required',
               
                'Assignee' => 'required',
                'Device_Password'=>'required',
                'Image'=>'required|mimes:jpeg,jpg,png,gif|image|max:2048',
                ];
            return $rules;
        }
     else if(\CRUD::getCurrentOperation()=="update")
        {
            $rules= [
                'Customer_Name' => 'required',
              
                'Service_Type' => 'required',
                'Job_Type' => 'required',
                'Device_Type' => 'required',
                'Device_Brand' => 'required',
              
                
                
               
              
                'Assignee' => 'required',
                'Image'=>'file|mimes:jpeg,jpg,png,gif|image|max:2048',
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
