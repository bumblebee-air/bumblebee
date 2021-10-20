<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversPayoutHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers_payout_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('driver_profiles')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('transaction_id');
            $table->text('orders_ids');
            $table->string('subtotal');
            $table->string('original_subtotal');
            $table->string('charged_amount');
            $table->string('additional');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('drivers_payout_history');
    }
}
