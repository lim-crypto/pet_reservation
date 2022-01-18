<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Breed;
use App\Model\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BreedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breeds = Breed::all();
        $types = Type::all();
        return view('admin.breeds.index', compact('breeds', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        return view('admin.breeds.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'type_id' => 'required',
        ]);

        $breed = new Breed;
        $breed->name = $request->name;
        $breed->type_id = $request->type_id;
        $breed->save();
        return redirect()->route('breed.index')->with('success', $breed->name . ' Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Breed  $breed
     * @return \Illuminate\Http\Response
     */
    public function show(Breed $breed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Breed  $breed
     * @return \Illuminate\Http\Response
     */
    public function edit(Breed $breed)
    {
        $types = Type::all();
        return view('admin.breeds.edit', compact('breed', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Breed  $breed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Breed $breed)
    {
        $this->validate($request, [
            'name' => 'required',
            'type_id' => 'required',
        ]);

        $breed->name = $request->name;
        $breed->type_id = $request->type_id;
        $breed->save();
        return redirect()->route('breed.index')->with('success', $breed->name . ' Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Breed  $breed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Breed $breed)
    {
        if ($breed->pets->count() > 0) {
            return redirect()->route('breed.index')->with('error', $breed->name . ' Cannot be delete');
        }
        $breed->delete();
        return redirect()->route('breed.index')->with('success', $breed->name . ' Deleted Successfully');
    }
}
