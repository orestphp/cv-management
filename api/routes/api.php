<?php

use App\Http\Controllers\CvController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// for authorised users
Route::group(['middleware' => ['auth:sanctum']], function() {

    // Update user
    Route::post('/user/update-password', [UserController::class, 'updatePassword']);

    // CV CRUD
    Route::resource('cv', CvController::class)->except(['update']);
    Route::post('/cv/{cv}', [CvController::class, 'update']);
});
