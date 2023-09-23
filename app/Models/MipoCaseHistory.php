<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MipoCaseHistory extends Model
{
    use HasFactory, SoftDeletes;
    
    public $table = 'mipo_case_histories';

        protected $fillable = [
            'mipo_id',
            'admin_id',
            'role',
            'action',
            'remarks',
            'action_dt',
            'status',
            'user_remarks',
            'created_by',
            'updated_by',
        ];

    public function adminUser(): BelongsTo
    {

        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
