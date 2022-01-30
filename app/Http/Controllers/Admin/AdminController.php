<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Appointment;
use App\Model\Pet;
use App\Model\Reservation;
use App\Model\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        $reservations = Reservation::all();

        $events = [];
        foreach ($appointments as $appointment) {
            $events[] = \Calendar::event(
                $appointment->user->getName() . ' ' . $appointment->purpose, //event title
                false, //full day event?
                new \DateTime($appointment->date), //start time (you can also use Carbon instead of DateTime)
                new \DateTime($appointment->date), //end time (you can also use Carbon instead of DateTime)
                'stringEventId' //optionally, you can specify an event ID
            );
        }
        foreach ($reservations as $reservation) {
            $events[] = \Calendar::event(
                $reservation->user->getName() . ' ',
                false,
                new \DateTime($reservation->expiration_date),
                new \DateTime($reservation->expiration_date),
                'stringEventId'
            );
        }
        // get latest reservations and appointments
        $latestReservations = Reservation::orderBy('created_at', 'desc')->take(5)->get();
        $latestAppointments = Appointment::orderBy('created_at', 'desc')->take(5)->get();
        $reservation = Reservation::all()->count();
        $appointment = Appointment::all()->count();
        $pets = Pet::all()->count();
        $users = User::all()->count();
        $calendar = \Calendar::addEvents($events); //add an array with addEvents
        return view('admin.dashboard',  compact('calendar', 'reservation', 'appointment', 'pets', 'users','latestReservations', 'latestAppointments'));
    }
}
