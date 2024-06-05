<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AnamneseController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\PermisoesController;
use App\Http\Controllers\ProfissionalController;
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

// Rotas de Autenticação
Auth::routes();

// Rota para a Página de Erro 419
Route::view('/error/419', 'errors.419')->name('error.419');

// Rotas Protegidas pelo Middleware 'check.session.expired'
Route::middleware(['check.session.expired'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Permissões
    Route::get('/permisoes', [PermisoesController::class, 'index'])->name('permisao.index');
    Route::post('/permisoes', [PermisoesController::class, 'store'])->name('permisao.store');
    Route::put('/permisoes/{id}', [PermisoesController::class, 'update'])->name('permisao.update');
    Route::delete('/permisoes/{id}', [PermisoesController::class, 'destroy'])->name('permisao.destroy');
    Route::get('/permisoes/{id}', [PermisoesController::class, 'show'])->name('permisao.show');

    // Especialidades
    Route::get('/especialidades', [EspecialidadeController::class, 'index'])->name('especialidade.index');
    Route::post('/especialidades', [EspecialidadeController::class, 'store'])->name('especialidade.store');
    Route::put('/especialidades/{id}', [EspecialidadeController::class, 'update'])->name('especialidade.update');
    Route::delete('/especialidades/{id}', [EspecialidadeController::class, 'destroy'])->name('especialidade.destroy');
    Route::get('/especialidades/{id}', [EspecialidadeController::class, 'show'])->name('especialidade.show');

    // Usuários
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuario.index');
    Route::get('/listausuarios', [UserController::class, 'index1'])->name('usuario.index1');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuario.store');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuario.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuario.destroy');
    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuario.show');

    // Pacientes
    Route::get('/pacientes', [PacientesController::class, 'index'])->name('paciente.index');
    Route::get('/listapacientes', [PacientesController::class, 'index1'])->name('paciente.index1');
    Route::post('/pacientes', [PacientesController::class, 'store'])->name('paciente.store');
    Route::put('/pacientes/{id}', [PacientesController::class, 'update'])->name('paciente.update');
    Route::delete('/pacientes/{id}', [PacientesController::class, 'destroy'])->name('paciente.destroy');
    Route::get('/pacientes/{id}', [PacientesController::class, 'show'])->name('paciente.show');

    // Anamnese
    Route::get('/anamnese', [AnamneseController::class, 'index'])->name('anamnese.index');
    Route::get('/listaanamnese', [AnamneseController::class, 'index1'])->name('anamnese.index1');
    Route::post('/anamnese', [AnamneseController::class, 'store'])->name('anamnese.store');
    Route::put('/anamnese/{id}', [AnamneseController::class, 'update'])->name('anamnese.update');
    Route::delete('/anamnese/{id}', [AnamneseController::class, 'destroy'])->name('anamnese.destroy');
    Route::get('/anamnese/{id}', [AnamneseController::class, 'show'])->name('anamnese.show');

    // Empresas
    Route::get('/empresa', [EmpresasController::class, 'index'])->name('empresa.index');
    Route::put('/empresa/{id}', [EmpresasController::class, 'update'])->name('empresa.update');

    // Profissional
    Route::get('/profissional', [ProfissionalController::class, 'index'])->name('profissional.index');
    Route::get('/listaprofissional', [ProfissionalController::class, 'index1'])->name('profissional.index1');
    Route::post('/profissional', [ProfissionalController::class, 'store'])->name('profissional.store');
    Route::put('/profissional/{id}', [ProfissionalController::class, 'update'])->name('profissional.update');
    Route::delete('/profissional/{id}', [ProfissionalController::class, 'destroy'])->name('profissional.destroy');
    Route::get('/profissional/{id}', [ProfissionalController::class, 'show'])->name('profissional.show');

    // Agenda
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/lista', [AgendaController::class, 'index1'])->name('agenda.index1');
    Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
    Route::put('/agenda/{id}', [AgendaController::class, 'update'])->name('agenda.update');
    Route::delete('/agenda/{id}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
    Route::post('/agenda/update-status', [AgendaController::class, 'updateStatus'])->name('agenda.updateStatus');
});
