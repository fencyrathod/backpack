<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DeviceBrand;
use App\Models\DeviceType;
use App\Models\Jobs;
use App\Models\jobservice;
use App\Models\Payment;
use App\Models\ServiceType;
use App\Models\Settings;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Mail;
use PDF;
use Validator;
use Illuminate\Database\Eloquent\Builder;
class customer_info extends Controller
{

    public function check()
    {
        $comments = Comment::whereHasMorph(
            'commentable',
            [Jobs::class, jobservice::class],
            function (Builder $query) {
                $query->where('name', 'like', 'code%');
            }
        )->get();

        dd($comments);
    }



    public function reports(request $req)
    {

        $selected = [];

        $total_payment = [];
        $data = DB::table("jobs")->
            select('customers.Name As customer_name', 'source.name As service_name', 'service_type.name As service_type', 'jobs.Job_Type', 'device_type.name As device_type', 'device_brands.name As device_brand'
            , 'users.name As Assignee_name', 'jobs.*')->join('customers', 'customers.id', '=', 'jobs.Customer_Name')
            ->join('source', 'source.id', '=', 'jobs.Source')->join('service_type', 'service_type.id', '=', 'jobs.Service_Type')
            ->join('device_type', 'device_type.id', '=', 'jobs.Device_Type')
            ->join('device_brands', 'device_brands.id', '=', 'jobs.Device_Brand')
            ->join('users', 'users.id', '=', 'jobs.Assignee');
        if ($req->Status != null) {

            $selected = $req->Status;        
            $data = $data->whereIn('Status', $req->Status);
            $total_payment = Payment::
                join('jobs', 'jobs.id', '=', 'payments.job_id')

                ->whereIn('jobs.Status', $req->Status)->sum('amount');
        }
        if ($req->name != null) {
            $value = $req->name;
            $data = $data
                ->where("customers.Name", $value);

            $total_payment = Payment::
                join('customers', 'customers.id', '=', 'payments.customer_id')->where('customers.Name', '=', $value)->sum('amount');
        }

        if ($req->type != null) {
            $value = $req->type;
            $data = $data
                ->where("service_type.name", $value);
            $total_payment = Payment::
                join('jobs', 'jobs.id', '=', 'payments.job_id')->
                join('service_type', 'service_type.id', '=', 'jobs.Service_Type')
                ->where('service_type.name', '=', $value)->sum('amount');

        }

        if ($req->dtype != null) {
            $value = $req->dtype;
            $data = $data
                ->where("device_type.name", $value);

            $total_payment = Payment::
                join('jobs', 'jobs.id', '=', 'payments.job_id')->
                join('device_type', 'device_type.id', '=', 'jobs.Device_Type')
                ->where('device_type.name', '=', $value)->sum('amount');
        }

        if ($req->dbrand != null) {
            $value = $req->dbrand;
            $data = $data
                ->where("device_brands.name", $value);

            $total_payment = Payment::
                join('jobs', 'jobs.id', '=', 'payments.job_id')->
                join('device_brands', 'device_brands.id', '=', 'jobs.Device_Brand')
                ->where('device_brands.name', '=', $value)->sum('amount');
        }

        if ($req->assign != null) {
            $value = $req->assign;
            $data = $data
                ->where("users.name", $value);

            $total_payment = Payment::
                join('jobs', 'jobs.id', '=', 'payments.job_id')->
                join('users', 'users.id', '=', 'jobs.Assignee')
                ->where('users.name', '=', $value)->sum('amount');

        }

        if ($req->date != null) {
            $data = $data->whereDate("jobs.created_at", '=', $req->date);

        }
        if ($req->s_date && $req->e_date != null) {
            $date = explode("-", $req->daterange);

            $data = $data
                ->whereBetween('jobs.created_at',
                    [$req->s_date . " 00:00:00", $req->e_date . " 23:59:59"]);

            $total_payment = Payment::whereBetween('created_at',
                [$req->s_date . " 00:00:00", $req->e_date . " 23:59:59"])->sum('amount');
        }

        if ($req->Status == null && $req->name == null && $req->type == null
            && $req->dtype == null && $req->dbrand == null && $req->assign == null
            && $req->date == null && $req->s_date == null && $req->e_date == null) {

            $data = $data;
            $total_payment = Payment::sum('amount');
        }

        $data = $data->paginate(10);

        $s_type = ServiceType::all();
        $d_type = DeviceType::all();
        $brand_type = DeviceBrand::all();
        $user = User::all();
        $Customer = Customer::all();
        return view("reports", ["data" => $data, 'selected' => $selected,
            'date' => $req->date, 'total_payment' => $total_payment,
            'name' => $req->name,
            'type' => $req->type,
            'dtype' => $req->dtype,
            'dbrand' => $req->dbrand,
            'assign' => $req->assign,
            'service_type' => $s_type,
            'device_type' => $d_type,
            'brand_type' => $brand_type,
            'user' => $user,
            'Customer' => $Customer,

        ]);
    }

    public function check_date(request $req)
    {

        if ($req->st && $req->ed) {

            $totp = Payment::whereBetween('created_at',
                [$req->st . " 00:00:00", $req->ed . " 23:59:59"])->sum('amount');

            $totj = Jobs::whereBetween('created_at',
                [$req->st . " 00:00:00", $req->ed . " 23:59:59"])->count('id');

            $sp = Jobs::whereBetween('created_at',
                [$req->st . " 00:00:00", $req->ed . " 23:59:59"])->where('Status', 'In Process')->count('id');

            $sc = Jobs::whereBetween('created_at',
                [$req->st . " 00:00:00", $req->ed . " 23:59:59"])->where('Status', 'Completed')->count('id');

            echo json_encode(array("totp" => $totp, 'totj' => $totj, 'sp' => $sp, 'sc' => $sc));

        } else {
            $totp = Payment::sum('amount');

            $totj = Jobs::count('id');

            $sp = Jobs::where('Status', 'In Process')->count('id');

            $sc = Jobs::where('Status', 'Completed')->count('id');

            echo json_encode(array("totp" => $totp, 'totj' => $totj, 'sp' => $sp, 'sc' => $sc));
        }

    }

    public function device_brand()
    {
        $data = DeviceType::all();
        echo $data;
    }

    public function fetch_device_type(request $req)
    {
        $search_term = $req->input('q');

        if ($search_term) {
            $data = DeviceBrand::where("name", 'LIKE', '%' . $search_term . '%')->get();
        } else {
            $data = DeviceBrand::all();
        }
        return $data;
    }
    public function invoice()
    {
        $id = $_REQUEST['id'] ?? null;

        $job = Jobs::find($id);
        $c_id = $job->Customer_Name;
        $customer = Customer::find($c_id);
        $d_id = $job->Device_Type;
        $device_type = DeviceType::find($d_id);
        $db_id = $job->Device_Brand;
        $device_brand = DeviceBrand::find($db_id);
        $s_id = $job->Service_Type;
        $service_type = ServiceType::find($s_id);

        $service = "";
        if ($id) {
            if (jobservice::where("job_id", "=", $id)->exists()) {
                $check = DB::table("services")->select(
                    'services.s_name', 'services.price', 'services.tax', 'services.tax_code')
                    ->join('job_service', 'services.id', '=', 'job_service.service_id')->where('job_service.job_id', $id)->get();

                $service = $check;
            }
        }

        $detail = Settings::find(1);

        $data = array(
            "job" => $job,
            "customer" => $customer,
            "device_type" => $device_type,
            'device_brand' => $device_brand,
            'service_type' => $service_type,
            'service' => $service,
            'detail' => $detail,
        );

        //$pdf = Pdf::loadView('pdf.invoice')->setPaper('a4', 'Landscape');;
        //  return $pdf->download('Invoice.pdf');
        $pdf = Pdf::loadView('pdf.invoice', ["data" => $data]);
        return $pdf->stream();

    }

    public function quotation()
    {
        $id = $_REQUEST['id'] ?? null;

        $job = Jobs::find($id);
        $c_id = $job->Customer_Name;
        $customer = Customer::find($c_id);
        $d_id = $job->Device_Type;
        $device_type = DeviceType::find($d_id);
        $db_id = $job->Device_Brand;
        $device_brand = DeviceBrand::find($db_id);
        $s_id = $job->Service_Type;
        $service_type = ServiceType::find($s_id);

        $service = "";
        if ($id) {
            if (jobservice::where("job_id", "=", $id)->exists()) {
                $check = DB::table("services")->select(
                    'services.s_name', 'services.price', 'services.tax', 'services.tax_code')
                    ->join('job_service', 'services.id', '=', 'job_service.service_id')->where('job_service.job_id', $id)->get();

                $service = $check;
            }
        }

        $detail = Settings::find(1);

        $data = array(
            "job" => $job,
            "customer" => $customer,
            "device_type" => $device_type,
            'device_brand' => $device_brand,
            'service_type' => $service_type,
            'service' => $service,
            'detail' => $detail,
        );

        //$pdf = Pdf::loadView('pdf.invoice')->setPaper('a4', 'Landscape');;
        //  return $pdf->download('Invoice.pdf');
        $pdf = Pdf::loadView('pdf.quotation', ["data" => $data]);
        return $pdf->stream();

    }

    public function index($id)
    {
        $data = Jobs::find($id);

        $customer = Customer::find($data->Customer_Name);
        $user = User::find($data->Assignee);
        $print = array(
            "c_name" => $customer->Name,
            "Assign_user" => $user->name,
        );

        return view("Add_Payment", ["data" => $print]);

    }

    public function customer_register(request $req)
    {
        $rules = array(
            'name' => 'required',
            'email' => 'required|Email|unique:customers,email',
            'phone' => 'required|numeric|digits:10|unique:customers,Phone',
            'city' => 'required',
            'gender' => 'required',
            'state' => 'required',
            'zipcode' => 'required|min:6|max:8',
            'password' => 'required',
        );

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $customer = new Customer();
            $customer->Name = $req->name;
            $customer->Email = $req->email;
            $customer->Phone = $req->phone;
            $customer->City = $req->city;
            $customer->Gender = $req->gender;
            $customer->State = $req->state;
            $customer->Zipcode = $req->zipcode;
            $customer->Password = Hash::make($req->password);
            if ($customer->save()) {
                return Redirect::back()->with('msg', 'Customer Register Successfull');
            } else {
                return Redirect::back()->with('msg1', 'Register Not Successfull');
            }

        }
    }

    public function customer_login(request $req)
    {
        $rules = array(

            'phone' => 'required|numeric|digits:10',
            'password' => 'required',
        );

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $customer = Customer::where("phone", $req->phone)->first();

            if (!$customer) {
                return Redirect::back()->with('msg1', 'Login Not successfull')->withInput();
            }
            if (!Hash::check($req->password, $customer->Password)) {
                return Redirect::back()->with('msg1', 'Login Not successfull')->withInput();
            }
            return redirect("/");

        }
    }

    public function forget_password(request $req)
    {
        if (Customer::where("Email", $req->email)->exists()) {
            $print = Customer::where("Email", $req->email)->first();

            $data = ["name" => $print->Name, "email" => $print->Email];
            $user['to'] = $print->Email;

            Mail::send('mail', $data, function ($messages) use ($user) {
                $messages->to($user['to']);

                $messages->subject('Reset Password');
            });

            return Redirect::back()->with('msg', 'We have emailed your password reset link!');
        } else {
            return Redirect::back()->with('msg1', 'This Email Is not Register Please Try Again');
        }
    }

    public function reset_password(request $req)
    {
        $rules = array(
            'email' => 'required|Email',
            'pass' => 'required',
            'conf_pass' => 'required|same:pass',
        );

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            if (Customer::where("Email", $req->email)->exists()) {
                $print = Customer::where("Email", $req->email)->first();

                $update_password = Customer::find($print->id);

                $update_password->Password = Hash::make($req->conf_pass);

                if ($update_password->save()) {
                    return redirect("customer_login")->with('msg', 'Your Password Reset Successfully');
                } else {
                    return Redirect::back()->with('msg1', 'Your Password Reset Not Successfully');
                }
                
            } else {
                return Redirect::back()->with('msg1', 'Please Try Again');
            }
        }
    }

}