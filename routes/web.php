<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/private', function () {
    return response('Welcome! You are logged in.');
})->middleware('auth');

Route::get('/user', function () {
    if (! auth()->check()) {
        return response('You are not logged in.');
    }

    $user = auth()->user();
    $name = $user->name ?? 'User';
    $email = $user->email ?? '';

    return response("Hello {$name}! Your email address is {$email}.");
});
