<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInDutyToDriverProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver_profiles', function (Blueprint $table) {
            //
            $table->boolean('in_duty')->default(1);
            $table->timestamp('last_active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('driver_profiles', function (Blueprint $table) {
            //
            $table->dropColumn(['in_duty', 'last_active']);
        });
    }
}
