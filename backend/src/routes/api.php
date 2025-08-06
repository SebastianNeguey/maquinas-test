<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MaquinaController;
use App\Http\Controllers\Api\TareaController;
use App\Http\Controllers\Api\ProduccionController;
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

Route::apiResource('maquinas', MaquinaController::class);
Route::apiResource('tareas', TareaController::class)->except(['update']);
Route::apiResource('producciones', ProduccionController::class)->only(['index', 'show']);