<?php

use App\Http\Controllers\AhpController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\CategoryBeasiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataBeasiswaController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KriteriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SubkriteriaController;
use App\Http\Controllers\UserController;

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


Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::resource('/siswa', SiswaController::class);
    Route::resource('/jurusan', JurusanController::class);
    Route::resource('/prodi', ProdiController::class);
    Route::resource('/kriteria', KriteriaController::class);
    Route::resource('/subkriteria', SubkriteriaController::class);
    Route::post('/isactive/{id}', [KriteriaController::class, 'isactive']);
    Route::resource('/kategoribeasiswa', CategoryBeasiswaController::class);
    Route::resource('/databeasiswa', DataBeasiswaController::class);
    Route::resource('/semester', SemesterController::class);
    Route::resource('/hasil', HasilController::class);
    Route::resource('/user', UserController::class);
    Route::resource('/auth', AuthController::class);
    Route::post('matrikkriteria', [AhpController::class, 'matrikkriteria']);
    Route::post('matrikalternatif', [AhpController::class, 'matrikalternatif']);
    Route::post('alternatif/{no}', [AhpController::class, 'showAlternatif']);
    Route::post('rangking', [AhpController::class, 'hasil']);
    Route::resource('/ahp', AhpController::class);
});

Route::get('/login', [LoginController::class, 'index']);
Route::post('login', [LoginController::class, 'store']);

Route::get('logout', [AuthController::class, 'logout']);


Route::get('/', function () {
    return redirect('/login');
});
