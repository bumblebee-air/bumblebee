<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerAndEngineerConfirmationCodeToUnifiedEngineersJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_engineers_jobs', function (Blueprint $table) {
            $table->string('customer_confirmation_code')->nullable();
            $table->string('engineer_confirmation_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unified_engineers_jobs', function (Blueprint $table) {
            $table->dropColumn('customer_confirmation_code');
            $table->dropColumn('engineer_confirmation_code');
        });
    }
}
