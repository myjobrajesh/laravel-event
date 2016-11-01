<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

    protected $table = 'events';

    public $timestamps = false;
 
 
    public function location() {
        return $this->hasOne('App\Models\Location', 'id');
    }
    
    public function stands() {
        return $this->hasMany('App\Models\EventStand', 'event_id');
    }
    
    public function bookings() {
        return $this->hasMany('App\Models\EventBooking', 'event_id', 'id');
    }
    
    public function createdUser() {
        return $this->hasOne('App\Models\User');
    }
}
