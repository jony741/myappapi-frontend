<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    //   id int [pk]
    //   order_id int [ref: > orders.id]
    //   service_id int [ref: > services.id]
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id',
        'service_id',
    ];
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
