<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnifiedCustomerProductsSelectedValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unified_customer_products_selected_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedInteger('service_id');
            $table->text('selected_values')->nullable();
            $table->foreign('customer_id')->references('id')->on('unified_customers_list')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('service_id')->references('id')->on('unified_services_job')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('unified_customer_products_selected_values');
    }
}
