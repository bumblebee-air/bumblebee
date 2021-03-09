<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingProfileDataToContractorsRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contractors_registrations', function (Blueprint $table) {
            $table->string('business_hours');
            $table->text('business_hours_json');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contractors_registrations', function (Blueprint $table) {
            //
        });
    }
}
