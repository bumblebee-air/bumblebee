<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnquiryContractorField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_enquiries', function (Blueprint $table) {
            $table->integer('contractor')->unsigned()->after('enquiry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_enquiries', function (Blueprint $table) {
            $table->dropColumn('contractor');
        });
    }
}
