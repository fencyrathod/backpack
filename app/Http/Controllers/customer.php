<?php

namespace App\Http\Controllers;
use App\Models\Customer As Cust;
use Illuminate\Http\Request;

class customer extends Controller
{
    public function customer_register(request $req)
    {
        $customer=new customer();
        $customer->name=$req->name;
        $customer->email=$req->email;
        $customer->phone=$req->phone;
        $customer->city=$req->city;
        $customer->state=$req->state;
        $customer->zipcode=$req->zipcode;
        $customer->password=$req->passowrd;
        if($customer->save())
        {
            return Redirect::back()->with('msg', 'Customer Register Successfull');
        }
        else
        {
            return Redirect::back()->with('msg1', 'Customer Register Successfull');
        }
    }
}
