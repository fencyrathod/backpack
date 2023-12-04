<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CustomerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CustomerCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Customer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customer');
        CRUD::setEntityNameStrings('customer', 'customers');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if(backpack_user()->hasRole('staff'))
        {
            CRUD::column('Name');
            CRUD::column('Email');
            CRUD::column('Address');
            CRUD::column('City');
            CRUD::column('Phone');
            $this->crud->removeButton('update');
            
        }
        else
        {
            CRUD::column('Name');
            CRUD::column('Email');
            CRUD::column('Address');
            CRUD::column('City');
            CRUD::column('Phone');
        }

        
        //$this->crud->removeButton('create');
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
        CRUD::setValidation(CustomerRequest::class);

        CRUD::addField(['name' => 'Name', 'type' => 'text',
        'wrapper'   => [
      
            'class' => 'form-group col-4',
         ]]); 

        CRUD::addField(['name' => 'Email', 'type' => 'text',
        'wrapper'   => [
      
            'class' => 'form-group col-4',
         ]]); 
        CRUD::addField(['name' => 'Phone', 'type' => 'text',
        'wrapper'   => [
      
            'class' => 'form-group col-4',
         ]]); 

        CRUD::addField(['name' => 'Address', 'type' => 'text',
        'wrapper'   => [
      
            'class' => 'form-group col-4',
         ]]); 
       
        
        CRUD::addField(['name' => 'City', 'type' => 'text',
        'wrapper'   => [
      
            'class' => 'form-group col-4',
         ]]); 
         CRUD::addField([
            'name'        => 'Gender',
            'label'       => 'Gender',
            'type'        => 'radio',
            'options'     => [  'Male'=> "Male", 'Female' => "Female"
                             ],
                             'inline' => true, 
                             'wrapper'   => [
      
                                'class' => 'form-group col-4',
                             ]
                            
        ]);

        CRUD::addField(['name' => 'State', 'type' => 'text',
        'wrapper'   => [
      
            'class' => 'form-group col-4',
         ]]); 
        CRUD::addField(['name' => 'Zipcode', 'type' => 'text',
        'wrapper'   => [
      
            'class' => 'form-group col-4',
         ]]); 

        CRUD::addField(['name' => 'Password', 'type' => 'password',
        'wrapper'   => [
      
            'class' => 'form-group col-4',
         ]]);
      

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
       
        CRUD::field('Name');
        CRUD::field('Email');
        CRUD::field('Phone');
        CRUD::field('City');
        CRUD::field('State');
        CRUD::field('Zipcode');
       
        
    }

    protected function setupShowOperation()
    {
      
     

        if(backpack_user()->hasRole('staff'))
        {
            CRUD::column('Name');
            CRUD::column('Email');
            CRUD::column('Address');
            CRUD::column('City');
            CRUD::column('Phone');   
            CRUD::column('Email');
            CRUD::column('Phone');
            CRUD::column('Address');
            CRUD::column('City');
            CRUD::column('Gender');
            CRUD::column('State');
            CRUD::column('Zipcode');
            $this->crud->removeButton( 'preview' );
            $this->crud->removeButton( 'update' );
            $this->crud->removeButton( 'revisions' );
            $this->crud->removeButton( 'delete' );
        }
        else
        {
            CRUD::column('Name');
            CRUD::column('Email');
            CRUD::column('Phone');
            CRUD::column('Address');
            CRUD::column('City');
            CRUD::column('Gender');
            CRUD::column('State');
            CRUD::column('Zipcode');
            CRUD::column('Phone');
        }
    }
}
