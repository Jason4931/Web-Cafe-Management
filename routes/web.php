<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerProduct;
use App\Http\Controllers\ControllerProductBahan;
use App\Http\Controllers\ControllerReport;
use App\Http\Controllers\ControllerStock;
use Illuminate\Support\Facades\Route;

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

Route::resource('/productbahan', ControllerProductBahan::class);
Route::resource('/product', ControllerProduct::class);
Route::resource('/stock', ControllerStock::class);
Route::get('/', [Controller::class, 'index']);
Route::get('/produk', [Controller::class, 'produk']);
Route::get('/bahan', [Controller::class, 'bahan']);
Route::get('/beli', [Controller::class, 'beli']);
Route::get('/jual', [Controller::class, 'jual']);
Route::get('/laporan', [Controller::class, 'laporan']);
Route::get('/reportbeli', [ControllerReport::class, 'storebeli']);
Route::post('/reportjual', [ControllerReport::class, 'storejual']);
Route::get('/laporanp', [Controller::class, 'laporanperiode']);
// Route::resource('/', UserController::class);
// Route::get('/', function () {
//     return view('welcome');
// });