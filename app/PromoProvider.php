<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoProvider extends Model
{
    // id int [pk]
        // provider_id int [ref: > providers.id]
        // promotion_id int [ref: > promotions.id]
        // payment_method varchar
        // expirey_date datetime
        protected $primaryKey = 'id';
        protected $fillable = ['provider_id','promotion_id','expirey_date'];
    
        protected $attributes = [
            'payment_method' => 'Cash',
        ];

        protected $casts = [
            'expirey_date' => 'datetime',
        ];
    
        //one-to-many inverse
        public function provider()
        {
            return $this->belongsTo('App\Provider');
        }
    
        //one-to-many inverse
        public function promotion()
        {
            return $this->belongsTo('App\Promotion');
        }
    
}
