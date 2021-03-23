<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGrandServicesTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garden_services_types', function (Blueprint $table) {
//            $table->dropColumn('rate_per_hour');
//            $table->dropColumn('max_property_size');
            $table->text('rate_property_sizes')->after('min_hours');
            $table->tinyInteger('is_service_recurring')->after('rate_property_sizes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
