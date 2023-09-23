<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbpReviewHistory extends Model
{
    use SoftDeletes;

    protected $table = "abp_review_history";

    public $fillable = [
        'abp_id',
        'net_margin_expected',
        'remark_net_margin_expected',
        'order_value_expected',
        'remark_order_value_expected',
        'payment_terms_expected',
        'remark_payment_terms_expected',
        'credit_days_expected',
        'remark_credit_days_expected',
        'time_expected',
        'remark_time_expected',
        'reason_id',
        'probability',
        'ceo_reviewal_date',
        'ceo_reviewal_remark',
        'call_from',
        'ip_address',
        'status',
        'created_by',
        'updated_by',
        'deleted_at'
        ];

    public function abpProbability()
    {
        return $this->hasOne(AbpProbability::class,'id','probability');
    }

    public function reason()
    {
        return $this->hasOne(AbpVarianceRemark::class,'id','reason_id');
    }

}
