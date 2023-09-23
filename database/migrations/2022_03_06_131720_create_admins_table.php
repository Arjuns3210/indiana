<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Created By : Maaz Ansari
     * Created at : 08-aug-2022
     * Uses : To create new Table
     * 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('admin_name', 255);
            $table->string('nick_name', 255);
            $table->string('email', 255)->unique();
            $table->integer('country_id')->default(1)->comment('phone_code');
            $table->string('phone', 10);
            $table->string('password');
            $table->text('address')->nullable();
            $table->foreignId('role_id')->default(0)->constrained()->cascadeOnDelete();
            $table->enum('status', [1, 0])->default(1);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
