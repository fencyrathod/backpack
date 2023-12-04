<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\customer_info;
use App\Http\Controllers\Admin\JobsCrudController;
// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { 
    Route::crud('emp', 'empCrudController');
    Route::crud('staff', 'StaffCrudController');
    Route::crud('customer', 'CustomerCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('source', 'SourceCrudController');
    Route::crud('service-type', 'ServiceTypeCrudController');
    Route::crud('device-type', 'DeviceTypeCrudController');
    
    Route::crud('device-brand', 'DeviceBrandCrudController');
    Route::crud('storage-location', 'StorageLocationCrudController');
    Route::crud('jobs', 'JobsCrudController');
    Route::crud('payment', 'PaymentCrudController');

    Route::get("jobs/invoice",[customer_info::class,"invoice"]);

    Route::get("jobs/quotation",[customer_info::class,"quotation"]);
    
    Route::get("jobs/fetch/test",[JobsCrudController::class,"creates"]);

    Route::crud('service', 'ServiceCrudController');
    Route::crud('settings', 'SettingsCrudController');

    Route::get('/reports', function () {
        return view('reports');
    });

    Route::get('/reports',[customer_info::class,"reports"])->name('reports.jobs');
    Route::crud('tag', 'TagCrudController');
    Route::get('pdf','empCrudController@pdf');
}); // this should be the absolute last line of this file