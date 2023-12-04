<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\JobsRequest;
use App\Models\Customer;
use App\Models\ServiceType;
use App\Models\Source;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class JobsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class JobsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Jobs::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/jobs');
        CRUD::setEntityNameStrings('jobs', 'jobs');

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'description',
            'label' => 'Search',
        ],
            false,
            function ($value) { // if the filter is active

                if (Customer::where("Name", 'LIKE', "%$value%")->exists()) {
                    $data = Customer::where("Name", 'LIKE', "%$value%")->get();
                    $id = $data[0]["id"];

                    $this->crud->query->where('Customer_Name', "$id");
                } else if (Source::where("name", 'LIKE', "%$value%")->exists()) {
                    $d1 = Source::where("name", 'LIKE', "%$value%")->get();
                    $id_s = $d1[0]["id"];

                    $this->crud->query->where("Source", 'LIKE', "$id_s");
                } else if (ServiceType::where("name", 'LIKE', "%$value%")->exists()) {
                    $d1 = ServiceType::where("name", 'LIKE', "%$value%")->get();
                    $id_s = $d1[0]["id"];

                    $this->crud->query->where("Service_Type", 'LIKE', "$id_s");
                } else if (User::where("name", 'LIKE', "%$value%")->exists()) {
                    $d1 = User::where("name", 'LIKE', "%$value%")->get();
                    $id_s = $d1[0]["id"];

                    $this->crud->query->where("Assignee", 'LIKE', "$id_s");
                } else {
                    $this->crud->query->where('Job_Type', 'LIKE', "%$value%");
                }

            });

        $this->crud->addFilter([
            'type' => 'date',
            'name' => 'date',
            'label' => 'Date',
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $this->crud->query->where('created_at', $value);
            });

        $this->crud->addFilter([
            'type' => 'date_range',
            'name' => 'from_to',
            'label' => 'Date range',
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'created_at', '>=', $dates->from);
                $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
            });

        $this->crud->addFilter([
            'name' => 'number',
            'type' => 'range',
            'label' => 'Range',
            'label_from' => 'min value',
            'label_to' => 'max value',
        ],
            false,
            function ($value) { // if the filter is active
                $range = json_decode($value);
                if ($range->from) {
                    $this->crud->addClause('where', 'id', '>=', (float) $range->from);
                }
                if ($range->to) {
                    $this->crud->addClause('where', 'id', '<=', (float) $range->to);
                }
            });

        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'select2_multiple',
            'label' => 'Status',
        ], function () {
            return \App\Models\Customer::all()->keyBy('id')->pluck('Name', 'id')->toArray();
        }, function ($values) { 

            $this->crud->addClause('whereIn', 'Customer_Name', json_decode($values));
        });

        if (backpack_user()->hasRole('staff')) {

            $this->crud->addClause('whereHas', 'check_assigner', function ($query) {
                $query->where('id', "=", backpack_user()->id);

                CRUD::addColumn(['name' => 'Customer_Name', 'type' => 'model_function',
                    'function_name' => 'check_name']);

                CRUD::addColumn(['name' => 'Source', 'type' => 'model_function',
                    'function_name' => 'check_source']);

                CRUD::addColumn(['name' => 'Service_Type', 'type' => 'model_function',
                    'function_name' => 'check_service']);

                CRUD::column('Job_Type')->type('text');

                CRUD::addColumn(['name' => 'Assignee ', 'type' => 'model_function',
                    'function_name' => 'check_assignee']);

            });

        } else {

            CRUD::addColumn(['name' => 'Customer_Name', 'type' => 'model_function',
                'function_name' => 'check_name']);

            CRUD::addColumn(['name' => 'Total_Payment', 'type' => 'model_function',
                'function_name' => 'payment1']);

            CRUD::addColumn(['name' => 'Source', 'type' => 'model_function',
                'function_name' => 'check_source']);

            CRUD::addColumn(['name' => 'Service_Type', 'type' => 'model_function',
                'function_name' => 'check_service']);

            CRUD::column('Job_Type')->type('text');
            CRUD::addColumn(['name' => 'Assignee ', 'type' => 'model_function',
                'function_name' => 'check_assignee']);

            CRUD::addColumn(['name' => 'Status']);

            CRUD::addColumn(['name' => 'action',
                'type' => 'view',
                'view' => "button"]);

            $this->crud->removeButton("update");
            $this->crud->removeButton("delete");

            $this->crud->removeButton("show");

            $this->crud->enableExportButtons();
        }

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(JobsRequest::class);

        $cname = [ // Select
            'label' => "Customer Name",
            'type' => 'select',
            'name' => 'Customer_Name',
            'entity' => 'check_names',
            'model' => "App\Models\Customer",
            'attribute' => 'Name',
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-3',
            ],
         ];
        $this->crud->addField($cname);

        $source = [ // Select
            'label' => "Source",
            'type' => 'select',
            'name' => 'Source',
            'entity' => 'check_sources',
            'model' => "App\Models\Source",
            'attribute' => 'name',
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-3',
            ],

        ];

        $this->crud->addField($source);

        $service_type = [ // Select
            'label' => "Service Type",
            'type' => 'select',
            'name' => 'Service_Type',
            'entity' => 'check_services',
            'model' => "App\Models\ServiceType",
            'attribute' => 'name',
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-3',
            ],

        ];

        $this->crud->addField($service_type);

        $this->crud->addField([ // select_from_array
            'name' => 'Job_Type',
            'label' => "Job Type",
            'type' => 'select_from_array',

            'options' => ['AMC' => 'AMC', 'No Warranty' => 'No Warranty', 'Returned' => 'Returned', 'Warranty' => 'Warranty'],
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-3',
            ],

        ]);

        $Device_Type = [ // Select
            'label' => "Device Type",
            'type' => 'select2',
            'name' => 'Device_Type',
            'entity' => 'check_devices',
            'model' => "App\Models\DeviceType",
            'attribute' => 'name',
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-3',
            ],

        ];

        $this->crud->addField($Device_Type);

        $Device_Brand = [ // Select
            'label' => "Device Brand",
            'type' => 'select2_from_ajax',
            'name' => 'Device_Brand',
            'entity' => 'check_device_brands',

            'attribute' => 'name',
            'allows_null' => true,
            'minimum_input_length' => 2,
            'dependencies' => ['category'],
            'wrapper' => [

                'class' => 'col-md-3',
            ],
            'subfields' => [
                [
                    'name' => 'name',
                    'type' => 'number',
                ],
            ],
            'data_source' => url("fetch_device_type"),

        ];
        $this->crud->addField($Device_Brand);

        CRUD::addField(['name' => 'Device_Model', 'type' => 'text', 'label' => "Device Model",
            'wrapper' => [

                'class' => 'col-md-3 ',
            ], 'attributes' => ['placeholder' => 'Enter The Device Model']]);

        CRUD::addField(['name' => 'Serial_IMEI_Number', 'type' => 'text', 'label' => "Serial/IMEI Number",
            'wrapper' => [

                'class' => 'col-md-3',
            ],
            'attributes' => ['placeholder' => 'Enter The Serial/IMEI_Number',
            ]]);

        CRUD::addField(['name' => 'Accessories', 'type' => 'text',
            'wrapper' => [

                'class' => 'col-md-3',
            ],
            'attributes' => ['placeholder' => 'Enter The Accessories',
            ]]);

        $StorageLocation = [ // Select
            'label' => "Storage Location",
            'type' => 'select',
            'name' => 'Storage_Location',
            'entity' => 'check_storages',
            'model' => "App\Models\StorageLocation",
            'attribute' => 'name',
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-3',
            ],

        ];

        $this->crud->addField($StorageLocation);

        $this->crud->addField([ // select_from_array
            'name' => 'Device_Color',
            'label' => "Device Color",
            'type' => 'select_from_array',
            'options' => ['Black' => 'Black',
                'Silver' => 'Silver', 'Blue' => 'Blue', 'Green' => 'Green', 'Gold' => 'Gold',
                'Purple' => 'Purple', 'Pink' => "Pink", 'Grey' => 'Grey', 'White' => 'White'],
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-3',
            ],

        ]);

        CRUD::addField(['name' => 'Device_Password', 'type' => 'password', 'wrapper' => [

            'class' => 'col-md-3',
        ], 'attributes' => ['placeholder' => 'Enter The Password']]);

        CRUD::addField([ // Select2Multiple = n-n relationship (with pivot table)
            'label' => "Service",
            'type' => 'select2_multiple',
            'name' => 'service_fetch',

            // optional
            'entity' => 'service_fetch',

            'model' => "App\Models\Service",
            'attribute' => 's_name',
            'pivot' => true,
            'wrapper' => [

                'class' => 'col-md-6',
            ],

        ]);

        CRUD::addField([ // select_from_array
            'name' => 'Tags',
            'label' => "Tags",
            'type' => 'select_from_array',
            'options' => ['4GB DDR3 RAM' => '4GB DDR3 RAM',
                'Hynix DDR4 4GB RAM' => 'Hynix DDR4 4GB RAM', 'Hynix DDR4 8GB RAM' => 'Hynix DDR4 8GB RAM'],
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-6',
            ],

        ]);
        CRUD::addField(['name' => 'Service_Assessment',
            'label' => 'Service Assessment',
            'type' => 'tinymce']);

        $this->crud->addField([ // select_from_array
            'name' => 'Priority',
            'label' => "Priority",
            'type' => 'select_from_array',
            'options' => ['Regular' => 'Regular',
                'Critical' => 'Critical', 'Urgent' => 'Urgent'],

            'wrapper' => [

                'class' => 'col-md-3',
            ],

        ]);

        $Assignee = [ // Select
            'label' => "Assignee",
            'type' => 'select',
            'name' => 'Assignee',
            'entity' => 'check_assignees',
            'model' => "App\Models\User",
            'attribute' => 'name',
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-3',
            ],

        ];

        $this->crud->addField($Assignee);

        CRUD::addField(['name' => 'Initial_Quotation', 'type' => 'text', 'wrapper' => [

            'class' => 'col-md-3',
        ], 'attributes' => ['placeholder' => '2000-3000 etc']]);
        CRUD::addField(['name' => 'Due_Date', 'type' => 'date', 'wrapper' => [

            'class' => 'col-md-3',
        ]]);
        CRUD::addField(['name' => 'Dealer_Job_Id', 'type' => 'text', 'wrapper' => [

            'class' => 'col-md-3',
        ]]);
        CRUD::addField([
            'name' => 'Image',
            'label' => 'Image',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'public',
            'wrapper' => [

                'class' => 'col-md-12 ',
            ],
        ], 'both');
        CRUD::addField([ // Textarea
            'name' => 'Note',
            'label' => 'Note',
            'type' => 'textarea',
            'wrapper' => [

                'class' => 'col-md-8',
            ],
            'attributes' => ['placeholder' => 'Enter The Note'],
        ]);
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */

    protected function setupUpdateOperation()
    {

        if (backpack_user()->can('edit')) {
            CRUD::setValidation(JobsRequest::class);
            $cname = [ // Select
                'label' => "Customer Name",
                'type' => 'select',
                'name' => 'Customer_Name',
                'entity' => 'check_names',
                'model' => "App\Models\Customer",
                'attribute' => 'Name',

                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Customer_Name,
                'tab' => 'General',
            ];
            $this->crud->addField($cname);

            $source = [ // Select
                'label' => "Source",
                'type' => 'select',
                'name' => 'Source',
                'entity' => 'check_sources',
                'model' => "App\Models\Source",
                'attribute' => 'name',

                'wrapper' => [

                    'class' => ' col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Source,
                'tab' => 'General',

            ];

            $this->crud->addField($source);

            $service_type = [ // Select
                'label' => "Service Type",
                'type' => 'select',
                'name' => 'Service_Type',
                'entity' => 'check_services',
                'model' => "App\Models\ServiceType",
                'attribute' => 'name',

                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Service_Type,
                'tab' => 'General',
            ];

            $this->crud->addField($service_type);

            $this->crud->addField([ // select_from_array
                'name' => 'Job_Type',
                'label' => "Job Type",
                'type' => 'select_from_array',

                'options' => ['AMC' => 'AMC', 'No Warranty' => 'No Warranty', 'Returned' => 'Returned', 'Warranty' => 'Warranty'],
                'allows_null' => true,
                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'tab' => 'General',
            ]);

            $Device_Type = [ // Select
                'label' => "Device Type",
                'type' => 'select',
                'name' => 'Device_Type',
                'entity' => 'check_devices',
                'model' => "App\Models\DeviceType",
                'attribute' => 'name',
                'allows_null' => true,
                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Device_Type,
                'tab' => 'General',
            ];

            $this->crud->addField($Device_Type);

            $Device_Brand = [ // Select
                'label' => "Device Brand",
                'type' => 'select',
                'name' => 'Device_Brand',
                'entity' => 'check_device_brands',
                'model' => "App\Models\DeviceBrand",
                'attribute' => 'name',
                'allows_null' => true,
                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Device_Brand,
                'tab' => 'General',
            ];
            $this->crud->addField($Device_Brand);

            CRUD::addField(['name' => 'Device_Model', 'type' => 'text', 'label' => "Device Model",
                'wrapper' => [

                    'class' => ' col-md-3',
                ], 'attributes' => ['placeholder' => 'Enter The Device Model'],
                'tab' => 'General']);

            CRUD::addField(['name' => 'Serial_IMEI_Number', 'type' => 'text', 'label' => "Serial/IMEI Number",
                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'attributes' => ['placeholder' => 'Enter The Serial/IMEI_Number',
                ], 'tab' => 'General']);

            CRUD::addField(['name' => 'Accessories', 'type' => 'text',
                'wrapper' => [

                    'class' => ' col-md-3',
                ],
                'attributes' => ['placeholder' => 'Enter The Accessories',
                ], 'tab' => 'General']);

            $StorageLocation = [ // Select
                'label' => "Storage Location",
                'type' => 'select',
                'name' => 'Storage_Location',
                'entity' => 'check_storages',
                'model' => "App\Models\StorageLocation",
                'attribute' => 'name',
                'allows_null' => true,
                'wrapper' => [

                    'class' => ' col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Storage_Location
                , 'tab' => 'General',
            ];

            $this->crud->addField($StorageLocation);

            $this->crud->addField([ // select_from_array
                'name' => 'Device_Color',
                'label' => "Device Color",
                'type' => 'select_from_array',
                'options' => ['Black' => 'Black',
                    'Silver' => 'Silver', 'Blue' => 'Blue', 'Green' => 'Green', 'Gold' => 'Gold',
                    'Purple' => 'Purple', 'Pink' => "Pink", 'Grey' => 'Grey', 'White' => 'White'],
                'allows_null' => true,
                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'tab' => 'General',
            ]);

            CRUD::addField([ // Select2Multiple = n-n relationship (with pivot table)
                'label' => "Service",
                'type' => 'select2_multiple',
                'name' => 'service_fetch',

                // optional
                'entity' => 'service_fetch',

                'model' => "App\Models\Service",
                'attribute' => 's_name',
                'pivot' => true,
                'wrapper' => [

                    'class' => 'col-md-6',
                ],
                'tab' => 'General',

            ]);
            CRUD::addField([ // select_from_array
                'name' => 'Tags',
                'label' => "Tags",
                'type' => 'select_from_array',
                'options' => ['4GB DDR3 RAM' => '4GB DDR3 RAM',
                    'Hynix DDR4 4GB RAM' => 'Hynix DDR4 4GB RAM', 'Hynix DDR4 8GB RAM' => 'Hynix DDR4 8GB RAM'],
                'allows_null' => true,
                'wrapper' => [

                    'class' => ' col-6',
                ],
                'tab' => 'General',
            ]);
            CRUD::addField(['name' => 'Service_Assessment',
                'label' => 'Service Assessment',
                'type' => 'tinymce', 'tab' => 'General']);

            $this->crud->addField([ // select_from_array
                'name' => 'Priority',
                'label' => "Priority",
                'type' => 'select_from_array',
                'options' => ['Regular' => 'Regular',
                    'Critical' => 'Critical', 'Urgent' => 'Urgent'],

                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'tab' => 'General',
            ]);

            $Assignee = [ // Select
                'label' => "Assignee",
                'type' => 'select',
                'name' => 'Assignee',
                'entity' => 'check_assignees',
                'model' => "App\Models\User",
                'attribute' => 'name',
                'allows_null' => true,
                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Assignee,
                'tab' => 'General',
            ];

            $this->crud->addField($Assignee);

            CRUD::addField(['name' => 'Initial_Quotation', 'type' => 'text', 'wrapper' => [

                'class' => 'col-md-3',
            ], 'attributes' => ['placeholder' => '2000-3000 etc'], 'tab' => 'General']);
            CRUD::addField(['name' => 'Due_Date', 'type' => 'date', 'wrapper' => [

                'class' => 'col-md-3',
            ], 'tab' => 'General']);
            CRUD::addField(['name' => 'Dealer_Job_Id', 'type' => 'text', 'wrapper' => [

                'class' => 'col-md-3',
            ], 'tab' => 'General']);
            CRUD::addField([
                'name' => 'Image',
                'label' => 'Image',
                'type' => 'upload',
                'upload' => true,
                'disk' => 'public',
                'wrapper' => [

                    'class' => 'col-md-12 ',
                ], 'tab' => 'General',
            ], 'both');

            CRUD::addField([ // Textarea
                'name' => 'Note',
                'label' => 'Note',
                'type' => 'textarea',
                'wrapper' => [

                    'class' => 'col-md-8',
                ],
                'attributes' => ['placeholder' => 'Enter The Note'], 'tab' => 'Note',
            ]);

            $this->crud->addField([ // select_from_array
                'name' => 'Status',
                'label' => "Status",
                'type' => 'select_from_array',

                'options' => ['Completed' => 'Completed', 'Completed And Delivered' => 'Completed And Delivered'
                    , 'Awaiting Approval' => 'Awaiting Approval', 'In Process' => 'In Process', 'In Process' => 'In Process',
                    'Inward' => 'Inward',
                    'In Process' => 'In Process', 'In Process' => 'In Process',
                    'In Process' => 'In Process',
                    'On Hold' => 'On Hold', 'Outsourced' => 'Outsourced',
                    'Cancelled' => 'Cancelled',
                    'Cancelled And Delivered' => 'Cancelled And Delivered', 'Returned-Awaiting Approval' => 'Returned-Awaiting Approval', 'Returned -In Process' => 'Returned -In Process'],
                'allows_null' => true,
                'wrapper' => [

                    'class' => 'col-md-6',
                ],
                'tab' => 'Status',
            ]);
        } else {

            $cname = [ // Select
                'label' => "Customer Name",
                'type' => 'select',
                'name' => 'Customer_Name',
                'entity' => 'check_names',
                'model' => "App\Models\Customer",
                'attribute' => 'Name',

                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Customer_Name,

                'attributes' => ['disabled' => 'disabled'],
                'tab' => 'General',

            ];
            $this->crud->addField($cname);

            $source = [ // Select
                'label' => "Source",
                'type' => 'select',
                'name' => 'Source',
                'entity' => 'check_sources',
                'model' => "App\Models\Source",
                'attribute' => 'name',

                'wrapper' => [

                    'class' => ' col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Source,
                'attributes' => ['disabled' => 'disabled'],
                'tab' => 'General',

            ];

            $this->crud->addField($source);

            $service_type = [ // Select
                'label' => "Service Type",
                'type' => 'select',
                'name' => 'Service_Type',
                'entity' => 'check_services',
                'model' => "App\Models\ServiceType",
                'attribute' => 'name',

                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Service_Type,
                'attributes' => ['disabled' => 'disabled'],
                'tab' => 'General',
            ];

            $this->crud->addField($service_type);

            $this->crud->addField([ // select_from_array
                'name' => 'Job_Type',
                'label' => "Job Type",
                'type' => 'select_from_array',

                'options' => ['AMC' => 'AMC', 'No Warranty' => 'No Warranty', 'Returned' => 'Returned', 'Warranty' => 'Warranty'],
                'allows_null' => true,
                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'attributes' => ['disabled' => 'disabled'],
                'tab' => 'General',

            ]);

            $Device_Type = [ // Select
                'label' => "Device Type",
                'type' => 'select',
                'name' => 'Device_Type',
                'entity' => 'check_devices',
                'model' => "App\Models\DeviceType",
                'attribute' => 'name',
                'allows_null' => true,
                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Device_Type,
                'attributes' => ['disabled' => 'disabled'],
                'tab' => 'General',
            ];

            $this->crud->addField($Device_Type);

            $Device_Brand = [ // Select
                'label' => "Device Brand",
                'type' => 'select',
                'name' => 'Device_Brand',
                'entity' => 'check_device_brands',
                'model' => "App\Models\DeviceBrand",
                'attribute' => 'name',
                'allows_null' => true,
                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Device_Brand,
                'attributes' => ['disabled' => 'disabled'],
                'tab' => 'General',
            ];
            $this->crud->addField($Device_Brand);

            CRUD::addField(['name' => 'Device_Model', 'type' => 'text', 'label' => "Device Model",
                'wrapper' => [

                    'class' => ' col-md-3',
                ], 'attributes' => ['placeholder' => 'Enter The Device Model', 'readonly' => 'readonly'],
                'tab' => 'General']);

            CRUD::addField(['name' => 'Serial_IMEI_Number', 'type' => 'text', 'label' => "Serial/IMEI Number",
                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'attributes' => ['placeholder' => 'Enter The Serial/IMEI_Number',

                    'readonly' => 'readonly',

                ], 'tab' => 'General']);

            CRUD::addField(['name' => 'Accessories', 'type' => 'text',
                'wrapper' => [

                    'class' => ' col-md-3',
                ],
                'attributes' => ['placeholder' => 'Enter The Accessories',
                    'readonly' => 'readonly',

                ], 'tab' => 'General']);

            $StorageLocation = [ // Select
                'label' => "Storage Location",
                'type' => 'select',
                'name' => 'Storage_Location',
                'entity' => 'check_storages',
                'model' => "App\Models\StorageLocation",
                'attribute' => 'name',
                'allows_null' => true,
                'wrapper' => [

                    'class' => ' col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Storage_Location,
                'attributes' => ['disabled' => 'disabled'],
                'tab' => 'General',
            ];

            $this->crud->addField($StorageLocation);

            $this->crud->addField([ // select_from_array
                'name' => 'Device_Color',
                'label' => "Device Color",
                'type' => 'select_from_array',
                'options' => ['Black' => 'Black',
                    'Silver' => 'Silver', 'Blue' => 'Blue', 'Green' => 'Green', 'Gold' => 'Gold',
                    'Purple' => 'Purple', 'Pink' => "Pink", 'Grey' => 'Grey', 'White' => 'White'],
                'allows_null' => true,
                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'attributes' => ['disabled' => 'disabled'],
                'tab' => 'General',

            ]);

            CRUD::addField([ // Select2Multiple = n-n relationship (with pivot table)
                'label' => "Service",
                'type' => 'select2_multiple',
                'name' => 'service_fetch',

                // optional
                'entity' => 'service_fetch',

                'model' => "App\Models\Service",
                'attribute' => 's_name',
                'pivot' => true,
                'wrapper' => [

                    'class' => 'col-md-6',
                ],
                'tab' => 'General',
                'attributes' => ['placeholder' => 'Enter The service', 'disabled' => 'disabled'],

            ]);
            CRUD::addField([ // select_from_array
                'name' => 'Tags',
                'label' => "Tags",
                'type' => 'select_from_array',
                'options' => ['4GB DDR3 RAM' => '4GB DDR3 RAM',
                    'Hynix DDR4 4GB RAM' => 'Hynix DDR4 4GB RAM', 'Hynix DDR4 8GB RAM' => 'Hynix DDR4 8GB RAM'],
                'allows_null' => true,
                'wrapper' => [

                    'class' => ' col-6',
                ], 'attributes' => ['disabled' => 'disabled'],
                'tab' => 'General',

            ]);

            CRUD::addField(['name' => 'Service_Assessment',
                'type' => 'view',
                'view' => "service_assessment", 'tab' => 'General']);

            $this->crud->addField([ 
                'name' => 'Priority',
                'label' => "Priority",
                'type' => 'select_from_array',
                'options' => ['Regular' => 'Regular',
                    'Critical' => 'Critical', 'Urgent' => 'Urgent'],

                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'attributes' => ['disabled' => 'disabled'], 'tab' => 'General',
            ]);

            $Assignee = [ // Select
                'label' => "Assignee",
                'type' => 'select',
                'name' => 'Assignee',
                'entity' => 'check_assignees',
                'model' => "App\Models\User",
                'attribute' => 'name',
                'allows_null' => true,
                'wrapper' => [

                    'class' => 'col-md-3',
                ],
                'default' => $this->crud->getCurrentEntry()->Assignee,
                'attributes' => ['disabled' => 'disabled'],
                'tab' => 'General',
            ];

            $this->crud->addField($Assignee);

            CRUD::addField(['name' => 'Initial_Quotation', 'type' => 'text', 'wrapper' => [

                'class' => 'col-md-3',
            ], 'attributes' => ['placeholder' => '2000-3000 etc', 'disabled' => 'disabled'], 'tab' => 'General']);
            CRUD::addField(['name' => 'Due_Date', 'type' => 'date', 'wrapper' => [

                'class' => 'col-md-3',

            ], 'attributes' => ['disabled' => 'disabled'], 'tab' => 'General']);
            CRUD::addField(['name' => 'Dealer_Job_Id', 'type' => 'text', 'wrapper' => [

                'class' => 'col-md-3',

            ], 'attributes' => ['disabled' => 'disabled'], 'tab' => 'General']);
            // CRUD::addField([
            //     'name' => 'Image',
            //     'label' => 'Image',
            //     'type' => 'upload',
            //     'upload' => true,
            //     'disk' => 'public',
            //     'wrapper' => [

            //         'class' => 'col-md-12 ',
            //     ],
            //     'attributes' => ['disabled' => 'disabled']
            // ], 'both');

            CRUD::addField(['name' => 'Image',
                'type' => 'view',
                'view' => "image", 'wrapper' => [
                    'class' => 'col-md-12 ',
                ], 'tab' => 'General']);

            CRUD::addField([ // Textarea
                'name' => 'Note',
                'label' => 'Note',
                'type' => 'textarea',
                'wrapper' => [

                    'class' => 'col-md-8',
                ],
                'attributes' => ['placeholder' => 'Enter The Note'], 'tab' => 'Note',
            ]);

            $this->crud->addField([ // select_from_array
                'name' => 'Status',
                'label' => "Status",
                'type' => 'select_from_array',

                'options' => ['Completed' => 'Completed', 'Completed And Delivered' => 'Completed And Delivered'
                    , 'Awaiting Approval' => 'Awaiting Approval', 'In Process' => 'In Process', 'In Process' => 'In Process',
                    'Inward' => 'Inward',
                    'In Process' => 'In Process', 'In Process' => 'In Process',
                    'In Process' => 'In Process',
                    'On Hold' => 'On Hold', 'Outsourced' => 'Outsourced',
                    'Cancelled' => 'Cancelled',
                    'Cancelled And Delivered' => 'Cancelled And Delivered', 'Returned-Awaiting Approval' => 'Returned-Awaiting Approval', 'Returned -In Process' => 'Returned -In Process'],
                'allows_null' => true,
                'wrapper' => [

                    'class' => 'col-md-6',
                ],
                'attributes' => ['disabled' => 'disabled'], 'tab' => 'Status',
            ]);

        }
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */

    }

    protected function setupShowOperation()
    {
        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'description',
            'label' => 'Search',
        ],
            false,
            function ($value) { // if the filter is active

                if (Customer::where("Name", 'LIKE', "%$value%")->exists()) {
                    $data = Customer::where("Name", 'LIKE', "%$value%")->get();
                    $id = $data[0]["id"];
                    $this->crud->query->where('Customer_Name', "$id");
                }
            });

        $this->crud->addFilter([
            'type' => 'date',
            'name' => 'date',
            'label' => 'Date',
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $this->crud->query->where('Due_Date', $value);
            });

        $this->crud->addFilter([
            'type' => 'date_range',
            'name' => 'from_to',
            'label' => 'Date range',
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'Due_Date', '>=', $dates->from);
                $this->crud->addClause('where', 'Due_Date', '<=', $dates->to . ' 23:59:59');
            });

        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'dropdown',
            'label' => 'Status',
        ], [
            'AMC' => 'AMC',
            'No Warranty' => 'No Warranty',
            'Returned' => 'Returned',
            'Warranty' => 'Warranty',

        ], function ($value) { // if the filter is active
            $this->crud->addClause('where', 'Job_Type', $value);
        });

        $this->crud->addFilter([
            'name' => 'number',
            'type' => 'range',
            'label' => 'Range',
            'label_from' => 'min value',
            'label_to' => 'max value',
        ],
            false,
            function ($value) { // if the filter is active
                $range = json_decode($value);
                if ($range->from) {
                    $this->crud->addClause('where', 'id', '>=', (float) $range->from);
                }
                if ($range->to) {
                    $this->crud->addClause('where', 'id', '<=', (float) $range->to);
                }
            });

        if (backpack_user()->hasRole('staff')) {

            $this->crud->addClause('whereHas', 'check_assigner', function ($query) {
                $query->where('id', "=", backpack_user()->id);

                CRUD::addColumn(['name' => 'Customer_Name', 'type' => 'model_function',
                    'function_name' => 'check_name']);

                CRUD::addColumn(['name' => 'Source', 'type' => 'model_function',
                    'function_name' => 'check_source']);

                CRUD::addColumn(['name' => 'Service_Type', 'type' => 'model_function',
                    'function_name' => 'check_service']);

                CRUD::column('Job_Type')->type('text');

                CRUD::addColumn(['name' => 'Device_Type', 'type' => 'model_function',
                    'function_name' => 'check_device']);

                CRUD::addColumn(['name' => 'Assignee ', 'type' => 'model_function',
                    'function_name' => 'check_assignee']);

                CRUD::addColumn(['name' => 'Device_Brand', 'type' => 'model_function',
                    'function_name' => 'check_device_brand']);
                CRUD::column('Device_Model')->type('text');
                CRUD::column('Serial_IMEI_Number')->type('text');
                CRUD::column('Accessories')->type('text');

                CRUD::addColumn(['name' => 'Storage_Location', 'type' => 'model_function',
                    'function_name' => 'check_storage']);

                CRUD::column('Device_Color')->type('text');

                CRUD::column('Device_Password')->type('text');
                CRUD::addColumn(['name' => 'service_fetch', 'label' => 'service']);
                CRUD::addcolumn(['name' => 'service_fetch']);
                CRUD::column('Tags')->type('text');

                CRUD::addColumn(['name' => 'Service_Assessment ', 'type' => 'model_function',
                    'function_name' => 'check_service_assessment']);

                CRUD::column('Priority')->type('text');

                CRUD::column('Initial_Quotation')->type('text');

                CRUD::column('Due_Date')->type('text');

                CRUD::column('Dealer_Job_Id')->type('text');

                $this->crud->addColumn(
                    [
                        'name' => 'Image', // The db column name
                        'label' => 'Image', // Table column heading
                        'type' => 'image',
                        'prefix' => 'image/',
                        'height' => '100px',
                        'width' => '100px',

                    ]);

                CRUD::column('created_at')->type('text');
            });

        } else {

            CRUD::addColumn(['name' => 'Customer_Name', 'type' => 'model_function',
                'function_name' => 'check_name']);

            CRUD::addColumn(['name' => 'Source', 'type' => 'model_function',
                'function_name' => 'check_source']);

            CRUD::addColumn(['name' => 'Service_Type', 'type' => 'model_function',
                'function_name' => 'check_service']);

            CRUD::column('Job_Type')->type('text');

            CRUD::addColumn(['name' => 'Device_Type', 'type' => 'model_function',
                'function_name' => 'check_device']);

            CRUD::addColumn(['name' => 'Assignee ', 'type' => 'model_function',
                'function_name' => 'check_assignee']);

            CRUD::addColumn(['name' => 'Device_Brand', 'type' => 'model_function',
                'function_name' => 'check_device_brand']);
            CRUD::column('Device_Model')->type('text');
            CRUD::column('Serial_IMEI_Number')->type('text');
            CRUD::column('Accessories')->type('text');

            CRUD::addColumn(['name' => 'Storage_Location', 'type' => 'model_function',
                'function_name' => 'check_storage']);

            CRUD::column('Device_Color')->type('text');

            CRUD::column('Device_Password')->type('text');
            CRUD::addcolumn(['name' => 'service_fetch', 'label' => 'Service']);
            CRUD::column('Tags')->type('text');

            CRUD::addColumn(['name' => 'Service_Assessment ', 'type' => 'model_function',
                'function_name' => 'check_service_assessment']);

            CRUD::column('Priority')->type('text');

            CRUD::column('Initial_Quotation')->type('text');

            CRUD::column('Due_Date')->type('text');

            CRUD::column('Dealer_Job_Id')->type('text');

            $this->crud->addColumn(
                [
                    'name' => 'Image', // The db column name
                    'label' => 'Image', // Table column heading
                    'type' => 'image',
                    'prefix' => 'image/',
                    'height' => '100px',
                    'width' => '100px',

                ]);

            CRUD::column('created_at')->type('text');
        }
        // //     CRUD::column('updated_at')->type('text');
        // /**
        //  * Columns can be defined using the fluent syntax or array syntax:
        //  * - CRUD::column('price')->type('number');
        //  * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
        //  */

    }
}
