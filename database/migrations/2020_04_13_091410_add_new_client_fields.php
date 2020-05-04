<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewClientFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table){
            $table->string('sector')->nullable()->default(null)->after('name');
            $table->string('logo')->nullable()->default(null)->after('sector');
            $table->string('nav_highlight_color')->nullable()->default(null)->after('logo');
            $table->string('nav_background_image')->nullable()->default(null)->after('nav_highlight_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('nav_background_image');
            $table->dropColumn('nav_highlight_color');
            $table->dropColumn('logo');
            $table->dropColumn('sector');
        });
    }
}
