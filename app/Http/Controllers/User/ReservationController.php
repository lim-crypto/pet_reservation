<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\Pet;
use App\Model\Reservation;
use App\Model\User;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(4);
        foreach ($reservations as $reservation) {
            $reservation->pet->images = json_decode($reservation->pet->images);
        }
        return view('user.reservations.index', compact('reservations'));
    }
    public function show(Reservation $reservation)
    {
        $reservation->pet->images = json_decode($reservation->pet->images);
        return view('user.reservations.show', compact('reservation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Pet $pet)
    {
        return view('user.reservations.create', compact('pet'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reservation = new Reservation;
        $reservation->pet_id = $request->pet_id;
        $reservation->user_id = auth()->user()->id;
        $reservation->date = date('Y-m-d H:i:s', strtotime($request->date));
        $reservation->expiration_date = date('Y-m-d H:i:s', strtotime("+7 day", strtotime(now())));
        $reservation->save();
        // update pet status
        $pet = Pet::find($request->pet_id);
        $pet->status = 'not available';
        $pet->user_id= auth()->user()->id;
        $pet->save();
        // update user information
        $user = User::find(auth()->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->contact_number = $request->contact_number;
        $user->save();


        return redirect()->route('user.reservations')->with('success', 'Reservation Added Successfully');
    }
    // update
    public function update(Request $request, Reservation $reservation)
    {
        $reservation->date = date('Y-m-d H:i:s', strtotime($request->date));
        $reservation->expiration_date = date('Y-m-d H:i:s', strtotime("+7 day", strtotime(now())));
        $reservation->save();
        return redirect()->route('user.reservations')->with('success', 'Reservation Updated Successfully');
    }


    // cancel reservation
    public function cancel(Reservation $reservation)
    {
        if ($reservation->status == 'pending') {
            $reservation->status = 'cancelled';
            $reservation->save();
            $pet = Pet::find($reservation->pet_id);
            $pet->status = 'available';
            $pet->user_id= null;
            $pet->save();

            return redirect()->back()->with('success', 'Reservation cancelled successfully');
        }
        return redirect()->back()->with('error', 'Reservation cannot be cancelled');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->status == 'pending' || $reservation->status == 'cancelled' || $reservation->status == 'rejected') {
            $reservation->delete();
            return redirect()->back()->with('success', 'Reservation Deleted successfully');
        }
    }
    public function getByStatus($status)
    {
        $reservations = Reservation::where('user_id', auth()->user()->id)->where('status', $status)->orderBy('created_at', 'desc')->paginate(4);

        foreach ($reservations as $reservation) {
            $reservation->pet->images = json_decode($reservation->pet->images);
        }
        session()->flash('status', $status);
        return view('user.reservations.index', compact('reservations')) ;
    }
}
