<?php

namespace App;

use App\UploadImage;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use UploadImage;
    //
    //          id int [pk]
    //          provider_id int [ref: > providers.id]
    //          title varchar
    //          description longtext
    //          price double
    protected $primaryKey = 'id';
    protected $fillable = [
        'provider_id',
        'title',
        'description',
        'price',
        'image',
    ];
    // public $timestamps = false;

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    // public function images()
    // {
    //     return $this->hasMany('App\ServiceImage');
    // }

    public function options()
    {
        return $this->hasMany('App\ServiceOption');
    }
}
