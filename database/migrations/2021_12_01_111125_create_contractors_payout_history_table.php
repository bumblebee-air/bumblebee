<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsPayoutHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors_payout_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('contractor_id');
            $table->foreign('contractor_id')->references('id')->on('contractors_registrations')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('transaction_id');
            $table->text('jobs_ids');
            $table->string('subtotal');
            $table->string('original_subtotal');
            $table->string('charged_amount');
            $table->string('additional')->default(0);
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
        Schema::dropIfExists('contractors_payout_history');
    }
}
