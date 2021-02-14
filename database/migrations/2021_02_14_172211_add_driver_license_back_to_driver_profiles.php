<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDriverLicenseBackToDriverProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver_profiles', function (Blueprint $table) {
            $table->string('driver_license_back',255)->nullable()->after('driver_license');
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
            $table->dropColumn('driver_license_back');
        });
    }
}
