<?php

namespace App\Http\Controllers;

use App\Model\Pet;
use App\Model\Service;
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
    public function serviceDetails(Service $service)
    {
        $service->offer = json_decode($service->offer);
        return view('services.show', compact('service'));
    }


}
