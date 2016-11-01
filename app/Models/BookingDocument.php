<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDocument extends Model {

    protected $table = 'event_booking_documents';

    public $timestamps = false;    
 
 
    public function booking() {
        return $this->belongsTo('App\Models\EventBooking');
    }
}
