<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewStripePaymentFieldsToRetailers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retailers', function (Blueprint $table) {
            $table->string('stripe_payment_id',255)->nullable()->after('stripe_customer_id');
            $table->string('payment_method',255)->nullable()->after('stripe_payment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('retailers', function (Blueprint $table) {
            $table->dropColumn('payment_method');
            $table->dropColumn('stripe_payment_id');
        });
    }
}
