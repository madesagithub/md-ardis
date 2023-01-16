<?php

use App\Http\Controllers\ChapaController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\PecaController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\OrdemController;
use App\Http\Controllers\PlanoController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\RetalhoController;
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
    return redirect()->route('projeto.index');
});

// Logs
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

// Planos
Route::resource('plano', PlanoController::class);
Route::controller(PlanoController::class)->group(function () {
    Route::get('/plano/cancelar/{id}', 'cancelar')->name('plano.cancelar');
    Route::get('/plano/confirmar/{id}', 'confirmar')->name('plano.confirmar');
});

// Projetos
Route::resource('projeto', ProjetoController::class);
Route::controller(ProjetoController::class)->group(function () {
    // Route::get('/projeto/{id}/{#plano}', 'show')->name('projeto.show');
    Route::get('/projeto/start/{id}', 'start')->name('projeto.start');
    Route::get('/projeto/cancelar/{id}', 'cancelar')->name('projeto.cancelar');
    Route::get('/projeto/confirmar/{id}', 'confirmar')->name('projeto.confirmar');
});

// Ordem
Route::resource('ordem', OrdemController::class);
Route::controller(OrdemController::class)->group(function () {
    Route::get('/ordem/cancelar/{id}', 'cancelar')->name('ordem.cancelar');
    Route::get('/ordem/confirmar/{id}', 'confirmar')->name('ordem.confirmar');
});

Route::resource('retalho', RetalhoController::class);
Route::resource('movement', MovementController::class);
Route::resource('peca', PecaController::class);
Route::resource('chapa', ChapaController::class);
Route::resource('maquina', MaquinaController::class);
Route::resource('config', ConfigController::class);
