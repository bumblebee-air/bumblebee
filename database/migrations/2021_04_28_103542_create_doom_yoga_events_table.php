<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoomYogaEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doom_yoga_events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('level');
            $table->string('short_description', 500);
            $table->integer('max_participants');
            $table->timestamp('date_Time');
            $table->integer('duration');
            $table->tinyInteger('is_person');
            $table->tinyInteger('is_reccuring');
            $table->tinyInteger('is_auto_zoom');
            $table->string('stream_link', 700)->nullable();
            $table->string('stream_password')->nullable();
            $table->tinyInteger('is_free')->nullable();
            $table->tinyInteger('is_free_ticket_option')->nullable();
            $table->string('ticket_price_setting')->nullable();
            $table->decimal('price');
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
        Schema::dropIfExists('doom_yoga_events');
    }
}
