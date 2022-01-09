<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePropertyPhotoToCustomersRegistrationsPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers_registrations_properties', function (Blueprint $table) {
            $table->text('property_photo')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers_registrations_properties', function (Blueprint $table) {
            $table->string('property_photo')->change();
        });
    }
}
