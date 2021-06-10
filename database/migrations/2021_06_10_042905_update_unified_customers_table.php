<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUnifiedCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_customers_list', function (Blueprint $table) {
            $table->dropColumn('street_1');
            $table->dropColumn('street_2');
            $table->dropColumn('town');
            $table->dropColumn('country');
            $table->dropColumn('contact');
            $table->dropColumn('email');
            $table->dropColumn('mobile');
            $table->text('contacts')->after('contract')->nullable();
            $table->text('address')->after('contacts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unified_customers_list', function (Blueprint $table) {
            $table->string('street_1');
            $table->string('street_2');
            $table->string('town');
            $table->string('country');
            $table->string('contact');
            $table->string('email');
            $table->string('mobile');
            $table->dropColumn('contacts');
            $table->dropColumn('address');
        });
    }
}
