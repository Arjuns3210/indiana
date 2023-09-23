<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngineerDailyRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_remarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->default(0)->constrained()->cascadeOnDelete()->comment("for Engineers");
            $table->longtext('activity_remarks');
            $table->date('remark_date',15);
            $table->enum('status',[1, 0])->default(1);//enum (1,0)
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_remarks');
    }
}
