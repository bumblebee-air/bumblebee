<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUnifiedEngineersJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_engineers_jobs', function (Blueprint $table) {
            $table->string('rejection_reason')->nullable();
            $table->string('skip_reason')->nullable();
            $table->string('additional_service_id')->nullable();
            $table->string('number_of_hours')->nullable();
            $table->text('job_images')->nullable();
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
            $table->dropColumn('rejection_reason');
            $table->dropColumn('skip_reason');
            $table->dropColumn('additional_service_id');
            $table->dropColumn('number_of_hours');
            $table->dropColumn('job_images');
        });
    }
}
