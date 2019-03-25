<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone',255);
            $table->string('name', 255)->nullable();
            $table->integer('sms_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('is_registered')->default(0);
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
        Schema::dropIfExists('customer_invitations');
    }
}
