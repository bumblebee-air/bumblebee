<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnquiryLocationFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_enquiries', function(Blueprint $table){
            $table->string('location',255)->nullable();
            $table->string('location_lat',50)->nullable();
            $table->string('location_lon',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_enquiries', function (Blueprint $table) {
            $table->dropColumn('location');
            $table->dropColumn('location_lat');
            $table->dropColumn('location_lon');
        });
    }
}
