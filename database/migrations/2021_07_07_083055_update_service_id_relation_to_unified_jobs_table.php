<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateServiceIdRelationToUnifiedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_jobs', function (Blueprint $table) {
            $table->dropForeign(['service_id']); //Uncomment this line if you don't have 'unified_jobs_service_id_foreign'.
//            $table->foreign('service_id')->references('id')->on('services_types')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unified_jobs', function (Blueprint $table) {
            //
        });
    }
}
