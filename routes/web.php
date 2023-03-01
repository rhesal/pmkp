<?php

use App\Http\Controllers\MasterIndikatorController;
use App\Http\Controllers\MasterUnitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\Master_unit;

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
    Route::resource('unit', MasterUnitController::class);
    Route::get('/unit-create', [MasterUnitController::class, 'create']);
    Route::post('/unit-store', [MasterUnitController::class, 'store']);

    Route::resource('indikator', MasterIndikatorController::class);
});
