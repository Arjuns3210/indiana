<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageNotification extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * Developed By : Maaz Ansari
     * Created On : 16-aug-2022
     * uses : to get data of language in notification message table
     */
    public function language()
    {
        return $this->belongsTo('App\Models\Language');
    }
}
