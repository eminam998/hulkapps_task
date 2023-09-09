<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.role:admin');
    }
    
    public function index(){
        $genres = Genre::paginate(5);

        return GenreResource::collection($genres);
    }

    public function show(Genre $genre){
        return new GenreResource($genre);
    }

    public function store(Request $request){
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
        ]);


        // Create a new genre with the validated data
        $genre =  new Genre();

        $genre->name = $validatedData['name'];
        $genre->save();

        $data = new GenreResource($genre);

        return response()->json(['message' => 'Genre created successfully', 'data' => $data], 201);
    }


    public function update(Request $request, Genre $genre){
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
        ]);
        $genre->name = $validatedData['name'];
        $genre->save();

        $data = new GenreResource($genre);

        return response()->json(['message' => 'Genre edited successfully', 'data' => $data], 201);
    }


    public function delete(Genre $genre){
        $genre->delete();
        return response()->json(['message' => 'Genre deleted successfully'], 201);
    }
}
