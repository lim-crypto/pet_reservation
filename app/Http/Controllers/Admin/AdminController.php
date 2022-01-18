<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Appointment;
use App\Model\Reservation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        $reservation = Reservation::all();

        $events = [];
        foreach ($appointments as $appointment) {
            $events[] = \Calendar::event(
                $appointment->user->getName().' '.$appointment->purpose, //event title
                false, //full day event?
                new \DateTime($appointment->date), //start time (you can also use Carbon instead of DateTime)
                new \DateTime($appointment->date), //end time (you can also use Carbon instead of DateTime)
                'stringEventId' //optionally, you can specify an event ID
            );
        }
        foreach ($reservation as $res) {
            $events[] = \Calendar::event(
                $res->user->getName().' ',
                false,
                new \DateTime($res->expiration_date),
                new \DateTime($res->expiration_date),
                'stringEventId'
            );
        }





        $calendar = \Calendar::addEvents($events) ;//add an array with addEvents
        return view('admin.dashboard',  compact('calendar'));
    }
}
