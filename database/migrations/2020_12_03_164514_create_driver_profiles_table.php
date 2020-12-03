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
            $table->string('first_name',20);
            $table->string('last_name',20);
            $table->string('contact_channel',20);
            $table->string('dob',20);
            $table->string('address',255);
            $table->string('address_coordinates',30);
            $table->string('postcode',10);
            $table->string('country',20);
            $table->string('pps_number',50);
            $table->string('emergency_contact_name',50);
            $table->string('emergency_contact_number',50);
            $table->string('transport',20);
            $table->string('max_package_size',20);
            $table->string('max_package_weight',20);
            $table->string('work_location',100);
            $table->string('work_radius',50);
            $table->string('legal_word_evidence',255);
            $table->string('driver_license',255);
            $table->string('insurance_proof',255);
            $table->string('address_proof',255);
            $table->string('latest_coordinates',50);
            $table->dateTime('coordinates_updated_at');
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
        Schema::dropIfExists('driver_profiles');
    }
}
