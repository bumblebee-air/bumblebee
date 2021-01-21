<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripePaymentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->string('model_id', 255)->nullable();
            $table->string('model_name', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('operation_id', 255)->nullable();
            $table->string('operation_type', 255)->nullable();
            $table->string('fail_message', 500)->nullable();
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
        Schema::dropIfExists('stripe_payment_logs');
    }
}
