<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_enquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->string('customer_name',255);
            $table->string('customer_phone',255)->nullable();
            $table->string('customer_phone_international',255)->nullable();
            $table->string('customer_email',255)->nullable();
            $table->string('customer_address',255)->nullable();
            $table->string('enquiry',2000);
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
        Schema::dropIfExists('general_enquiries');
    }
}
