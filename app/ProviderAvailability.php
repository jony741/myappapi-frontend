<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderAvailability extends Model
{
    //         id int [pk]
    //          provider_id int [ref: > providers.id]
    //          weekday int
    //          start_datetime datetime
    //          end_datetime datetime
    protected $primaryKey = 'id';
    protected $fillable = [
        'provider_id',
        'weekday',
        'start_datetime',
        'end_datetime',
    ];

    public $timestamps = false;

    //one-to-many inverse
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
}
