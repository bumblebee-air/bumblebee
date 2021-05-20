<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnifiedCustomersListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unified_customers_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('ac')->nullable();
            $table->string('name')->nullable();
            $table->string('street_1')->nullable();
            $table->string('street_2')->nullable();
            $table->string('town')->nullable();
            $table->string('country')->nullable();
            $table->string('post_code')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->tinyInteger('hosted_pbx')->nullable();
            $table->tinyInteger('access_control')->nullable();
            $table->tinyInteger('cctv')->nullable();
            $table->tinyInteger('fire_alarm')->nullable();
            $table->tinyInteger('intruder_alarm')->nullable();
            $table->tinyInteger('wifi_data')->nullable();
            $table->tinyInteger('structured_cabling_system')->nullable();
            $table->tinyInteger('contract')->nullable();
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
        Schema::dropIfExists('unified_customers_list');
    }
}
