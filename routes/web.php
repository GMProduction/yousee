<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\MasterPelangganController;
use App\Http\Controllers\TipeController;
use App\Http\Controllers\TitikController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
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

Route::match(['POST', 'GET'], '/', [LoginController::class, 'index'])->middleware('guest');

Route::prefix('pimpinan')->middleware(\App\Http\Middleware\PimpinanMiddleware::class)->group(
    function (){
        Route::get('', [\App\Http\Controllers\PimpinanController::class, 'index']);
//        Route::get('province', [\App\Http\Controllers\ProvinceController::class, 'province']);
//        Route::get('province/{id}/city', [\App\Http\Controllers\ProvinceController::class, 'city']);
//        Route::get('/city', [\App\Http\Controllers\ProvinceController::class, 'cityAll']);
//        Route::get('user', [UserController::class, 'index']);
//        Route::prefix('type')->group(
//            function () {
//                Route::match(['POST', 'GET'], '', [TipeController::class, 'index']);
//                Route::get('datatable', [TipeController::class, 'datatable']);
//            }
//        );
    }

);


Route::prefix('data')->middleware('auth')->group(function (){
    Route::get('province', [\App\Http\Controllers\ProvinceController::class, 'province']);
    Route::get('province/{id}/city', [\App\Http\Controllers\ProvinceController::class, 'city']);
    Route::get('city', [\App\Http\Controllers\ProvinceController::class, 'cityAll']);
    Route::get('type', [\App\Http\Controllers\ItemController::class, 'getType']);

});
Route::prefix('admin')->middleware(\App\Http\Middleware\AdminMiddleware::class)->group(
    function () {
        Route::get('', [BerandaController::class, 'index']);

        Route::prefix('item')->group(
            function () {
                Route::get('datatable', [\App\Http\Controllers\ItemController::class, 'datatable']);
                Route::get('card', [\App\Http\Controllers\ItemController::class, 'cardItem']);
                Route::post('post-item', [\App\Http\Controllers\ItemController::class, 'postItem']);
                Route::get('url-street-view/{id}', [\App\Http\Controllers\ItemController::class, 'getUrlStreetView']);
            }
        );
//        Route::get('province', [\App\Http\Controllers\ProvinceController::class, 'province']);
//        Route::get('province/{id}/city', [\App\Http\Controllers\ProvinceController::class, 'city']);
//        Route::get('/city', [\App\Http\Controllers\ProvinceController::class, 'cityAll']);
        Route::get('user', [UserController::class, 'index']);
        Route::prefix('type')->group(
            function () {
                Route::match(['POST', 'GET'], '', [TipeController::class, 'index']);
                Route::get('datatable', [TipeController::class, 'datatable']);
            }
        );

        Route::prefix('vendor')->group(
            function () {
                Route::match(['POST', 'GET'], '', [VendorController::class, 'index']);
                Route::get('datatable', [\App\Http\Controllers\VendorController::class, 'datatable']);
                Route::get('all', [\App\Http\Controllers\VendorController::class, 'getVendor']);
            }
        );

        Route::prefix('titik')->group(function (){
            Route::get('', [TitikController::class, 'index']);
            Route::get('type', [\App\Http\Controllers\ItemController::class, 'getType']);
            Route::post('post-item', [\App\Http\Controllers\ItemController::class, 'postItem']);
            Route::get('datatable', [\App\Http\Controllers\ItemController::class, 'datatable']);
        });
        Route::get('history/{id}', [\App\Http\Controllers\HistoryController::class, 'getHistory']);
    }
);

Route::get('/admin/beranda', [BerandaController::class, 'index']);
Route::get('/admin/user', [UserController::class, 'index']);

Route::get('/admin/masterbarang', [MasterBarangController::class, 'index']);
Route::get('/admin/masterpelanggan', [MasterPelangganController::class, 'index']);

Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/daftar', [DaftarController::class, 'index']);
Route::post('/daftar', [DaftarController::class, 'store']);
Route::get('/map/data', [\App\Http\Controllers\MapController::class, 'get_map_json']);
Route::get('/map/data/{id}', [\App\Http\Controllers\MapController::class, 'get_map_by_id']);

Route::get('/cek-map', [\App\Http\Controllers\MapController::class, 'index']);
Route::get('/cek-map/data', [\App\Http\Controllers\MapController::class, 'get_map_json']);
Route::get('/cek-map/data-detail/{id}', [\App\Http\Controllers\MapController::class, 'get_map_by_id']);
