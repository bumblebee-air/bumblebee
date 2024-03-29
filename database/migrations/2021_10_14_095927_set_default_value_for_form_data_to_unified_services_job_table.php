<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetDefaultValueForFormDataToUnifiedServicesJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unified_services_job', function (Blueprint $table) {
            $table->text('formData')->default(['[]'])->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unified_services_job', function (Blueprint $table) {
            $table->text('formData')->nullable()->change();
        });
    }
}
