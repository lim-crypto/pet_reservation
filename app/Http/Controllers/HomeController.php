<?php

namespace App\Http\Controllers;

use App\Model\Pet;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // services
    public function services()
    {
        return view('services.index');
    }
    public function grooming()
    {
        return view('services.grooming');
    }
    public function petBoarding()
    {
        return view('services.petboarding');
    }
    public function breeding()
    {
        return view('services.breeding');
    }
    public function about()
    {
        return view('about');
    }

}
