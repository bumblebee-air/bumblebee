<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoomYogaCustomersEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doom_yoga_customers_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('event_id');
            $table->foreign('customer_id')->references('id')->on('doomyoga_customers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('event_id')->references('id')->on('doom_yoga_events')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('doom_yoga_customers_events');
    }
}
