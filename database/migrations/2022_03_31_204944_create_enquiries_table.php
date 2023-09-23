<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEnquiriesTable extends Migration
{
    /**
     * Created By : Pradyumn Dwivedi
     * Created at : 08-aug-2022
     * Uses : To create new Table
     * 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('enq_no', 255)->default(0);
            $table->date('enq_recv_date');
            $table->date('enq_register_date');
            $table->date('enq_due_date')->nullable();
            $table->date('enq_reminder_date')->nullable();
            $table->string('client_name', 255);
            $table->string('project_name', 255);
            $table->integer('product_id')->default(0);
            $table->integer('region_id')->default(0);
            $table->integer('case_incharge_id')->default(0)->comment('Admin Table Id');
            $table->longText('sales_remark')->nullable();
            $table->integer('category_id')->default(0);
            $table->integer('industry_id')->default(0);
            $table->string('actual_client', 255)->nullable();
            $table->date('category_mapped_date')->nullable();
            $table->longText('case_incharge_remark')->nullable();
            $table->string('allocation_status', 255)->nullable();
            $table->integer('engineer_id')->default(0)->comment('Admin Table Id');
            $table->integer('old_engineer_id')->default(0)->comment('Admin Table Id');
            $table->date('allocation_date')->nullable();
            $table->integer('typist_id')->default(0)->comment('Admin Table Id');
            $table->longText('allocation_remark')->nullable();
            $table->string('engineer_status', 255)->nullable();
            $table->longText('engineer_remark')->nullable();
            $table->string('typist_status', 255)->nullable();
            $table->integer('revision_no')->default(0);
            $table->date('estimated_date')->nullable();
            $table->decimal('amount', $precision = 18, $scale = 2)->default(0.00);
            $table->integer('quantity')->default(0);
            $table->date('typist_completed_date')->nullable();
            $table->longText('typist_remark')->nullable();
            $table->string('currently_with', 255)->default('sales')->comment('sales|case_incharge|allocation|engineer|typist');
            $table->string('call_from', 255)->default('website')->comment('website|android|ios|mobile|facebook|twitter|youtube|social|telecaller|others');
            $table->string('ip_address', 255)->nullable();
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
        Schema::dropIfExists('enquiries');
    }
}
