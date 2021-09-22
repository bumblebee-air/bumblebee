<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressCoordinatesToUnifiedCustomersListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_customers_list', function (Blueprint $table) {
            $table->string('address_coordinates')->nullable();
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
            $table->dropColumn('address_coordinates');
        });
    }
}
