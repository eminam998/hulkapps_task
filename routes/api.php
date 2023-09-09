<?php

use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\MovieController as UserMovieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});


Route::group([
    'middleware' => 'auth.role:admin',
    'prefix' => 'admin'
], function ($router) {
    Route::group(['prefix' => 'movies'], function () {
        Route::get('/', [MovieController::class, 'index']);
        Route::get('/{movie}', [MovieController::class, 'show']);
        Route::post('/add', [MovieController::class, 'store']);
        Route::put('/edit/{movie}', [MovieController::class, 'update']);
        Route::post('/delete/{movie}', [MovieController::class, 'delete']);
    }); 

    Route::group(['prefix' => 'genres'], function () {
        Route::get('/', [GenreController::class, 'index']);
        Route::get('/{genre}', [GenreController::class, 'show']);
        Route::post('/add', [GenreController::class, 'store']);
        Route::put('/edit/{genre}', [GenreController::class, 'update']);
        Route::post('/delete/{genre}', [GenreController::class, 'delete']);
    }); 
});



Route::group([
    'middleware' => 'auth.role:user',
    'prefix' => 'movies'
], function ($router) {
    Route::get('/', [UserMovieController::class, 'index']);
    Route::post('/search', [UserMovieController::class, 'search']);
    Route::get('/{movie}', [UserMovieController::class, 'show']);
    Route::post('/add-to-favorites', [UserMovieController::class, 'addToFavorites']);
    Route::post('/remove-from-favorites', [UserMovieController::class, 'removeFromFavorites']);


});