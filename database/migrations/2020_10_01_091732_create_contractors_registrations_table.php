<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorsRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('experience_level');
            $table->string('experience_level_value');
            $table->string('age_proof')->nullable();
            $table->string('type_of_work_exp')->nullable();
            $table->string('address');
            $table->string('cv')->nullable();
            $table->string('job_reference')->nullable();
            $table->string('available_equipments')->nullable();
            $table->string('company_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('insurance_document')->nullable();
            $table->tinyInteger('has_smartphone')->nullable();
            $table->string('type_of_transport');
            $table->string('charge_rate')->nullable();
            $table->string('charge_type')->nullable();
            $table->tinyInteger('has_callout_fee')->nullable();
            $table->string('callout_fee_value')->nullable();
            $table->string('rate_of_green_waste')->nullable();
            $table->string('green_waste_collection_method')->nullable();
            $table->string('social_profile')->nullable();
            $table->string('website_address')->nullable();
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
        Schema::dropIfExists('contractors_regestrations');
    }
}
