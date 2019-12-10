<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
        // id int [pk]
        // title varchar
        // occ_id int [ref: > occasions.id]
        // budget bigint
        // planner_option int [ref: > planner_option.id]
        // event_start datetime
        // event_end datetime
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'occ_id',
        'budget',
        'planner_option',
        'event_start',
        'event_end'
    ];

    //one-to-many inverse
    public function occasion()
    {
        return $this->belongsTo('App\Occasion');
    }

    public function plannerOption()
    {
        return $this->belongsTo('App\PlannerOption');
    }
}
