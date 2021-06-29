<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('is_active')->nullable();
            $table->string('channel')->nullable();
            $table->string('send_to')->nullable();
            $table->string('content')->nullable();
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
        Schema::dropIfExists('custom_notifications');
    }
}
