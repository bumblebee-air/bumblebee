<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingServicesTypesAndSkipReasonOnCustomersRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers_registrations', function (Blueprint $table) {
            $table->string('skip_reason', 500)->nullable();
            $table->text('services_types_json')->nullable();
            $table->text('job_services_types_json')->nullable();
            $table->string('job_image')->nullable();
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
