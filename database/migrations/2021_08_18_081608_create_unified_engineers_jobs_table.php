<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnifiedEngineersJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unified_engineers_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('engineer_id');
            $table->unsignedInteger('job_id');
            $table->string('status')->default('ready');
            $table->foreign('engineer_id')->references('id')->on('unified_engineers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('job_id')->references('id')->on('unified_jobs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unified_engineers_jobs');
    }
}
