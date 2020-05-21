<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmergencySettingsEmailFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emergency_settings', function (Blueprint $table) {
            $table->string('contact_email',255)->after('contact_method')->nullable();
            $table->string('second_contact_email',255)->after('second_contact_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emergency_settings', function (Blueprint $table) {
            $table->dropColumn('contact_email');
            $table->dropColumn('second_contact_email');
        });
    }
}
