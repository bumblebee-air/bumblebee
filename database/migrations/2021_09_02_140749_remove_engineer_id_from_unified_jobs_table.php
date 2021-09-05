<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEngineerIdFromUnifiedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_jobs', function (Blueprint $table) {
            $table->dropForeign('unified_jobs_engineer_id_foreign');
            $table->dropColumn('engineer_id');
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
            $table->unsignedInteger('engineer_id');
            $table->foreign('engineer_id')->references('id')->on('unified_engineers')->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
