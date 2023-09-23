<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyRemark extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $dates = ['deleted_at'];


    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

}
