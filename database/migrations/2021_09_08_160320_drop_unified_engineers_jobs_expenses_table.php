<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUnifiedEngineersJobsExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('unified_engineers_jobs_expenses');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('unified_engineers_jobs_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cost');
            $table->string('comment', 500)->nullable();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('engineer_job_id');
            $table->foreign('engineer_job_id')->references('id')->on('unified_engineers_jobs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }
}
