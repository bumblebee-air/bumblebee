<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('vehicle_reg', 255)->nullable()->change();
            $table->string('vehicle_make', 255)->nullable()->change();
            $table->string('vehicle_model', 255)->nullable()->change();
            $table->string('vehicle_version', 255)->nullable()->change();
            $table->string('vehicle_fuel', 255)->nullable()->change();
            $table->string('vehicle_colour', 255)->nullable()->change();
            $table->string('vehicle_external_id', 255)->nullable()->change();
            $table->string('address', 255)->after('user_id')->nullable();
            $table->string('lat')->after('address')->nullable();
            $table->string('lon')->after('lat')->nullable();
            $table->string('vat_number')->after('lon')->nullable();
            $table->enum('communication_method', ['whatsapp', 'sms', 'email', 'phone_call'])->after('vat_number')->nullable();
            $table->string('notes')->after('vehicle_external_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->integer('vehicle_reg', 255)->change();
            $table->integer('vehicle_make', 255)->change();
            $table->integer('vehicle_model', 255)->change();
            $table->integer('vehicle_version', 255)->change();
            $table->integer('vehicle_fuel', 255)->change();
            $table->integer('vehicle_colour', 255)->change();
            $table->integer('vehicle_external_id', 255)->change();
            $table->dropColumn('address');
            $table->dropColumn('lat');
            $table->dropColumn('lon');
            $table->dropColumn('vat_number');
            $table->dropColumn('communication_method');
            $table->dropColumn('notes');
        });
    }
}
