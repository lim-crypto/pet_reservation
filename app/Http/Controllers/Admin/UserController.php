<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;
use App\Helper\Helper;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::all()->except(auth()->user()->id); // except admin
        $users = User::where('is_admin', 0)->get();
        return view('admin.users.index', compact('users'));
    }
    public function ban(User $user)
    {
        $user->is_active = false;
        $user->save();
        // cancel user reservations
        foreach ($user->reservations as $reservation) {
            if ($reservation->date > now()->format('Y-m-d H:i:s')) {
                $reservation->status = 'cancelled';
                $reservation->save();
                Helper::updatePetStatus($reservation->pet_id, 'cancelled');
            }
        }
        // cancel  user appointments
        foreach ($user->appointments as $appointment) {
            if ($appointment->date > now()->format('Y-m-d H:i:s')) {
                $appointment->status = 'cancelled';
                $appointment->save();
            }
        }
        return redirect()->back()->with('success', 'User successfully banned');
    }
}
