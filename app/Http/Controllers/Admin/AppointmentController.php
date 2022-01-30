<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return view('admin.appointments.index', compact('appointments'));
    }
    public function status(Request $request, Appointment $appointment)
    {
        $appointment->status = $request->status;
        $appointment->save();
        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function appointmentByStatus($status)
    {
        $appointments = Appointment::where('status', $status)->get();
        return view('admin.appointments.index', compact('appointments'));
    }
}
