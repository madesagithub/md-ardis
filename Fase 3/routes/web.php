<?php

use App\Http\Controllers\ChapaController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrdemController;
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
    return view('welcome');
});

Route::resource('chapa', ChapaController::class);
Route::resource('material', MaterialController::class);
Route::resource('maquina', MaquinaController::class);
Route::resource('ordem', OrdemController::class);
