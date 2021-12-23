<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentMethodTypeAndCaptureMethodToCustomersRegistrationsExtraDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers_registrations_extra_data', function (Blueprint $table) {
            $table->string('payment_method_type')->nullable();
            $table->string('capture_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers_registrations_extra_data', function (Blueprint $table) {
            $table->dropColumn('payment_method_type');
            $table->dropColumn('capture_method');
        });
    }
}
