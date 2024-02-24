<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\MasterPelangganController;
use App\Http\Controllers\ProjectController;
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

Route::prefix('presence')->middleware(\App\Http\Middleware\PresenceMiddleware::class)->group(
    function () {
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

Route::prefix('data')->middleware('auth')->group(
    function () {
        Route::get('province', [\App\Http\Controllers\ProvinceController::class, 'province']);
        Route::get('province/{id}/city', [\App\Http\Controllers\ProvinceController::class, 'city']);
        Route::get('city', [\App\Http\Controllers\ProvinceController::class, 'cityAll']);
        Route::get('type', [\App\Http\Controllers\ItemController::class, 'getType']);
        Route::prefix('item')->group(
            function () {
                Route::get('datatable', [\App\Http\Controllers\ItemController::class, 'datatable']);
                Route::get('card', [\App\Http\Controllers\ItemController::class, 'cardItem']);
                Route::post('delete/{id}', [\App\Http\Controllers\ItemController::class, 'delete']);
                Route::post('post-item', [\App\Http\Controllers\ItemController::class, 'postItem']);
                Route::get('url-street-view/{id}', [\App\Http\Controllers\ItemController::class, 'getUrlStreetView']);
                Route::get('by-id/{id}', [\App\Http\Controllers\ItemController::class, 'getItemByID']);
            }
        );
    }
);

Route::prefix('admin/user')->middleware(\App\Http\Middleware\PimpinanMiddleware::class)->group(function () {
    Route::match(['POST', 'GET'], '', [UserController::class, 'index']);
    Route::post('status', [UserController::class, 'updateActive']);
    Route::get('datatable', [UserController::class, 'datatable']);
});

Route::prefix('admin')->middleware(\App\Http\Middleware\AdminMiddleware::class)->group(
    function () {
        Route::get('', [BerandaController::class, 'index']);
        Route::get('user/json', [UserController::class, 'dataJson'])->name('user.get.json');

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
                Route::post('delete/{id}', [\App\Http\Controllers\VendorController::class, 'delete']);
                Route::get('all', [\App\Http\Controllers\VendorController::class, 'getVendor']);
            }
        );

        Route::prefix('titik')->group(
            function () {
                Route::get('', [TitikController::class, 'index']);
                Route::get('type', [\App\Http\Controllers\ItemController::class, 'getType']);
                Route::post('post-item', [\App\Http\Controllers\ItemController::class, 'postItem']);
                Route::get('datatable', [\App\Http\Controllers\ItemController::class, 'datatable']);
            }
        );

        Route::prefix('project')->middleware(\App\Http\Middleware\StafMiddleware::class)->group(
            function () {
                Route::get('datatable', [ProjectController::class, 'datatable'])->name("project.datatable");
                Route::match(['POST', 'GET'], '', [ProjectController::class, 'index'])->name("project");
                Route::post('delete/{id}', [ProjectController::class, 'delete'])->name("project.delete");
                Route::post('setting/{id}/pdf', [ProjectController::class, 'saveSettingPdf'])->name("project.setting.pdf");
                Route::prefix('addproject')->group(function () {
                    Route::get('datatable', [\App\Http\Controllers\ProjectDetailController::class, 'datatable'])->name("tambahproject.datatable");
                    Route::post('move-order', [\App\Http\Controllers\ProjectDetailController::class, 'moveOrderProjectItem'])->name("tambahproject.move");
                    Route::post('new-move-order', [\App\Http\Controllers\ProjectDetailController::class, 'newMoveOrderProjectItem'])->name("tambahproject.new.move");
                    Route::get('get-count-city/{id}', [\App\Http\Controllers\ProjectDetailController::class, 'getCountCity'])->name("tambahproject.count.city");
                    Route::get('get-count-pic/{id}', [\App\Http\Controllers\ProjectDetailController::class, 'getCountPIC'])->name("tambahproject.count.pic");
                    Route::post('delete/{id}', [\App\Http\Controllers\ProjectDetailController::class, 'delete'])->name("tambahproject.delete");
                    Route::match(['POST', 'GET'], '/', [\App\Http\Controllers\ProjectDetailController::class, 'indexTambahProject'])->name("tambahproject");
                });
                Route::prefix('/detail')->group(function () {
                    Route::get('{id}', [ProjectController::class, 'indexDetailProject'])->name("detail");
                    Route::get('{id}/json', [\App\Http\Controllers\ProjectDetailController::class, 'getDetailProject'])->name('detail.json');
                });
                Route::prefix('buatharga')->middleware(\App\Http\Middleware\PimpinanMiddleware::class)->group(function () {
                    Route::get('{id}', [ProjectController::class, 'indexBuatHarga'])->name("buatharga");
                    Route::post('{id}/harga', [\App\Http\Controllers\ProjectDetailController::class, 'savePrice'])->name('detail.harga.post');
                });
                Route::post('clone-item', [\App\Http\Controllers\ProjectDetailController::class, 'saveItemToProject'])->name('clone.item');

                Route::post('/changestatus', [ProjectController::class, 'changeStatus'])->name('changestatus');
            }
        );
        Route::get('history/{id}', [\App\Http\Controllers\HistoryController::class, 'getHistory']);
        Route::get('report/{id}/{logo}', [\App\Http\Controllers\penawaranController::class, 'index'])->name('export.pdf');
        Route::get('report-excell/{id}', [\App\Http\Controllers\penawaranController::class, 'exportExcel'])->name('export.excell');
    }
);


Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/daftar', [DaftarController::class, 'index']);
Route::post('/daftar', [DaftarController::class, 'store']);
Route::get('/map/data', [\App\Http\Controllers\MapController::class, 'get_map_json']);
Route::get('/map/data/{id}', [\App\Http\Controllers\MapController::class, 'get_map_by_id']);

Route::get('/cek-map', [\App\Http\Controllers\MapController::class, 'index']);
Route::get('/cek-map/data', [\App\Http\Controllers\MapController::class, 'get_map_json']);
Route::get('/cek-map/data-detail/{id}', [\App\Http\Controllers\MapController::class, 'get_map_by_id']);
