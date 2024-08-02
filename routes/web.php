<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AnamneseController;
use App\Http\Controllers\AtendimentosController;
use App\Http\Controllers\ConvenioController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\GenerateIAController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\PermisoesController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\TipoProfController;
use App\Http\Controllers\UserController;
use App\Models\TipoProf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

    Route::middleware(['auth', 'check.permission:1,3'])->group(function () {
        #Médico
        Route::get('/atendimento/lista', [AtendimentosController::class, 'index1'])->name('atendimento.lista');
        Route::get('/agendamedica', [AgendaController::class, 'agendaMedica'])->name('agenda.agendaMedica');
    });

    Route::middleware(['auth', 'check.permission:2,3'])->group(function () {
        #Recepção
        Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
        Route::get('/lista', [AgendaController::class, 'index1'])->name('agenda.index1');
        Route::get('/pacientes', [PacientesController::class, 'index'])->name('paciente.index');
        Route::get('/listapacientes', [PacientesController::class, 'index1'])->name('paciente.index1');
    });

    Route::middleware(['auth', 'check.permission:3'])->group(function () {
        #Admin
        Route::get('/permisoes', [PermisoesController::class, 'index'])->name('permisao.index');
        Route::get('/especialidades', [EspecialidadeController::class, 'index'])->name('especialidade.index');
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuario.index');
        Route::get('/profissional', [ProfissionalController::class, 'index'])->name('profissional.index');
        Route::get('/tipoprof', [TipoProfController::class, 'index'])->name('tipoprof.index');
        Route::get('/empresa', [EmpresasController::class, 'index'])->name('empresa.index');
        Route::get('/convenio', [ConvenioController::class, 'index'])->name('convenio.index');
    });

    Route::get('/convenioProcedimento', [ConvenioController::class, 'convenioProcedimentoIndex'])->name('convenioProcedimento.index');
    Route::post('/convenioProcedimento', [ConvenioController::class, 'convenioProcedimentoStore'])->name('convenioProcedimento.store');
    Route::post('/convenioProcedimento/{id}', [ConvenioController::class, 'convenioProcedimentoDelete'])->name('convenioProcedimento.delete');


    Route::post('/convenio', [ConvenioController::class, 'store'])->name('convenio.store');
    Route::put('/convenio/{id}', [ConvenioController::class, 'update'])->name('convenio.update');
    Route::delete('/convenio/{id}', [ConvenioController::class, 'destroy'])->name('convenio.destroy');
    Route::get('/convenio/{id}', [ConvenioController::class, 'show'])->name('convenio.show');

    Route::post('/permisoes', [PermisoesController::class, 'store'])->name('permisao.store');
    Route::put('/permisoes/{id}', [PermisoesController::class, 'update'])->name('permisao.update');
    Route::delete('/permisoes/{id}', [PermisoesController::class, 'destroy'])->name('permisao.destroy');
    Route::get('/permisoes/{id}', [PermisoesController::class, 'show'])->name('permisao.show');

    Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
    Route::put('/agenda/{id}', [AgendaController::class, 'update'])->name('agenda.update');
    Route::delete('/agenda/{id}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
    Route::post('/agenda/update-status', [AgendaController::class, 'updateStatus'])->name('agenda.updateStatus');
    Route::post('/consultorioPainel/update', [AgendaController::class, 'updateConsultorioPainel'])->name('consultorioPainel.update');

    // Pacientes
    Route::get('/pacientes', [PacientesController::class, 'index'])->name('paciente.index');
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

    // TipoProf

    Route::post('/tipoprof', [TipoProfController::class, 'store'])->name('tipoprof.store');
    Route::put('/tipoprof/{id}', [TipoProfController::class, 'update'])->name('tipoprof.update');
    Route::delete('/tipoprof/{id}', [TipoProfController::class, 'destroy'])->name('tipoprof.destroy');

    // Especialidades

    Route::post('/especialidades', [EspecialidadeController::class, 'store'])->name('especialidade.store');
    Route::put('/especialidades/{id}', [EspecialidadeController::class, 'update'])->name('especialidade.update');
    Route::delete('/especialidades/{id}', [EspecialidadeController::class, 'destroy'])->name('especialidade.destroy');
    Route::get('/especialidades/{id}', [EspecialidadeController::class, 'show'])->name('especialidade.show');

    // Usuários

    Route::get('/listausuarios', [UserController::class, 'index1'])->name('usuario.index1');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuario.store');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuario.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuario.destroy');
    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuario.show');

    // Empresas
    Route::put('/empresa/{id}', [EmpresasController::class, 'update'])->name('empresa.update');

    // Profissional

    Route::get('/listaprofissional', [ProfissionalController::class, 'index1'])->name('profissional.index1');
    Route::post('/profissional', [ProfissionalController::class, 'store'])->name('profissional.store');
    Route::put('/profissional/{id}', [ProfissionalController::class, 'update'])->name('profissional.update');
    Route::delete('/profissional/{id}', [ProfissionalController::class, 'destroy'])->name('profissional.destroy');
    Route::get('/profissional/{id}', [ProfissionalController::class, 'show'])->name('profissional.show');

    #Atendimentos

    Route::get('/atendimento/{agenda_id}/{paciente_id}/medico', [AtendimentosController::class, 'index'])->name('atendimento.index');

    Route::get('/exames/{agenda_id}/{paciente_id}', [AtendimentosController::class, 'verificarExame']);
    Route::post('/atendimentos/store', [AtendimentosController::class, 'storeAtendimento']);
    Route::get('/atendimentos/{agenda_id}/{paciente_id}', [AtendimentosController::class, 'verificarAtendimento']);
    Route::post('/anamneses/store', [AtendimentosController::class, 'storeAnamnese']);
    Route::get('/anamneses/check/{paciente_id}', [AtendimentosController::class, 'verificarAnamnese']);
    Route::post('/remedios/store', [AtendimentosController::class, 'storeRemedio']);
    Route::get('/remedios/{agenda_id}/{paciente_id}', [AtendimentosController::class, 'verificarRemedio']);
    Route::post('/exames/store', [AtendimentosController::class, 'storeExame'])->name('exames.store');

    #Formularios
    Route::post('/ficha', [AtendimentosController::class, 'ficha_atendimento'])->name('ficha');

    Route::post('/ficha_atendimento', [AtendimentosController::class, 'processarFormulario'])->name('processarFormulario');

    Route::post('/solicitacoes', [AtendimentosController::class, 'solicitacoes']);
    Route::get('/formulario/atestado/{paciente_id}/{agenda_id}/{profissional_id}/{dia}', [AtendimentosController::class, 'atestadoView'])->name('formulario.atestado');

    Route::get('/formulario/receita/{paciente_id}/{agenda_id}/{profissional_id}', [AtendimentosController::class, 'receitaView'])->name('formulario.receita');
    Route::get('/formulario/exame/{paciente_id}/{agenda_id}/{profissional_id}', [AtendimentosController::class, 'exameView'])->name('formulario.exame');

    #Consultorio

    Route::post('/consultorio/painel', [AgendaController::class, 'storeConsultorioPainel'])->name('consultorioPainel.store');
    Route::get('/consultorio', [PainelController::class, 'index'])->name('painelConsultorio.index');
    Route::get('/painel/ultimo-registro-atualizado', [PainelController::class, 'getUltimoRegistroAtualizado']);
    Route::get('/main', [PainelController::class, 'showMain']);

    #GenerateIA
    Route::POST('/generate-ia',  [GenerateIAController::class, 'index'])->name('generateIA.index');



    #SalaVerificação

    Route::middleware(['auth', 'check.question'])->group(function () {
        Route::post('/salvar-sala', [UserController::class, 'salvarSala']);
        Route::get('/home', function () {
            return view('home');
        });
    });
});
