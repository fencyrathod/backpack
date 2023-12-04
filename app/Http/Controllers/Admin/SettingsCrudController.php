<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettingsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SettingsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SettingsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Settings::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/settings');
        CRUD::setEntityNameStrings('settings', 'settings');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
      

        $this->crud->addColumn(
            [
                'name' => 'logo', 
                'label' => 'Logo', 
                'type' => 'image',
                'prefix' => 'http://127.0.0.1:8000/logo/',
                'height' => '100px',
                'width' => '100px',

            ]);
        CRUD::column('created_at');
      

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
        CRUD::setValidation(SettingsRequest::class);

        CRUD::addField(['name' => 'shop_name', 'type' => 'text','label'=>'Shop Name','wrapper' => [

            'class' => 'col-md-3',
        ],'attributes' => ['placeholder' => 'Enter The Shop Name']]);

        CRUD::addField(['name' => 'address', 'type' => 'text','label'=>'Address','wrapper' => [

            'class' => 'col-md-3',
        ],'attributes' => ['placeholder' => 'Enter The Address']]);
        CRUD::addField(['name' => 'city', 'type' => 'text','label'=>'City','wrapper' => [

            'class' => 'col-md-3',
        ],'attributes' => ['placeholder' => 'Enter The City']]);
        CRUD::addField(['name' => 'state', 'type' => 'text','label'=>'State','wrapper' => [

            'class' => 'col-md-3',
        ],'attributes' => ['placeholder' => 'Enter The State']]);
        CRUD::addField(['name' => 'pincode', 'type' => 'text','label'=>'Pincode','wrapper' => [

            'class' => 'col-md-3',
        ],'attributes' => ['placeholder' => 'Enter The Pincode']]);
        CRUD::addField(['name' => 'phone', 'type' => 'text','label'=>'Phone','wrapper' => [

            'class' => 'col-md-3',
        ],'attributes' => ['placeholder' => 'Enter The Phone']]);
        CRUD::addField(['name' => 'email', 'type' => 'text','label'=>'Email','wrapper' => [

            'class' => 'col-md-3',
        ],'attributes' => ['placeholder' => 'Enter The Email']]);

        CRUD::addField(['name' => 'gst_no', 'type' => 'text','label'=>'Gst No','wrapper' => [

            'class' => 'col-md-3',
        ],'attributes' => ['placeholder' => 'Enter The Gst No']]);
        CRUD::addField(['name' => 'account_name', 'type' => 'text','label'=>'Account Name','wrapper' => [

            'class' => 'col-md-3',
        ],'attributes' => ['placeholder' => 'Enter The Account Name']]);
        CRUD::addField(['name' => 'bank_name', 'type' => 'text','label'=>'Bank Name','wrapper' => [

            'class' => 'col-md-3',
        ],'attributes' => ['placeholder' => 'Enter The Bank Name']]);
        CRUD::addField(['name' => 'account_no', 'type' => 'text','label'=>'Account No','wrapper' => [

            'class' => 'col-md-4',
        ],'attributes' => ['placeholder' => 'Enter The Account No']]);
        CRUD::addField(['name' => 'ifsc_no', 'type' => 'text','label'=>'Ifsc No','wrapper' => [

            'class' => 'col-md-4',
        ],'attributes' => ['placeholder' => 'Enter The Ifsc No']]);
      
        CRUD::addField([
            'name' => 'logo',
            'label' => 'Logo',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'logo',
            'wrapper' => [

                'class' => 'col-md-4',
            ],
        ], 'both');
     

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
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        CRUD::column('shop_name');
        CRUD::column('address');
        CRUD::column('city');
        CRUD::column('state');
        CRUD::column('pincode');
        CRUD::column('phone');
        CRUD::column('email');
        CRUD::column('gst_no');
        CRUD::column('account_name');
        CRUD::column('bank_name');
        CRUD::column('account_no');
        CRUD::column('ifsc_no');
        $this->crud->addColumn(
            [
                'name' => 'logo', // The db column name
                'label' => 'Logo', // Table column heading
                'type' => 'image',
                'prefix' => 'http://127.0.0.1:8000/logo/',
                'height' => '100px',
                'width' => '100px',

            ]);
        CRUD::column('created_at');
      

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }
}
