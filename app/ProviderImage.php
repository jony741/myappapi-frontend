<?php

namespace App;

use App\UploadImage;
use Illuminate\Database\Eloquent\Model;

class ProviderImage extends Model
{
    use UploadImage;

    protected $primaryKey = 'id';
    protected $fillable = [
        'provider_id',
        'image',
    ];
    public $timestamps = false;

    //one-to-many inverse
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
}
