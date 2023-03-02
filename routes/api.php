<?php

use App\Events\PlaygroundEvent;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::resource('users', UserController::class)->middleware('auth:api');
Route::resource('posts', PostController::class)->middleware('auth:api');
Route::resource('posts.comments', CommentController::class)->shallow()->middleware('auth:api');

Route::get('playground', function () {
    event(new PlaygroundEvent());
    return response()->json('aboba');
});


// === Auth ===
Route::post('registration', [AuthController::class, 'registration']);
Route::post('login', [AuthController::class, 'login']);
Route::get('refresh', [AuthController::class, 'refresh']);
Route::get('google/login', [GoogleController::class, 'redirectToGoogle']);
