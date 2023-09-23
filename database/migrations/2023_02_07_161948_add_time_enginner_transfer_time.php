<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeEnginnerTransferTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->time('engg_transfer_time')->nullable()->after('engg_transfer_date');
            $table->time('typist_transfer_time')->nullable()->after('typist_transfer_date');
            });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropColumn('engg_transfer_time');
            $table->dropColumn('typist_transfer_time');
        });
    }
}
