<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
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
    Route::get('dashboard', function (){
        return view('pages.dashboard',['type_menu' => 'dashboard']);
    })->name('dashboard')->middleware(['can:home']);

    Route::get('home', function (){
        return view('pages.home',['type_menu' => 'dashboard']);
    })->name('home')->middleware(['can:home']);

    Route::get('edit-profile', function(){
        return view('pages.profile',['type_menu' => '']);
    })->name('profile.edit');

    Route::resource('user', UserController::class);
    Route::resource('unit', MasterUnitController::class);

    Route::get('/homes', [MasterUnitController::class, 'home']);
    Route::get('/list-homes', [MasterUnitController::class, 'listHome'])->name('unit.listHome');
    Route::get('/getUnit', [MasterUnitController::class, 'getUnit'])->name('getUnit');
    Route::post('/unit-create', [MasterUnitController::class, 'create']);
    Route::post('/unit-store', [MasterUnitController::class, 'store']);
    Route::get('/unit-edit', [MasterUnitController::class, 'edit']);
    Route::put('/unit-update/{id}', [MasterUnitController::class, 'update']);
    Route::delete('/unit-destroy/{id}', [MasterUnitController::class, 'destroy'])->name('unit.delete');

    Route::resource('indikator', MasterIndikatorController::class)->middleware(['can:indikators']);
    Route::get('/indikator-store', [MasterIndikatorController::class, 'store'])->middleware(['can:indikators']);
    Route::get('/indikator-create', [MasterIndikatorController::class, 'create'])->middleware(['can:indikators']);
    Route::delete('/indikator-destroy/{id}', [MasterIndikatorController::class, 'destroy'])->middleware(['can:indikators']);
    Route::get('indikator-show/{id}', [MasterIndikatorController::class, 'show'])->middleware(['can:indikators']);
    Route::get('indikatorbyunit/{id}', [MasterIndikatorController::class, 'indikatorByUnit'])->middleware(['can:indikators']);
    Route::get('indikator-edit', [MasterIndikatorController::class, 'edit'])->middleware(['can:indikators']);
    Route::put('indikator-update/{id}', [MasterIndikatorController::class, 'update'])->middleware(['can:indikators']);

    // Route::resource('penilaian', PenilaianController::class)->middleware(['can:home']);
    Route::get('penilaian', function(){ return view('pages.hasil-penilaian-mutu',['type_menu' => '']);})->name('penilaian.index')->middleware(['can:home']);
    Route::get('penilaian/{id}', [PenilaianController::class, 'tampil'])->name('penilaian.tampil')->middleware(['can:home']);
    Route::get('penilaian-show', [PenilaianController::class, 'show'])->name('penilaian.show')->middleware(['can:home']);
    Route::post('rekap', [PenilaianController::class, 'rekap'])->name('penilaian.rekap')->middleware(['can:home']);
    Route::post('rekapitulasi/{id}', [PenilaianController::class, 'rekapitulasi'])->name('penilaian.rekapitulasi')->middleware(['can:home']);
    Route::get('chart', [PenilaianController::class, 'chart'])->name('chart')->middleware(['can:home']);
    Route::post('/penilaian-store', [PenilaianController::class, 'store'])->middleware(['can:home']);
    Route::put('/penilaian-update/{id}', [PenilaianController::class, 'update'])->middleware(['can:home']);
    Route::delete('/penilaian-destroy/{id}', [PenilaianController::class, 'destroy'])->middleware(['can:home']);
    //Route::post('/penilaian-store', 'App\Http\Controllers\PenilaianController@store');
    //Route::post('/my-controller-method', [PenilaianController::class, 'myMethod']);
    //Route::get('penilaian-show/{id}', [PenilaianController::class, 'show'])->name('penilaian.show');
});
