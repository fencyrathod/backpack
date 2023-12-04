<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaymentRequest;
use App\Models\Customer;
use App\Models\Jobs;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class PaymentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PaymentCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Payment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/payment');
        CRUD::setEntityNameStrings('payment', 'payments');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'customer_id', 'type' => 'model_function',
            'function_name' => 'check_name', 'label' => 'Customer Name']);

        CRUD::addColumn(['name' => 'assign_id', 'type' => 'model_function',
            'function_name' => 'check_assignee']);

        CRUD::column('payment_mode');
        CRUD::column('amount');
      

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

        CRUD::setValidation(PaymentRequest::class);
        $id = $_REQUEST['id'] ?? null;

        if ($id) {
            $data = Jobs::find($id);

            $customer = Customer::find($data->Customer_Name);
            $user = User::find($data->Assignee);
            $print = array(
                "c_name" => $customer->Name,
                "Assign_user" => $user->name,
            );

            $data = view("payment_detail", ["print" => $print]);
            Widget::add([
                'type' => 'payments',
                'content' => $data,
            ]);
        }

        $id = $_REQUEST['id'] ?? null;

        $datas = Jobs::find($id);
        $c_id = $datas->Customer_Name ?? null;
        $a_id = $datas->Assignee ?? null;

        CRUD::addField(['name' => 'job_id', 'type' => 'hidden', 'value' => $id]);
        CRUD::addField(['name' => 'customer_id', 'type' => 'hidden', 'value' => $c_id]);
        CRUD::addField(['name' => 'assign_id', 'type' => 'hidden', 'value' => $a_id]);
        $this->crud->addField([ // select_from_array
            'name' => 'payment_mode',
            'label' => "Payment Mode",
            'type' => 'select_from_array',

            'options' => ['Cash' => 'Cash', 'Cheque' => 'Cheque', 'Online' => 'Online'],
            'allows_null' => true,
            'wrapper' => [

                'class' => 'col-md-4',
            ],

        ]);
        CRUD::addField(['name' => 'amount', 'type' => 'text', 'wrapper' => [

            'class' => 'col-md-4',
        ],'attributes' => [
            'placeholder' => 'Enter The Amount',
        ]]);

   

        $id = $_REQUEST['id'] ?? null;

        $data = Jobs::find($id);

        $user = User::find($data->Assignee ?? null);

        $assign_name = $user->name ?? null;
        CRUD::addField(['name' => 'Assign_name', 'type' => 'text', 'value' => $assign_name, 'attributes' => [
            'readonly' => 'readonly',
        ], 'wrapper' => [

            'class' => 'col-md-4',
        ]]);

        CRUD::addField(['name' => 'comments',
            'label' => 'Comment',
            'type' => 'tinymce', 'wrapper' => [

                'class' => 'col-md-12',
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
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        CRUD::addColumn(['name' => 'customer_id', 'type' => 'model_function',
            'function_name' => 'check_name', 'label' => 'Customer Name']);

        CRUD::addColumn(['name' => 'assign_id', 'type' => 'model_function',
            'function_name' => 'check_assignee']);

        CRUD::column('payment_mode');
        CRUD::column('amount');
      

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }
}
