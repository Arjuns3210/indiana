<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbpProbability extends Model
{
    use SoftDeletes;

    public $fillable = [
        'probability',
        'percentage',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
