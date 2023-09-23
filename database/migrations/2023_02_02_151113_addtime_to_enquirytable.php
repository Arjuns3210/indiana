<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddtimeToEnquirytable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->time('category_mapped_time')->nullable()->after('category_mapped_date');
            $table->time('allocation_time')->nullable()->after('allocation_date');
            $table->time('estimated_time')->nullable()->after('estimated_date');
            $table->time('typist_completed_time')->nullable()->after('typist_completed_date');
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
            $table->dropColumn('category_mapped_time');
            $table->dropColumn('allocation_time');
            $table->dropColumn('estimated_time');
            $table->dropColumn('typist_completed_time');
        });
    }
}
