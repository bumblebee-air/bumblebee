<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVehicleFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('vehicle_make',255)->after('vehicle_reg');
            $table->string('vehicle_model',255)->after('vehicle_make');
            $table->string('vehicle_version',255)->after('vehicle_model');
            $table->string('vehicle_fuel',255)->after('vehicle_version');
            $table->string('vehicle_colour',255)->after('vehicle_fuel');
            $table->string('vehicle_external_id',255)->after('vehicle_colour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('vehicle_make');
            $table->dropColumn('vehicle_model');
            $table->dropColumn('vehicle_version');
            $table->dropColumn('vehicle_fuel');
            $table->dropColumn('vehicle_colour');
            $table->dropColumn('vehicle_external_id');
        });
    }
}
