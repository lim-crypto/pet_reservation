<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        return view('admin.types.index', compact('types'));
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
        ]);
        $type = new Type;
        $type->name = $request->name;
        $type->save();

        return redirect()->route('type.index')->with('success', $type->name . ' Added Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $type->name = $request->name;
        $type->save();

        return redirect()->route('type.index')->with('success', $type->name . ' Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {

        if ($type->breed->count() > 0) {
            return redirect()->route('type.index')->with('error', $type->name . ' Cannot be delete');
        }
        $type->delete();
        return redirect()->route('type.index')->with('success', $type->name . ' Deleted Successfully');
    }

}
