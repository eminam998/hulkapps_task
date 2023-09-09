<?php

namespace App\Http\Controllers\Admin;

use App\Models\Movie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use App\Models\Genre;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.role:admin');
    }


    public function index(){
        $movies = Movie::paginate(10);

        return MovieResource::collection($movies);
    }

    public function show(Movie $movie){
        return new MovieResource($movie);
    }


    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'required|date',
            'rating' => 'required|integer',
            'photo' => 'required|url',
            'genres' => 'required'
        ]);


        // Create a new movie with the validated data
        $movie =  new Movie();

        $movie->title = $validatedData['title'];
        $movie->description = $validatedData['description'];
        $movie->release_date = $validatedData['release_date'];
        $movie->rating = $validatedData['rating'];
        //since I'm saving only a link of photo (somewhere fro the internet, I will not be saving a photo in storage)
        //if I were to upgrade this demo, I would put the storing of the image in storage, it's easy
        $movie->photo = $validatedData['photo'];
        $movie->slug = Str::slug($validatedData['title']);
        $movie->save();

        $genres = explode(',', $validatedData['genres']);

        // Trim each genre name to remove leading/trailing spaces
        $genres = array_map('trim', $genres);
        $genreIds = Genre::whereIn('name', $genres)->pluck('id');

        $movie->genres()->attach($genreIds);

        $data = new MovieResource($movie);

        return response()->json(['message' => 'Movie created successfully', 'data' => $data], 201);
    }



    public function update(Request $request, Movie $movie)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'required|date',
            'rating' => 'required|integer',
            'photo' => 'required|url',
            'genres' => 'required'
        ]);

        $movie->title = $validatedData['title'];
        $movie->description = $validatedData['description'];
        $movie->release_date = $validatedData['release_date'];
        $movie->rating = $validatedData['rating'];
        $movie->photo = $validatedData['photo'];
        $movie->slug = Str::slug($validatedData['title']);
        $movie->save();

        $genres = explode(',', $validatedData['genres']);

        // Trim each genre name to remove leading/trailing spaces
        $genres = array_map('trim', $genres);
        $genreIds = Genre::whereIn('name', $genres)->pluck('id');

        $movie->genres()->sync($genreIds);

        $data = new MovieResource($movie);

        return response()->json(['message' => 'Movie edited successfully', 'data' => $data], 201);
    }

    public function delete(Movie $movie){
        $movie->delete();

        return response()->json(['message' => 'Movie deleted successfully'], 201);

    }
}
