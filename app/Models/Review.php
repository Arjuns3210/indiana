<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * Created By : Maaz Ansari
     * Created at : 08/08/2022
     * Uses : The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'rating',
        'review'
    ];

    /**
     * Developed By : Maaz Ansari
     * Created On : 10-Aug-2022
     * uses : to get data of user in review 
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Developed By : Maaz Ansari
     * Created On : 10-Aug-2022
     * uses : to get data of product in review 
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
