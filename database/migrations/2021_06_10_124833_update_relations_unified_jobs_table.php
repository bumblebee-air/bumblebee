<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRelationsUnifiedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_jobs', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
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
            $table->foreign('company_id')->references('id')->on('unified_companies')->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
