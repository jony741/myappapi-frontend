<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlannerOption extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['title'];
    public $timestamps = false;

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
