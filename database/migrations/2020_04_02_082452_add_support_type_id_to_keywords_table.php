<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupportTypeIdToKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keywords', function (Blueprint $table){
            $table->integer('support_type_id')->unsigned()->nullable()
                ->default(null)->after('audio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn('keywords', 'support_type_id')) {
            Schema::table('keywords', function (Blueprint $table) {
                $table->dropColumn('support_type_id');
            });
        }
    }
}
