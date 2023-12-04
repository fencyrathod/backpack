<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customer_info;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::view("reset","reset")->name('reset_password');

Route::view("forget_password","forget_password")->name('forget_password');

Route::view("customer_register","customer_register")->name('customer_register');

Route::view("customer_login","customer_login")->name("customer_login");

Route::post("/customer_register",[customer_info::class,"customer_register"]);

Route::post("/customer_login",[customer_info::class,"customer_login"]);

Route::post("/forget_password",[customer_info::class,"forget_password"]);

Route::post("/reset_password",[customer_info::class,"reset_password"]);

Route::get("/device_brand",[customer_info::class,"device_brand"]);

Route::get("/fetch_device_type",[customer_info::class,"fetch_device_type"]);

//Route::get("tag_inline_create",[customer_info::class,"tag_inline_create"])->name('tag-inline-create');

Route::get("/check_date",[customer_info::class,"check_date"]);

Route::get("/check",[customer_info::class,"check"]);