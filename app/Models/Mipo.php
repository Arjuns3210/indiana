<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mipo extends Model
{
    use SoftDeletes;

    public $fillable = [
        'po_no',
        'revision_no',
        'po_recv_date',
        'ho_recv_date',
        'po_type',
        'maker_id',
        'enquiry_id',
        'enquiry_no',
        'client_name',
        'negotiation_margin',
        'payment_terms',
        'liquidated_damages',
        'delivery_date',
        'freight',
        'engineering_input_status',
        'first_engg_input_date',
        'last_engg_input_date',
        'no_of_days_for_approval',
        'po_amount',
        'po_quantity',
        'client_po_no',
        'client_po_date',
        'project_name',
        'region_id',
        'product_id',
        'category_id',
        'reference',
        'mipo_user_id',
        'old_mipo_user_id',
        'mipo_user_allocation_dt',
        'allocation_completion_dt',
        'case_incharge_id',
        'ci_document_upload_dt',
        'ci_approval_status',
        'ci_remarks',
        'engineer_id',
        'engg_document_upload_dt',
        'engg_approval_status',
        'engg_remarks',
        'drawing_id',
        'drawing_document_upload_dt',
        'ig_breakup',
        'input_availability',
        'input_availability_updated_by',
        'drawing_approval_status',
        'drawing_remarks',
        'commercial_id',
        'commercial_document_upload_dt',
        'commercial_approval_status',
        'commercial_remarks',
        'purchase_id',
        'purchase_document_upload_dt',
        'purchase_approval_status',
        'purchase_remarks',
        'mipo_verification_status',
        'mipo_verification_status_dt',
        'mipo_remarks',
        'head_engg_allocation_dt',
        'head_engineer_id',
        'head_engg_status_dt',
        'head_engg_approval_status',
        'head_engg_remarks',
        'order_approval_sheet_upload_dt',
        'order_sheet_status_dt',
        'order_sheet_approval_status',
        'order_sheet_remarks',
        'management_id',
        'management_status_dt',
        'management_approval_status',
        'management_remarks',
        'is_frp',
        'is_gr',
        'has_revisions',
        'mipo_status',
        'currently_with',
        'call_from',
        'ip_address',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'mipo_user_id');
    }

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class,'enquiry_id');
    }
    
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class,'region_id');
    }
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }  
    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function caseIncharge(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'case_incharge_id');
    }

        public function estimateEngineer(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'engineer_id');
    }

    public function commercial(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'commercial_id');
    }

    public function purchaseTeam(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'purchase_id');
    }

    public function designEngineer(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'drawing_id');
    }

    public function headEngineer(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'head_engineer_id');
    }

    public function managementUser(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'management_id');
    }
    
    public function mipoStatus(): BelongsTo
    {
        return $this->belongsTo(MipoStatus::class,'mipo_status');
    }
    
    public function mipoCaseHistories(): HasMany
    {
        return $this->hasMany(MipoCaseHistory::class,'mipo_id');
    }
}
