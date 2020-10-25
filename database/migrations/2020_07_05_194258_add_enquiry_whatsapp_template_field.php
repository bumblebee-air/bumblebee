<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnquiryWhatsappTemplateField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_enquiries', function(Blueprint $table){
            $table->integer('whatsapp_template')->nullable()
                ->after('contractor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_enquiries', function(Blueprint $table){
            $table->dropColumn('whatsapp_template');
        });
    }
}
