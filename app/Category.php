<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'image'];
    public $timestamps = false;

    // public function provider()
    // {
    //     return $this->hasMany(Provider::class,'cat_id');
    // }

    // public function provider_cat()
    // {
    //     // return $this->belongsToMany(Provider::class,'provider_cats','cat_id','provider_id');
    //     return $this->belongsToMany(Provider::class);
    // }

    public function provider()
    {
        // return $this->belongsToMany(Provider::class,'provider_cats','cat_id','provider_id');
        return $this->belongsToMany(Provider::class);
    }
}
