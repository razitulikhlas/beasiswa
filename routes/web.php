<?php

use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KriteriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SiswaController;

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

Route::get('login', [LoginController::class, 'index']);
Route::get('dashboard', [DashboardController::class, 'index']);
Route::resource('/siswa', SiswaController::class);
Route::resource('/jurusan', JurusanController::class);
Route::resource('/prodi', ProdiController::class);
Route::resource('/kriteria', KriteriaController::class);
Route::resource('/beasiswa', BeasiswaController::class);
Route::resource('/data', BeasiswaController::class);
Route::resource('/semester', SemesterController::class);

Route::get('/', function () {
    return view('welcome');
});
