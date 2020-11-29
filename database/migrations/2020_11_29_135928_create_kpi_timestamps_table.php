<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKPITimestampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_timestamps', function (Blueprint $table) {
            $table->id();
            $table->string('model',50);
            $table->string('model_id',50);
            $table->dateTime('assigned')->nullable();
            $table->dateTime('accepted')->nullable();
            $table->dateTime('on_the_way_first')->nullable();
            $table->dateTime('arrived_first')->nullable();
            $table->dateTime('on_the_way_second')->nullable();
            $table->dateTime('arrived_second')->nullable();
            $table->dateTime('completed')->nullable();
            $table->dateTime('cancelled')->nullable();
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
        Schema::dropIfExists('kpi_timestamps');
    }
}
