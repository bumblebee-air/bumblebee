<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUnifiedEngineersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_engineers', function (Blueprint $table) {
            $table->renameColumn('name', 'first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('address_coordinates');
            $table->string('job_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unified_engineers', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('phone');
            $table->dropColumn('email');
            $table->dropColumn('address');
            $table->dropColumn('address_coordinates');
        });
    }
}
