<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KuliahController;
use App\Http\Middleware\DisableCsrfForSpecificRoutes;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/nilai-mahasiswa', [KuliahController::class, 'getAllNilai']);

Route::get('/nilai-mahasiswa/{nim}', [KuliahController::class, 'getNilaiByNim']);

Route::post('/add-nilai-mahasiswa', [KuliahController::class, 'addNilai']);
