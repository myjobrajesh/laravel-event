<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model {

    protected $table = 'event_bookings';

    public $timestamps = false;
    
    
    public function event() {
        return $this->belongsTo('App\Models\Event');
    }

    public function stand() {
        return $this->hasOne('App\Models\EventStand', 'id', 'stand_id');
    }
    
    public function user() {
        return $this->hasOne('App\Models\User');
    }
    
    public function documents() {
        return $this->hasMany('App\Models\BookingDocument', 'booking_id', 'id');
    }
}
