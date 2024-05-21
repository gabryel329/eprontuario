<?php

use App\Http\Controllers\PermisoesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

#Permisões

Route::get('/permisoes', [App\Http\Controllers\PermisoesController::class, 'index'])->name('permisao.index');
Route::post('/permisoes', [App\Http\Controllers\PermisoesController::class, 'store'])->name('permisao.store');
Route::put('/permisoes/{id}', [App\Http\Controllers\PermisoesController::class, 'update'])->name('permisao.update');
Route::delete('/permisoes/{id}', [PermisoesController::class, 'destroy'])->name('permisao.destroy');
Route::get('/permisoes/{id}', [App\Http\Controllers\PermisoesController::class, 'show'])->name('permisao.show');

