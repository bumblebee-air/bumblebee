<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingContractStartEndDateOnUnifiedCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_customers_list', function (Blueprint $table) {
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
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
            $table->dropColumn('contract_start_date');
            $table->dropColumn('contract_end_date');
        });
    }
}
