<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTerm extends Model
{
    use SoftDeletes;

    public $fillable = [
        'payment_terms',
        'no_of_days',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
