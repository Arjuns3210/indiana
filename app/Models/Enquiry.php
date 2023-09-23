<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Enquiry extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $fillable = [
        'id',
        'enq_no',
        'revision_no',
        'enq_recv_date',
        'enq_register_date',
        'enq_due_date',
        'enq_reminder_date',
        'client_name',
        'project_name',
        'product_id',
        'region_id',
        'case_incharge_id',
        'sales_id',
        'sales_remark',
        'category_id',
        'industry_id',
        'category_mapped_date',
        'actual_client',
        'case_incharge_remark',
        'allocation_status',
        'allocation_date',
        'engineer_id',
        'old_engineer_id',
        'engg_transfer_date',
        'typist_id',
        'old_typist_id',
        'typist_transfer_date',
        'allocation_remark',
        'allocator_id',
        'engineer_status',
        'engineer_remark',
        'estimated_date',
        'typist_status',
        'amount',
        'typist_remark',
        'typist_completed_date',
    ];

    /**
     * Developed By : Maaz
     * Created On : 16-Aug-2022
     * uses : To get user data in enquiry
     */
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }


    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function industry()
    {
        return $this->belongsTo('App\Models\industry');
    }

    // mutators start
    public function setClientNameAttribute($value)
    {
        $this->attributes['client_name'] = ucwords(strtolower($value));
    }

    public function setProjectNameAttribute($value)
    {
        $this->attributes['project_name'] = ucwords(strtolower($value));
    }
    // mutators end
}
