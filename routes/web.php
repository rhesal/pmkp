<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login',['type_menu' => '']);
});

Route::middleware(['auth','verified'])->group(function (){
    Route::get('home', function (){
        return view('pages.home',['type_menu' => '']);
    })->name('home')->middleware('can:pages');

    Route::get('edit-profile', function(){
        return view('pages.profile',['type_menu' => '']);
    })->name('profile.edit');

    Route::resource('user', UserController::class);
});
