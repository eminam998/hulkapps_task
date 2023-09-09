<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.role:user');
    }

    public function index(){
        $movies = Movie::paginate(10);

        return MovieResource::collection($movies);
    }

    public function show(Movie $movie){
        return new MovieResource($movie);
    }


    public function search(Request $request){
        $movies = Movie::query();

        // Filter by release date
        if ($request->has('release_date')) {
            $movies->whereDate('movies.release_date', '=', $request->input('release_date'));
        }

        // Filter by rating
        if ($request->has('rating')) {
            $movies->where('movies.rating', '>=', $request->input('rating'));
        }

        // Filter by genres (assuming genre IDs are sent as an array)
        if ($request->has('genres')) {
            $genreIds = explode(',',$request->input('genres'));
            $movies->whereHas('genres', function ($query) use ($genreIds) {
                $query->whereIn('genres.id', $genreIds);
            });
        }

        // Search by title and description
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $movies->where(function ($query) use ($searchTerm) {
                $query->where('movies.title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('movies.description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Get the filtered movies
        $filteredMovies = $movies->paginate($request->input('pageSize'));


        return MovieResource::collection($filteredMovies);


    }


    public function addToFavorites(Request $request){
        $user = auth()->user();
        $movieId = $request->input('movieId');

        $user->favorites()->attach($movieId);

        return response()->json(['message' => 'Added to favorites successfully'], 201);
    }


    public function removeFromFavorites(Request $request){
        $user = auth()->user();
        $movieId = $request->input('movieId');

        $user->favorites()->detach($movieId);

        return response()->json(['message' => 'Removed from favorites successfully'], 201);

    }
}
