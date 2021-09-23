<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFeedbackFilledToUnifiedEngineersJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_engineers_jobs', function (Blueprint $table) {
            $table->boolean('is_feedback_filled')->default(false);
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
            $table->dropColumn('is_feedback_filled');
        });
    }
}
