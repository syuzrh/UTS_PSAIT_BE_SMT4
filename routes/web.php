<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KuliahController;
use App\Http\Middleware\DisableCsrfForSpecificRoutes;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/nilai-mahasiswa', [KuliahController::class, 'getAllNilai']);

Route::get('/api/nilai-mahasiswa/{nim}', [KuliahController::class, 'getNilaiByNim']);

Route::get('/api/nilai-perkuliahan/{id_perkuliahan}', [KuliahController::class, 'getNilaiByIdPerkuliahan']);

Route::post('/api/add-nilai-mahasiswa', [KuliahController::class, 'addNilai']);

Route::put('/api/update-nilai-mahasiswa/{nim}/{kode_mk}', [KuliahController::class, 'updateNilai']);

Route::delete('/api/delete-nilai-mahasiswa/{nim}/{kode_mk}', [KuliahController::class, 'deleteNilai']);

