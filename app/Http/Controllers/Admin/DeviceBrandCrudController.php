<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DeviceBrandRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DeviceBrandCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DeviceBrandCrudController extends CrudController
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
        CRUD::setModel(\App\Models\DeviceBrand::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/device-brand');
        CRUD::setEntityNameStrings('device brand', 'device brands');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        
        CRUD::column('id');
        CRUD::column('name')->type('text');
        CRUD::column('created_at')->type('text');
        CRUD::column('updated_at')->type('text');
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
        CRUD::setValidation(DeviceBrandRequest::class);

        CRUD::addField(['name' => 'name', 'type' => 'text', 
        'wrapper'   => [
           'class' => 'form-group col-4',
        ]]);


        $source = [ // Select
            'label' => "Device Type",
            'type' => 'select',
            'name' => 'device_type_id',
            'entity' => 'type',
            'model' => "App\Models\DeviceBrand",
            'attribute' => 'name',
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-3',
            ],

        ];

        $this->crud->addField($source);
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
        CRUD::setValidation(DeviceBrandRequest::class);

        CRUD::addField(['name' => 'name', 'type' => 'text', 
        'wrapper'   => [
           'class' => 'form-group col-4',
        ]]);


        $source = [ // Select
            'label' => "Device Type",
            'type' => 'select',
            'name' => 'device_type_id',
            'entity' => 'device_brand',
            'model' => "App\Models\DeviceBrand",
            'attribute' => 'name',
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-3',
            ],
            'default' => $this->crud->getCurrentEntry()->device_type_id,

        ];

        $this->crud->addField($source);
    }
}
