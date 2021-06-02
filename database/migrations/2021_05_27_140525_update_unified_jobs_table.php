<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUnifiedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_jobs', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('job_type_id');
            $table->unsignedInteger('engineer_id');
            $table->foreign('company_id')->references('id')->on('unified_companies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('job_type_id')->references('id')->on('unified_job_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('engineer_id')->references('id')->on('unified_engineers')->onUpdate('cascade')->onDelete('cascade');
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
