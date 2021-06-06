<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LinkTermsAndPoliciesToClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('terms_and_policies', function (Blueprint $table) {
            $table->integer('client_id',false,true)
                ->after('type')->default(0);
            $table->string('terms',255)->nullable()->change();
            $table->string('policy',255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('terms_and_policies', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });
    }
}
