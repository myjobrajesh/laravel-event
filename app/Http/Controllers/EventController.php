<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

\DB::connection()->enableQueryLog();
use Response;
use Exception;

use Mail;

class EventController extends Controller
{
    
    /* display event with exposition map
     * @param integer $eventId
     */
    public function viewEvent(Request $request, $eventId) {
        //get event detail
        $event   =   \App\Models\Event::with(['stands.booking.documents'])->where('status', 'active')->find($eventId);
        if(!$event) {
            return "No Active Event Found";
        }
        return view('layouts.event', compact('event'));
    }

    /* event over
     */
    public function eventOver(Request $request, $eventId) {
        $currentDateTime = date("Y-m-d H:i:s");
        $eventObj   =   \App\Models\Event::with(['bookings'])->where('status', 'active')
        ->where("end_date", "<", $currentDateTime)->find($eventId);
        
        if($eventObj) {
            //update event status to inactive
            try {
                $eventObj->status = 'inactive';
                $eventObj->save();
            } catch (Exception $e) {
                $response = array("error" => "Cannot update event");
                return \Response::json($response);
            }

            //send email to customers about report
            foreach($eventObj->bookings as $booking) {
                $username = $booking->company_admin_name;
                $email =    $booking->company_email;
                //TODO:: will set report statistics for event.
                $userData = array('email' => $email, "fullname" => $username);
                Mail::send('emails.eventreport', array("fullname" => $username), function ($message) use ($userData) {
                            $message->from(config('mail.from.address'), ucwords(config('mail.from.name')));
                            $message->to($userData['email'], $userData['fullname'])
                                ->subject(config('app.siteName').' Event Report');
                        });
            }
        } else {
            return "No Active Event Found Or Event has not expired yet";    
        }
        
    }
}
