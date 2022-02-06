<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderItemsAndCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('no_of_items')->default(0);
            $table->boolean('label_qr_scan')->default(0);
        });
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('model',255);
            $table->integer('model_id')->unsigned();
            $table->string('model_sub',255)->nullable();
            $table->string('code',255)->nullable();
            $table->boolean('scanned')->default(0);
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
        Schema::dropIfExists('qr_codes');
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('label_qr_scan');
            $table->dropColumn('no_of_items');
        });
    }
}
