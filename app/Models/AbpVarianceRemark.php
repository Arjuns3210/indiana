<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbpVarianceRemark extends Model
{
    use SoftDeletes;

    public $fillable = [
        'reason',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
    
}
