<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersRegistrationsProbertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_registrations_properties', function (Blueprint $table) {
            $table->id();
            $table->string('work_location');
            $table->string('type_of_work');
            $table->string('location');
            $table->text('location_coordinates');
            $table->string('property_size');
            $table->string('site_details')->nullable();
            $table->boolean('is_parking_access')->default(false);
            $table->text('area_coordinates');
            $table->text('services_types_json');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('customers_registrations_properties');
    }
}
