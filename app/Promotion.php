<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    //
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'description','price'];
    public $timestamps = false;
}
