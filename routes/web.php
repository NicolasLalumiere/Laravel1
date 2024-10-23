<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\VoyageController;
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

Route::get('/apropos', function () {
    return view('apropos');
}); 

Route::get('/voyages/ajouter', [VoyageController::class, 'create'])->name('voyages.ajouter');
Route::post('/voyages/ajouter', [VoyageController::class, 'store'])->name('voyages.store');

Route:: get ('/', [VoyageController::class, 'index']);

Route::resources([
      'transports'=> TransportController::class,
     ]);

Route:: get ('/connexion', [VoyageController::class, 'index']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
