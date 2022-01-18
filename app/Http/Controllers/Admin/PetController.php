<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PetRequest;
use App\Model\Breed;
use App\Model\Pet;
use App\Model\Type;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pets = Pet::all();

        return view('admin.pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $breeds = Breed::all();
        return view('admin.pets.create', compact('types', 'breeds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PetRequest $request)
    {
        $images = $this->saveImages($request->images);

        $pet = new Pet;
        $pet->type_id = $this->getTypeId($request->type);
        $pet->breed_id = $this->getBreedId($request->breed, $request->type);
        $pet->name = $request->name;
        $pet->gender = $request->gender;
        $pet->price = $request->price;
        $pet->status = $request->status;
        $pet->birthday = Carbon::parse($request->birthday)->format('Y-m-d');
        $pet->weight = $request->weight;
        $pet->height = $request->height;
        $pet->images  = json_encode($images);
        $pet->save();   // save to get slug ,
        $pet->description =  $this->getDescription($request->description, $pet->slug);
        $pet->save();
        return redirect()->route('pets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        $years = Carbon::parse($pet->birthday)->age;
        if ($years == 0) {
            $age = Carbon::createFromDate($pet->birthday)->diff(Carbon::now())->format('%m months and %d days');
        } else {
            $age = Carbon::createFromDate($pet->birthday)->diff(Carbon::now())->format('%y years, %m months and %d days');
        }
        $pet->images = json_decode($pet->images);
        return view('admin.pets.show', compact('pet', 'age'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        $types = Type::all();
        $breeds = Breed::all();
        $pet->images = json_decode($pet->images);
        return view('admin.pets.edit', compact('pet', 'types', 'breeds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pet $pet)
    {
        if ($request->has('images')) {
            $this->deleteImages($pet->images);
            $images = $this->saveImages($request->images);
            $pet->images  = json_encode($images);
        }

        $pet->breed_id = $this->getBreedId($request->breed, $request->type);
        $pet->name = $request->name;
        $pet->gender = $request->gender;
        $pet->price = $request->price;
        $pet->status = $request->status;
        $pet->birthday = Carbon::parse($request->birthday)->format('Y-m-d');
        $pet->weight = $request->weight;
        $pet->height = $request->height;
        $pet->description =  $this->getDescription($request->description, $pet->slug);
        $pet->save();
        return redirect()->route('pets.index')->with('success', 'Pet updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        if ($pet->reservation == null) {
            $this->deleteImages($pet->images);
            $this->deleteDescriptionImages($pet->slug);
            $pet->delete();
            return redirect()->route('pets.index')->with('success', 'Pet deleted successfully');
        }
        return redirect()->route('pets.index')->with('error', 'Cannot delete pet,  Pet has a reservation');
    }
    public function getBreedId($breed, $type)
    {
        $old_breed = Breed::where('name', $breed)->first();
        if ($old_breed) {
            return $old_breed->id;
        } else {
            $new_breed = new Breed;
            $new_breed->name = $breed;
            $new_breed->type_id = $this->getTypeId($type);
            $new_breed->save();
            return $new_breed->id;
        }
    }
    public function getTypeId($type)
    {
        $old_type = Type::where('name', $type)->first();
        if ($old_type) {
            return $old_type->id;
        } else {
            $new_type = new Type;
            $new_type->name = $type;
            $new_type->save();
            return $new_type->id;
        }
    }

    public function saveImages($images)
    {
        $image_names = [];
        foreach ($images as $image) {
            $imageName = Str::random(10) . '_' .  $image->getClientOriginalName();
            $image->storeAs('images/pets', $imageName, 'public');
            $image_names[] = $imageName;
        }
        return $image_names;
    }
    public function deleteImages($images)
    {
        if ($images) {
            $images = json_decode($images);
            foreach ($images as $image) {
                Storage::delete('/public/images/pets/' . $image);
            }
        }
        return;
    }
    //save description image in database and return path
    public function getDescription($description, $slug)
    {
        if ($description == null) {
            return null;
        }

        $path = 'storage/images/pets/' . $slug;
        if (!file_exists($path)) {
            $files = new Filesystem;
            $files->makeDirectory($path);
        }
        //Prepare HTML & ignore HTML errors
        $dom = new \domdocument();
        $dom->loadHtml($description, LIBXML_NOWARNING | LIBXML_NOERROR);

        //identify img element
        $images = $dom->getelementsbytagname('img');
        $image_names = [];
        //loop over img elements, decode their base64 source data (src) and save them to folder,
        //and then replace base64 src with stored image URL.
        foreach ($images as $k => $img) {

            //collect img source data
            $data = $img->getattribute('src');

            //checking if img source data is image by detecting 'data:image' in string
            if (strpos($data, 'data:image') !== false) {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);

                //decode base64
                $data = base64_decode($data);

                //naming image file
                $image_name = time() . rand(000, 999) . $k . '.png';
                // image path (path) to use upload file to
                $image_path = $path . '/' . $image_name;
                //image path (path2) to save to DB so that summernote can display image in edit mode (When editing summernote content) NB: the difference btwn path and path2 is the forward slash "/" in path2
                $path2 = '/storage/images/pets/' .  $slug . '/' . $image_name;
                $image_names[] = $path2;
                file_put_contents($image_path, $data);
                // modify image source data in summernote content before upload to DB
                $img->removeattribute('src');
                $img->setattribute('src', $path2);
            } else {
                $image_names[] = $data; //if not data:image, just save the image source data to array // expected to be the image path of previous upload
            }
        }

        // to delete images on update if not in summernote content
        if ($image_names) {
            $saved_images = glob($path . '/*'); // get all file names saved in specified folder
            // remove the first / in image names to match the image path in storage
            foreach ($image_names as $key => $image_name) {
                $image_names[$key] = substr($image_name, 1);
            }
            // compare the file names in specified folder and the file names in summernote content
            $result = array_diff($saved_images, $image_names);
            foreach ($result as $image) {
                // delete the file if not in summernote content or  has been deleted in summernote content
                unlink($image);
            }
        }
        // final variable to store in DB
        $description = $dom->savehtml();
        return $description;
    }


    public function deleteDescriptionImages($slug)
    {
        $path = 'storage/images/pets/' . $slug;
        if (file_exists($path)) {
            $files = new Filesystem;
            $files->deleteDirectory($path);
        }
    }
}
