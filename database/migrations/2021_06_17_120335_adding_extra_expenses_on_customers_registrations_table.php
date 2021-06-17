<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingExtraExpensesOnCustomersRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers_registrations', function (Blueprint $table) {
            $table->string('job_other_expenses_json')->nullable();
            $table->string('job_expenses_receipt_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers_registrations', function (Blueprint $table) {
            $table->dropColumn('job_other_expenses_json');
            $table->dropColumn('job_expenses_receipt_file');
        });
    }
}
