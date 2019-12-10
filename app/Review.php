<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    // id int [pk]
        // provider_id int [ref: > providers.id]
        // user_id int [ref: > users.id]
        // rate float
        // title varchar
        // description longtext
        // created_at timestamp
        // updated_at timestamp
        protected $primaryKey = 'id';
        protected $fillable = [
            'provider_id',
            'user_id',
            'rate',
            'title',
            'description',
        ];
    
        public function provider()
        {
            return $this->belongsTo('App\Provider');
        }
    
        public function user()
        {
            return $this->belongsTo('App\User');
        }
}
