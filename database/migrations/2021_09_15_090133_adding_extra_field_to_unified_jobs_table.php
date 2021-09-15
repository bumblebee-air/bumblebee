<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingExtraFieldToUnifiedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_jobs', function (Blueprint $table) {
            $table->text('job_description')->nullable();
            $table->text('accounts_note')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('cost_estimate')->nullable();
            $table->string('pickup_address')->nullable();
            $table->string('pickup_coordinates')->nullable();
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
            $table->dropColumn('job_description');
            $table->dropColumn('accounts_note');
            $table->dropColumn('date');
            $table->dropColumn('time');
            $table->dropColumn('cost_estimate');
            $table->dropColumn('pickup_address');
            $table->dropColumn('pickup_coordinates');
        });
    }
}
