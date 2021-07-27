<?php

use App\Http\Controllers\api\ApiPostController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('posts', [ApiPostController::class, 'index']);
    Route::get('posts/{id}', [ApiPostController::class, 'show']);
    Route::post('posts/store', [ApiPostController::class, 'store']);
    Route::put('posts/update', [ApiPostController::class, 'update']);
    Route::delete('posts/{id}', [ApiPostController::class, 'destroy']);
});


