<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStripeAccountOnboardStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stripe_accounts', function (Blueprint $table) {
            $table->string('onboard_status')->nullable()->after('onboard_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stripe_accounts', function (Blueprint $table) {
            $table->dropColumn('onboard_status');
        });
    }
}
