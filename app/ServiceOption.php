<?php

namespace App;

use App\UploadImage;
use Illuminate\Database\Eloquent\Model;

class ServiceOption extends Model
{
    use UploadImage;

        protected $primaryKey = 'id';
        protected $fillable = [
            'service_id',
            'title',
            'price',
            'image',
        ];
        public $timestamps = false;  

        //one-to-many inverse
    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
