<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRetailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retailers', function (Blueprint $table) {
            $table->string('company_name')->nullable();
            $table->string('company_website')->nullable();
            $table->string('business_type')->nullable();
            $table->string('nom_business_locations')->nullable();
            $table->text('locations_details')->nullable();
            $table->text('contacts_details')->nullable();
            $table->string('stripe_token')->nullable();
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
