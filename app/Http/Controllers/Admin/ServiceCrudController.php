<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ServiceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ServiceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ServiceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Service::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/service');
        CRUD::setEntityNameStrings('service', 'services');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
       
  

        CRUD::addColumn(['name' => 'd_type','type' => 'model_function',
        'function_name' => 'check_device','label'=>'Device Type']);
        CRUD::addColumn(['name' => 's_name', 'type' => 'text','label'=>'Service Name']);
        CRUD::addColumn(['name' => 'price', 'type' => 'text','label'=>'Price']);
        CRUD::addColumn(['name' => 'rate', 'type' => 'text','label'=>'Rate']);
        CRUD::addColumn(['name' => 'tax', 'type' => 'text','label'=>'Tax']);
        CRUD::addColumn(['name' => 'tax_code', 'type' => 'text','label'=>'Tax_Code']);
        
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ServiceRequest::class);

        $Device_Type = [ // Select
            'label' => "Device Type",
            'type' => 'select2',
            'name' => 'd_type',
            'entity' => 'check_devices',
            'model' => "App\Models\DeviceType",
            'attribute' => 'name',
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-6',
            ],

        ];

        $this->crud->addField($Device_Type);



        CRUD::addField(['name' => 's_name', 'type' => 'text','label' => "Service Name",
            'wrapper' => [

                'class' => 'col-md-6',
            ],
            'attributes' => ['placeholder' => 'Enter The Service Name',
            ]]);
      
      


        CRUD::addField(['name' => 'price', 'type' => 'text','label' => "Price",
        'wrapper' => [

            'class' => 'col-md-4',
        ],
        'attributes' => ['placeholder' => 'Enter The Price',
        ]]);
  
   
    
        CRUD::addField(['name' => 'tax',
        'label' => "tax",
        'type' => 'select_from_array',
        'options' => ['GST 18%' => 'GST 18%',
            'IGST 18%' => 'IGST 18%'],
       
        'wrapper' => [

            'class' => 'col-md-4',
        ]
        ]);
       

        CRUD::addField(['name' => 'tax_code', 'type' => 'text','label' => "tax code",
        'wrapper' => [

            'class' => 'col-md-4',
        ],
        'attributes' => ['placeholder' => 'Enter The tax code',
        ]]);


        $this->crud->addField([
            'name' => 'rate',
            'label' => 'Rate Including Tax',
            'type' => 'checkbox',
            'wrapper' => [

                'class' => 'col-md-4 mt-5',
            ],
        ]);
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
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
        CRUD::setValidation(ServiceRequest::class);

        $Device_Type = [ // Select
            'label' => "Device Type",
            'type' => 'select2',
            'name' => 'd_type',
            'entity' => 'check_devices',
            'model' => "App\Models\DeviceType",
            'attribute' => 'name',
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-6',
            ],

        ];

        $this->crud->addField($Device_Type);



        CRUD::addField(['name' => 's_name', 'type' => 'text','label' => "Service Name",
            'wrapper' => [

                'class' => 'col-md-6',
            ],
            'attributes' => ['placeholder' => 'Enter The Service Name',
            ]]);
      
      


        CRUD::addField(['name' => 'price', 'type' => 'text','label' => "Price",
        'wrapper' => [

            'class' => 'col-md-4',
        ],
        'attributes' => ['placeholder' => 'Enter The Price',
        ]]);
  
   
    
        CRUD::addField(['name' => 'tax',
        'label' => "tax",
        'type' => 'select_from_array',
        'options' => ['GST 18%' => 'GST 18%',
            'IGST 18%' => 'IGST 18%'],
       
        'wrapper' => [

            'class' => 'col-md-4',
        ]
        ]);
       

        CRUD::addField(['name' => 'tax_code', 'type' => 'text','label' => "tax code",
        'wrapper' => [

            'class' => 'col-md-4',
        ],
        'attributes' => ['placeholder' => 'Enter The tax code',
        ]]);


        $this->crud->addField([
            'name' => 'rate',
            'label' => 'Rate Including Tax',
            'type' => 'checkbox',
            'wrapper' => [

                'class' => 'col-md-4 mt-5',
            ],
        ]);
    }

    protected function setupShowOperation()
    {
       
  

        CRUD::addColumn(['name' => 'd_type','type' => 'model_function',
        'function_name' => 'check_device']);
        CRUD::addColumn(['name' => 's_name', 'type' => 'text','label'=>'Service Name']);
        CRUD::addColumn(['name' => 'price', 'type' => 'text','label'=>'Price']);
        CRUD::addColumn(['name' => 'rate', 'type' => 'text','label'=>'Rate']);
        CRUD::addColumn(['name' => 'tax', 'type' => 'text','label'=>'Tax']);
        CRUD::addColumn(['name' => 'tax_code', 'type' => 'text','label'=>'Tax_Code']);
        
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

}
