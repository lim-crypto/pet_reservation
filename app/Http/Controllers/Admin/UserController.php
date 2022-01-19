<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;

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
        return redirect()->back()->with('success', 'User successfully banned');
    }
}
