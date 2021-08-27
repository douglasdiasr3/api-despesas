<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DespesasController;
use App\Http\Controllers\JobController;
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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/despesas', [DespesasController::class, 'store']);
    Route::get('/despesas', [DespesasController::class, 'show']);

    Route::put('/despesas/{id}', [DespesasController::class, 'update']);
    Route::delete('/despesas/{id}', [DespesasController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});