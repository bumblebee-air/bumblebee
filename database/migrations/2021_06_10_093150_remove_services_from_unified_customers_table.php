<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveServicesFromUnifiedCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_customers_list', function (Blueprint $table) {
//            $table->dropColumn('hosted_pbx');
//            $table->dropColumn('access_control');
//            $table->dropColumn('cctv');
//            $table->dropColumn('fire_alarm');
//            $table->dropColumn('fire_alarm');
//            $table->dropColumn('intruder_alarm');
//            $table->dropColumn('wifi_data');
//            $table->dropColumn('structured_cabling_system');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unified_customers_list', function (Blueprint $table) {
            $table->tinyInteger('hosted_pbx')->nullable();
            $table->tinyInteger('access_control')->nullable();
            $table->tinyInteger('cctv')->nullable();
            $table->tinyInteger('fire_alarm')->nullable();
            $table->tinyInteger('intruder_alarm')->nullable();
            $table->tinyInteger('wifi_data')->nullable();
            $table->tinyInteger('structured_cabling_system')->nullable();
        });
    }
}
