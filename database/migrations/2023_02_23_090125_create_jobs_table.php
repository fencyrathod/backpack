<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string("Customer_Name");
            $table->string("Source");
            $table->string("Service_Type");
            $table->string("Job_Type");
            $table->string("Device_Type");
            $table->string("Device_Brand");
            $table->string("Device_Model");
            $table->string("Serial_IMEI_Number");
            $table->string("Accessories");
            $table->string("Storage_Location");
            $table->string("Device_Color");
            $table->string("Device_Password");
            $table->string("Services");
            $table->string("Tags");
            $table->string("Service_Assessment");
            $table->string("Priority");
            $table->string("Assignee");
            $table->string("Initial_Quotation");
            $table->string("Due_Date");
            $table->string("Dealer_Job_Id");
            $table->string("Image");
            $table->string("Note");
            $table->timestamps();

           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}


