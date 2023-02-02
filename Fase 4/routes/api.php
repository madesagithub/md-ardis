<?php

use App\Http\Controllers\Api\ProjetoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'projeto' => ProjetoController::class,
    // 'ordem' => OrdemController::class,
    // 'posts' => PostController::class,
	// 'reaproveitamento' => ReaproveitamentoController::class,
]);

// api/v1
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
	Route::controller(RetalhoController::class)->prefix('retalhos')->group(function () {
		Route::get('saldo', 'saldo');
	});

	Route::apiResources([
		'ordens' => OrdemController::class,
		'reaproveitamento' => ReaproveitamentoController::class,
		'retalhos' => RetalhoController::class,
	]);

	// Route::controller(FabricaController::class)->group(function () {
	// 	Route::get('/fabricas/{fabrica}/retalhos', 'retalhos');
	// });

	// Route::controller(RetalhoController::class)->group(function () {
	// 	Route::get('/retalhos/{id}/plano', 'plano');
	// });
});




// Route::post('projeto', [ProjetoController::class, 'store']);