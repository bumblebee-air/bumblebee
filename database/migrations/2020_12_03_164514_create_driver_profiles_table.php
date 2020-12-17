<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id',false,true);
            $table->string('first_name',20)->nullable();
            $table->string('last_name',20)->nullable();
            $table->string('contact_channel',20)->nullable();
            $table->string('dob',20)->nullable();
            $table->string('address',255)->nullable();
            $table->string('address_coordinates',30)->nullable();
            $table->string('postcode',10)->nullable();
            $table->string('country',20)->nullable();
            $table->string('pps_number',50)->nullable();
            $table->string('emergency_contact_name',50)->nullable();
            $table->string('emergency_contact_number',50)->nullable();
            $table->string('transport',20)->nullable();
            $table->string('max_package_size',20)->nullable();
            $table->string('max_package_weight',20)->nullable();
            $table->string('work_location',100)->nullable();
            $table->string('work_radius',50)->nullable();
            $table->string('legal_word_evidence',255)->nullable();
            $table->string('driver_license',255)->nullable();
            $table->string('insurance_proof',255)->nullable();
            $table->string('address_proof',255)->nullable();
            $table->string('latest_coordinates',100)->nullable();
            $table->string('rejection_reason',255)->nullable();
            $table->dateTime('coordinates_updated_at')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_profiles');
    }
}
