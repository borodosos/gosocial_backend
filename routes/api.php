<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
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

Route::resource('messages', MessageController::class)->middleware('auth:api');
Route::resource('sessions', RoomController::class)->middleware('auth:api');

// === Auth ===
Route::post('registration', [AuthController::class, 'registration']);
Route::post('login', [AuthController::class, 'login']);
Route::get('refresh', [AuthController::class, 'refresh']);
Route::get('google/login', [GoogleController::class, 'redirectToGoogle']);
