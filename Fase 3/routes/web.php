<?php

use App\Http\Controllers\ChapaController;
use App\Http\Controllers\PecaController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\OrdemController;
use App\Http\Controllers\PlanoController;
use App\Http\Controllers\ProjetoController;
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

// Logs
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::resource('plano', PlanoController::class);
Route::controller(PlanoController::class)->group(function () {
    Route::get('/planos/cancelar/{id}', 'cancelar')->name('plano.cancelar');
    Route::get('/planos/confirmar/{id}', 'confirmar')->name('plano.confirmar');
});

Route::resource('projeto', ProjetoController::class);
Route::controller(ProjetoController::class)->group(function () {
    Route::get('/projetos/cancelar/{id}', 'cancelar')->name('projeto.cancelar');
    Route::get('/projetos/confirmar/{id}', 'confirmar')->name('projeto.confirmar');
});

Route::resource('peca', PecaController::class);
Route::resource('chapa', ChapaController::class);
Route::resource('maquina', MaquinaController::class);
Route::resource('ordem', OrdemController::class);
