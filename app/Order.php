<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //             id int [pk]
    //              provider_id int [ref: > providers.id]
    //              client_id int [ref: > users.id]
    //              event_id int [ref: > events.id]
    //              description longtext
    //              status varchar [note: "from status Enum"]
    //              created_at timestamp
    //              updated_at timestamp
    //              status_changed_at timestamp
    const PENDING = 0,
        ACCEPT = 1,
        DECLINE = 2,
        FINISHED = 3;
        
    protected $primaryKey = 'id';
    protected $fillable = [
        'provider_id',
        'client_id',
        'event_id',
        'description',
        'status',
        'status_changed_at'
    ];

    //one-to-many inverse
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    //one-to-many inverse
    public function client()
    {
        return $this->belongsTo('App\User');
    }

    //one-to-many inverse
    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function services()
    {
        return $this->belongsToMany('App\Service','order_services');
    }

    public function toStatus(int $status): bool
    {
        if ($status > $this->status && $status !== self::DECLINE) {
            return true;
        } elseif ($status === self::DECLINE && $this->status === self::PENDING) {
            return true;
        } else {
            return false;
        }
    }
}
