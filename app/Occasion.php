<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occasion extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'image'];
    public $timestamps = false;

    // public function provider_occ()
    // {
    //     return $this->belongsToMany(Provider::class,'provider_occs','occ_id','provider_id');
    // }

    public function provider()
    {
        return $this->belongsToMany(Provider::class);
    }
}
