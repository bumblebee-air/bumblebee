<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditConversationCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversation_categories', function (Blueprint $table){
            $table->integer('client_id')->unsigned()->nullable()
                ->default(null)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn('conversation_categories', 'client_id')) {
            Schema::table('conversation_categories', function (Blueprint $table) {
                $table->dropColumn('client_id');
            });
        }
    }
}
