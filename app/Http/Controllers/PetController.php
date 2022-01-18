<?php

namespace App\Http\Controllers;

use App\Model\Breed;
use App\Model\Pet;
use App\Model\Type;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::where('status', 'available')->paginate(16);
        foreach ($pets as $pet) {
            $pet->images = json_decode($pet->images);
        }
        return view('pets.index', compact('pets'));
    }
    public function show(Pet $pet)
    {
        $pet->images = json_decode($pet->images);
        return view('pets.show', compact('pet'));
    }
    public function getByType(Type $type)
    {
        $pets = Pet::where('type_id', $type->id)->where('status', 'available')->paginate(16);
        foreach ($pets as $pet) {
            $pet->images = json_decode($pet->images);
        }
        return view('pets.index', compact('pets'));
    }
    public function getByBreed(Breed $breed)
    {
        $pets = Pet::where('breed_id', $breed->id)->where('status', 'available')->paginate(16);
        foreach ($pets as $pet) {
            $pet->images = json_decode($pet->images);
        }
        return view('pets.index', compact('pets'));
    }

}
