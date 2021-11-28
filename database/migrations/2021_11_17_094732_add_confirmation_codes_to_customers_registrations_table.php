<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfirmationCodesToCustomersRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers_registrations', function (Blueprint $table) {
            $table->string('customer_confirmation_code')->nullable();
            $table->string('contractor_confirmation_code')->nullable();
            $table->string('contractor_confirmation_status')->nullable();
            $table->string('contractor_confirmation_skip_reason')->nullable();
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
            $table->dropColumn('customer_confirmation_code');
            $table->dropColumn('contractor_confirmation_code');
            $table->dropColumn('contractor_confirmation_status');
            $table->dropColumn('contractor_confirmation_skip_reason');
        });
    }
}
