<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsBiddingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors_bidding', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->unsignedInteger('contractor_id');
            $table->decimal('estimated_quote');
            $table->foreign('job_id')->references('id')->on('customers_registrations')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('contractor_id')->references('id')->on('contractors_registrations')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('contractors_bidding');
    }
}
