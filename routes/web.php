<?php

use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\PacientesController;
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
Route::get('/listausuarios', [UserController::class, 'index1'])->name('usuario.index1');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuario.store');
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuario.update');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuario.destroy');
Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuario.show');

#Pacientes

Route::get('/pacientes', [PacientesController::class, 'index'])->name('paciente.index');
Route::get('/listapacientes', [PacientesController::class, 'index1'])->name('paciente.index1');
Route::post('/pacientes', [PacientesController::class, 'store'])->name('paciente.store');
Route::put('/pacientes/{id}', [PacientesController::class, 'update'])->name('paciente.update');
Route::delete('/pacientes/{id}', [PacientesController::class, 'destroy'])->name('paciente.destroy');
Route::get('/pacientes/{id}', [PacientesController::class, 'show'])->name('paciente.show');

#Empresas

Route::get('/empresas', [EmpresasController::class, 'index'])->name('empresa.index');
// Route::get('/listaempresas', [EmpresasController::class, 'index1'])->name('empresa.index1');
Route::post('/empresas', [EmpresasController::class, 'store'])->name('empresa.store');
Route::put('/empresas/{id}', [EmpresasController::class, 'update'])->name('empresa.update');
Route::delete('/empresas/{id}', [EmpresasController::class, 'destroy'])->name('empresa.destroy');
Route::get('/empresas/{id}', [EmpresasController::class, 'show'])->name('empresa.show');