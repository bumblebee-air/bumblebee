<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id',false,true);
            $table->string('name',50);
            $table->string('shopify_store_domain',50)->nullable();
            $table->string('shopify_app_api_key',50)->nullable();
            $table->string('shopify_app_password',50)->nullable();
            $table->string('shopify_app_secret',50)->nullable();
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
        Schema::dropIfExists('retailers');
    }
}
