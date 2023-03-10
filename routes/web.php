<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\MasterUnitController;
use App\Http\Controllers\MasterIndikatorController;

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
    })->name('home')->middleware(['can:pages','can:home']);

    Route::get('edit-profile', function(){
        return view('pages.profile',['type_menu' => '']);
    })->name('profile.edit');

    Route::resource('user', UserController::class);
    Route::resource('unit', MasterUnitController::class);
    Route::get('/unit-create', [MasterUnitController::class, 'create']);
    Route::post('/unit-store', [MasterUnitController::class, 'store']);
    Route::get('/unit-destroy/{id}', [MasterUnitController::class, 'destroy']);
    //Route::delete('/unit-destroy/{id}', [MasterUnitController::class, 'destroy'])->name('unit.delete');

    Route::resource('indikator', MasterIndikatorController::class);
    Route::post('/indikator-store', [MasterIndikatorController::class, 'store']);
    Route::get('/indikator-destroy/{id}', [MasterIndikatorController::class, 'destroy']);
    //Route::get('indikator/{id}', [MasterIndikatorController::class, 'show'])->name('indikator.show');

    Route::resource('penilaian', PenilaianController::class);
    //Route::post('/my-controller-method', [PenilaianController::class, 'myMethod']);
    Route::post('/penilaian-store', [PenilaianController::class, 'store']);
    //Route::post('/penilaian-store', 'App\Http\Controllers\PenilaianController@store');
});
