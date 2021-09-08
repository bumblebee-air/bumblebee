<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUpdatesUnifiedEngineersJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_engineers_jobs', function (Blueprint $table) {
            $table->renameColumn('additional_service_id', 'service_id');
            $table->unsignedInteger('additional_job_type_id')->nullable();
            $table->foreign('additional_job_type_id')->references('id')->on('unified_job_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('additional_cost', 500)->nullable();
            $table->string('comment', 500)->nullable();
            $table->renameColumn('expenses_receipt', 'expenses_receipts');
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
            $table->renameColumn('service_id', 'additional_service_id');
            $table->dropForeign('additional_job_type_id');
            $table->dropColumn('additional_job_type_id');
            $table->dropColumn('comment');
            $table->renameColumn('expenses_receipts', 'expenses_receipt');
        });
    }
}
