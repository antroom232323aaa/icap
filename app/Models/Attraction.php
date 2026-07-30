<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'city',
        'town',
        'address',
        'image',
        'description',
        'feature',
        'website'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
