<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\Appointment;
use App\Model\Service;
use App\Model\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $appointments = auth()->user()->appointments;
        $events = [];
        foreach ($appointments as $appointment) {
            if ($appointment->status != 'cancelled') {
                $events[] = \Calendar::event(
                    $appointment->purpose, //event title
                    false, //full day event?
                    new \DateTime($appointment->date), //start time (you can also use Carbon instead of DateTime)
                    new \DateTime($appointment->date), //end time (you can also use Carbon instead of DateTime)
                    'stringEventId' //optionally, you can specify an event ID
                );
            }
        }

        $calendar = \Calendar::addEvents($events); //add an array with addEvents
        return view('user.appointments.index', compact('appointments', 'calendar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        foreach ($services as $service) {
            $service->offer = json_decode($service->offer);
        }
        $appointments = Appointment::all();
        $dates = [];
        $booked = [];
        $disabledDates = [];
        foreach ($appointments as $appointment) {
            $dates[] = $appointment->date;
            $booked[] = date('Y-m-d', strtotime($appointment->date));
        }
        $booked = array_count_values($booked);
        foreach ($booked as $key => $value) {
            if ($value > 7) {
                $disabledDates[] = $key;
            }
        }
        $disabledDates = json_encode($disabledDates);
        $dates = json_encode($dates);
        return view('user.appointments.create', compact('dates', 'services', 'disabledDates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $appointment = new Appointment;
        $appointment->user_id = auth()->user()->id;
        $appointment->purpose = $request->purpose;
        $appointment->date = date('Y-m-d H:i:s', strtotime("$request->date $request->time"));
        $appointment->save();
        $user = User::find(auth()->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->contact_number = $request->contact_number;
        $user->save();
        return redirect()->route('user.appointments')->with('success', 'Appointment created successfully');
    }

    // cancel
    public function cancel(Appointment $appointment)
    {
        $appointment->status = 'cancelled';
        $appointment->save();
        return redirect()->route('user.appointments')->with('success', 'Appointment cancelled successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
