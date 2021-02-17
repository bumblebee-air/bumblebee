<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('work_location', '255')->nullable();
            $table->string('type_of_work', '255')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('type', '255')->nullable();
            $table->string('name', '255')->nullable();
            $table->string('contact_through', '255');
            $table->string('phone_number', '255')->nullable();
            $table->string('service_types', '800')->nullable();
            $table->string('location', '255')->nullable();
            $table->string('location_coordinates', '100')->nullable();
            $table->string('property_size', '100')->nullable();
            $table->string('property_photo', '255')->nullable();
            $table->tinyInteger('is_first_time')->nullable();
            $table->string('last_service', '500')->nullable();
            $table->string('site_details', 500)->nullable();
            $table->tinyInteger('is_parking_access')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('available_date_time')->nullable();
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
        Schema::dropIfExists('customers_registrations');
    }
}
