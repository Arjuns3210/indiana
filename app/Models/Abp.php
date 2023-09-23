<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abp extends Model
{
    use SoftDeletes;
    
    protected $table = "abp";

    public $fillable = [
        'case_incharge_id',
        'product_id',
        'client_name',
        'region_id',
        'budget_type',
        'net_margin_budget',
        'order_value_budget',
        'payment_terms_budget',
        'credit_days_budget',
        'time_budget',
        'time_expected',
        'remarks_budget',
        'ceo_approval',
        'ceo_approval_date',
        'ceo_approval_remark',
        'enquiry_id',
        'call_from',
        'ip_address',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
    ];


    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function caseIncharge(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'case_incharge_id');
    }

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');
    }

    public function abpReviewLatestOneHistory()
    {
        return $this->hasOne(AbpReviewHistory::class, 'abp_id', 'id')->latest('id');
    }

    public function abpReviewHistories(): HasMany
    {
        return $this->hasMany(AbpReviewHistory::class,'abp_id');
    }
}
