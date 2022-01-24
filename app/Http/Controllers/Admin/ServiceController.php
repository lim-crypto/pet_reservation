<?php

namespace App\Http\Controllers\Admin;

use App\Model\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new Service;
        $service->service = $request->service;
        $service->description = $request->description;
        $service->image = $this->saveImage($request->service, $request->image);
        // offer and price
        $offers = $request->offer;
        $prices = $request->price;
        $offer_price = [];
        foreach ($offers as $key => $offer) {
            $offer_price[] = array(
                'offer' => $offer,
                'price' => $prices[$key]
            );
        }
        $service->offer = json_encode($offer_price);
        $service->save();
        return redirect()->route('services.index')->with('success', 'Successfully added service');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $service->offer = json_decode($service->offer);
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $service->service = $request->service;
        $service->description = $request->description;
        if ($request->image) {
            $service->image = $this->saveImage($request->service, $request->image);
        }
        // offer and price
        $offers = $request->offer;
        $prices = $request->price;
        $offer_price = [];
        foreach ($offers as $key => $offer) {
            $offer_price[] = array(
                'offer' => $offer,
                'price' => $prices[$key]
            );
        }
        $service->offer = json_encode($offer_price);
        $service->save();
        return redirect()->route('services.index')->with('success', 'Service Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {

        $this->deleteImage($service->image);
        $service->delete();
        return redirect()->back()->with('success',  ' Deleted Successfully');
    }

    // save image
    public function saveImage($service, $image)
    {
        if ($image) {
            $imageName = $service . '_' .  $image->getClientOriginalName();
            $image->storeAs('images/service', $imageName, 'public');
            return $imageName;
        }
        return;
    }
    // delete image
    public function deleteImage($image)
    {
        if ($image) {
            Storage::delete('/public/images/service/' . $image);
        }
        return;
    }
}
