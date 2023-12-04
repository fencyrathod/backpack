<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string("shop_name");
            $table->string("address");
            $table->string("city");
            $table->string("state");
            $table->string("pincode");
            $table->string("phone");
            $table->string("email");
            $table->string("account_name");
            $table->string("bank_name");
            $table->string("account_no");
            $table->string("ifsc_no");
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
        Schema::dropIfExists('settings');
    }
}
