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

Route::resource('voyages', VoyageController::class);
Route::resource('transports', TransportController::class);

Route::get('/apropos', function () {
    return view('apropos');
});

Route::get('/ajouter', function () {
    $user = Auth::user();
    $voyagesUser = App\Models\Voyage::where('user_id', $user->id)->get();
    return view('ajouter', compact('user', 'voyagesUser'));
})->name('ajouter');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [VoyageController::class, 'index']);