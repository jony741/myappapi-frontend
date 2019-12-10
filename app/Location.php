<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //// id int [pk]
        // lat float
        // lng float
        // full_address varchar
        // street_name varchar
        // building_no varchar
        protected $primaryKey = 'id';
        protected $fillable = [
            'lat',
            'lng',
            'full_address',
            'street_name',
            'building_no',
        ];
        public $timestamps = false;
    
        public function provider()
        {
            return $this->belongsTo('App\Provider');
        }
}
