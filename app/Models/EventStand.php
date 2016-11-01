<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventStand extends Model {

    protected $table = 'event_stands';

    public $timestamps = false;    
 
    
    public function event() {
        return $this->belongsTo('App\Models\Event');
    }
    
    public function booking() {
        return $this->hasOne('App\Models\EventBooking', 'stand_id', 'id');
    }
    
}
