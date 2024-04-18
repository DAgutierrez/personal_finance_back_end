<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\StoreController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/movements/create', [MovementController::class, 'create']);
Route::post('/stores/create', [StoreController::class, 'create']);
Route::post('/stores/import', [StoreController::class, 'import']);
Route::get('/movements/groupByCategory', [MovementController::class, 'groupByCategory']);
Route::get('/store/groupByType', [StoreController::class, 'groupByType']);
Route::post('/store/createFromBancoEstado', [StoreController::class, 'createFromBancoEstado']);
Route::post('/movements/import/falabella', [MovementController::class, 'importFalabella']);

