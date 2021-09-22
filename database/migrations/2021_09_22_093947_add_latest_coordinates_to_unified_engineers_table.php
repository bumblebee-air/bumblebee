<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatestCoordinatesToUnifiedEngineersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_engineers', function (Blueprint $table) {
            $table->string('latest_coordinates')->nullable();
            $table->timestamp('latest_coordinates_updated_at')->nullable();
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
            $table->dropColumn('latest_coordinates');
            $table->dropColumn('latest_coordinates_updated_at');
        });
    }
}
