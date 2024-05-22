<?php

use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\PermisoesController;
use App\Http\Controllers\UserController;
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

#Permissões

Route::get('/permisoes', [PermisoesController::class, 'index'])->name('permisao.index');
Route::post('/permisoes', [PermisoesController::class, 'store'])->name('permisao.store');
Route::put('/permisoes/{id}', [PermisoesController::class, 'update'])->name('permisao.update');
Route::delete('/permisoes/{id}', [PermisoesController::class, 'destroy'])->name('permisao.destroy');
Route::get('/permisoes/{id}', [PermisoesController::class, 'show'])->name('permisao.show');

#Especialidades

Route::get('/especialidades', [EspecialidadeController::class, 'index'])->name('especialidade.index');
Route::post('/especialidades', [EspecialidadeController::class, 'store'])->name('especialidade.store');
Route::put('/especialidades/{id}', [EspecialidadeController::class, 'update'])->name('especialidade.update');
Route::delete('/especialidades/{id}', [EspecialidadeController::class, 'destroy'])->name('especialidade.destroy');
Route::get('/especialidades/{id}', [EspecialidadeController::class, 'show'])->name('especialidade.show');

#Usuarios

Route::get('/usuarios', [UserController::class, 'index'])->name('usuario.index');
Route::get('/lista', [UserController::class, 'index1'])->name('usuario.index1');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuario.store');
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuario.update');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuario.destroy');
Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuario.show');