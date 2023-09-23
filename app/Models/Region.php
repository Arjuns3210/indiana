<?php

namespace App\Models;

use App\Http\Controllers\Backend\AbpController;
use App\Http\Controllers\Backend\RegionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;

    public function abps(): HasMany
    {
        return $this->hasMany(Abp::class, 'region_id');
    }   
}
