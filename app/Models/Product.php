<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * Developed By : Maaz Ansari
     * Created On : 18-aug-2022
     * uses : to to get data of sub category in product 
     */
    public function sub_category()
    {
        return $this->belongsTo('App\Models\SubCategory');
    }

    /**
     * Developed By : Maaz Ansari
     * Created On : 18-aug-2022
     * uses : to to get data of category in product 
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    /**
     * Developed By :Swayama
     * Created On : 16-aug-2022
     * uses : to to get data of brand in product 
     */
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }
    /**
     * Developed By : Swayama
     * Created On : 16-aug-2022
     * uses : to to get data of collection in product 
     */
    public function collection()
    {
        return $this->belongsTo('App\Models\Collection');
    }
}
