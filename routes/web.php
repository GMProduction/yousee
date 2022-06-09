<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\MasterPelangganController;
use App\Http\Controllers\TipeController;
use App\Http\Controllers\TitikController;
use App\Http\Controllers\UserController;
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
    return view('auth.login');
});

Route::get('/admin', function () {
    return view('login.beranda');
});


Route::get('/admin/user', function () {
    return view('admin.user');
});

Route::get('/admin', [BerandaController::class, 'index']);
Route::get('/admin/beranda', [BerandaController::class, 'index']);
Route::get('/admin/user', [UserController::class, 'index']);
Route::get('/admin/tipe', [TipeController::class, 'index']);
Route::get('/admin/titik', [TitikController::class, 'index']);
Route::get('/admin/masterbarang', [MasterBarangController::class, 'index']);
Route::get('/admin/masterpelanggan', [MasterPelangganController::class, 'index']);

Route::get('/login', [LoginController::class, 'index']);
Route::get('/daftar', [DaftarController::class, 'index']);
Route::post('/daftar', [DaftarController::class, 'store']);

Route::get('/cek-map', [\App\Http\Controllers\MapController::class, 'index']);
Route::get('/cek-map/data', [\App\Http\Controllers\MapController::class, 'get_map_json']);
