<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\VoyageController;
use App\Http\Controllers\Api\RegisterController;
use App\Models\Voyage;

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


//Route::apiResource('/articles', ArticleController::class);  //cette route générée par resources fonctionne aussi


Route::post('register', [RegisterController::class, 'register']);

Route::post('login', [RegisterController::class, 'login']);
Route::get('/voyages', [VoyageController::class, 'index']);
Route::get('/voyages/{id}', [VoyageController::class, 'show']);
     
//Route::resource('articles', ArticleController::class);
Route::middleware('auth:sanctum')->group( function () {
    //Route::resource('articles', ArticleController::class);
    // Route::get('articles', [ArticleController::class, 'index']);
    Route::post('voyages/', [VoyageController::class, 'store']);
    Route::get('voyages/edit/{id}', [VoyageController::class, 'edit']);
    Route::put('voyages/update/{id}', [VoyageController::class, 'update']);
    Route::delete('voyages/{id}', [VoyageController::class, 'destroy']); 

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});