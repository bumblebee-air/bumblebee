<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id',50);
            $table->string('description',255)->nullable();
            $table->string('weight',20)->nullable();
            $table->string('dimensions',20)->nullable();
            $table->boolean('paid')->default(1);
            $table->string('notes',255)->nullable();
            $table->string('retailer_name',255);
            $table->string('pickup_address',255);
            $table->string('pickup_lat',50)->nullable();
            $table->string('pickup_lon',50)->nullable();
            $table->string('customer_name',50);
            $table->string('customer_phone',50)->nullable();
            $table->string('customer_email',50)->nullable();
            $table->string('customer_address',255);
            $table->string('customer_address_lat',50)->nullable();
            $table->string('customer_address_lon',50)->nullable();
            $table->string('status',20)->nullable()->default('pending');
            $table->string('driver',50)->nullable();
            $table->string('driver_status',50)->nullable();
            $table->string('eircode',50)->nullable();
            $table->boolean('fragile')->nullable();
            $table->string('customer_confirmation_code')->nullable();
            $table->string('delivery_confirmation_code')->nullable();
            $table->string('delivery_confirmation_status')->nullable();
            $table->string('delivery_confirmation_skip_reason')->nullable();
            $table->string('fulfilment', 255)->nullable();
            $table->string('deliver_by', 255)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
