<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailTriggerColumnToAdminsTable extends Migration
{
    /**
     * created by : Pradyumn
     * Created at : 07-Sept-2022
     * Uses : Add new columns to admins table
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->enum('sms_notification', [1, 0])->default(1)->after('status');
            $table->enum('email_notification', [1, 0])->default(1)->after('sms_notification');
            $table->enum('whatsapp_notification', [1, 0])->default(1)->after('email_notification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            //
        });
    }
}
