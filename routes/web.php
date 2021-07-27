<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SocialiteAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('users/{id}', [UserController::class, 'show'])->where('id', '[0-9]+');


// posts
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/latest', [PostController::class, 'latest']);

Route::get('posts/{id}', [PostController::class, 'show'])->where('id', '[0-9]+');

Route::get('posts/search/{keyword}', [PostController::class, 'search']);
Route::post('posts/search', [PostController::class, 'validateSearch']);


Route::middleware('isLogged')->group(function () {

    // posts
    Route::get('posts/create', [PostController::class, 'create']);
    Route::post('posts/store', [PostController::class, 'store']);

    Route::get('posts/edit/{id}', [PostController::class, 'edit']);
    Route::post('posts/update', [PostController::class, 'update']);

    Route::get('posts/delete/{id}', [PostController::class, 'destroy']);

});

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {

    $user = Socialite::driver('github')->user();

});

Route::get('/auth/google', 'App\Http\Controllers\SocialiteAuthController@googleRedirect');

Route::get('auth/google/callback', 'App\Http\Controllers\SocialiteAuthController@loginWithGoogle');






