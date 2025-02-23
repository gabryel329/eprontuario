<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AnamneseController;
use App\Http\Controllers\AtendimentosController;
use App\Http\Controllers\BaixasController;
use App\Http\Controllers\BancosController;
use App\Http\Controllers\ContasFinanceirasController;
use App\Http\Controllers\ConvenioController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\GenerateIAController;
use App\Http\Controllers\GuiaConsultaController;
use App\Http\Controllers\GuiaHonorarioController;
use App\Http\Controllers\GuiaSpController;
use App\Http\Controllers\GuiaTissController;
use App\Http\Controllers\HonorarioController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\PermisoesController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\TabConvenioController;
use App\Http\Controllers\TabelaController;
use App\Http\Controllers\TaxaController;
use App\Http\Controllers\TipoProfController;
use App\Http\Controllers\UserController;
use App\Models\Bancos;
use App\Models\Fornecedores;
use App\Models\GuiaSp;
use App\Models\Produtos;
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
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');



Route::get('/', function () {
    return view('welcome');
});

//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
// Rotas de Autenticação
Auth::routes();

// Rota para a Página de Erro 419
Route::view('/error/419', 'errors.419')->name('error.419');
#GenerateIA
Route::POST('/generate-ia', [GenerateIAController::class, 'index'])->name('generateIA.index');
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
        Route::get('/listaconvenio', [ConvenioController::class, 'index1'])->name('convenio.index1');
        Route::get('convenios/{id}/edit', [ConvenioController::class, 'edit'])->name('convenio.edit');

        Route::get('/guia-consulta', [GuiaConsultaController::class, 'index'])->name('guiaconsulta.index');
        Route::get('/guia-consulta/listar', [GuiaConsultaController::class, 'listarGuiasConsulta'])->name('guiasconsulta.listar');
        Route::get('/guia-consulta/detalhes/{id}', [GuiaConsultaController::class, 'visualizarConsulta']);
        Route::get('/guia-tiss', [GuiaTissController::class, 'index'])->name('guiatiss.index');
        Route::get('/guia-honorario', [GuiaHonorarioController::class, 'index'])->name('guiahonorario.index');
        Route::get('/guia-sp', [GuiaSpController::class, 'index'])->name('guiasp.index');


        Route::get('/guia-tiss/listar', [GuiaTissController::class, 'listarGuiasTiss'])->name('guiastiss.listar');
        Route::get('/guia-honorario/listar', [GuiaHonorarioController::class, 'listarGuiasHonorario'])->name('guiahonorario.listar');
        Route::get('/guia-sp/listar', [GuiaSpController::class, 'listarGuiasSp'])->name('guiasp.listar');

        Route::get('/guia-honorario/detalhes/{id}', [GuiaHonorarioController::class, 'visualizarHonorario']);
        Route::get('/guia-tiss/detalhes/{id}', [GuiaTissController::class, 'visualizarTiss']);
        Route::get('/guia-sp/detalhes/{id}', [GuiaSpController::class, 'visualizarSp']);

        Route::get('/guias-honorarios', [GuiaHonorarioController::class, 'index'])->name('guia_honorario.index');
        Route::post('/guias-honorarios', [GuiaHonorarioController::class, 'store'])->name('guia_honorario.store');

        Route::get('/marcacao', [AgendaController::class, 'index3'])->name('agenda.index3');
        Route::get('/gerar-agenda', [AgendaController::class, 'geraAgenda'])->name('agenda.gerar');
        Route::post('/gerar-agenda', [AgendaController::class, 'GerarAgendaStore'])->name('gerar-agenda.store');
        Route::get('/get-profissionais/{especialidadeId}', [AgendaController::class, 'getProfissionais'])->name('get.profissionais');
        Route::get('/especialidades/{profissional}', [AgendaController::class, 'getEspecialidades'])->name('getEspecialidades');
        Route::get('/verificar-disponibilidade/{profissionalId}/{especialidadeId}/{data}', [AgendaController::class, 'verificarDisponibilidade']);
        Route::post('/agendar', [AgendaController::class, 'agendar']);
        Route::get('/rel-agenda', [AgendaController::class, 'consultaAgenda'])->name('agenda.consulta');
        Route::post('/filtrar-agenda', [AgendaController::class, 'filtrarAgenda'])->name('agenda.filtrar');
        // Route::get('/agenda/{id}/guia-tiss', [GuiaTissController::class, 'gerarGuiaTiss'])->name('guia.tiss');
        Route::get('/agenda/{id}/guia-sadt', [GuiaSpController::class, 'gerarGuiaSadt'])->name('guia.sadt');

        Route::post('/get-procedimentos', [AgendaController::class, 'getProcedimentos'])->name('get.procedimentos');
        Route::get('/api/get-medicamentos/{guia_sps_id}', [GuiaSpController::class, 'getMedicamentos']);
        Route::get('/api/get-materiais/{guia_sps_id}', [GuiaSpController::class, 'getMateriais']);

        Route::get('/api/get-procedimentos/{pacienteId}', [GuiaSpController::class, 'getProcedimentos']);

        Route::get('/gerar-guia-sadt/{id}', [GuiaSpController::class, 'gerarGuiaSADTMODAL']);
        Route::get('/agenda/{id}/guia-sadt', [GuiaSpController::class, 'gerarGuiaSadt'])->name('guia.sadt');
        Route::post('/guia-sadt/salvar', [GuiaSpController::class, 'salvarGuiaSADT'])->name('guia.sadt.salvar');
        Route::post('/excluir-exame', [GuiaSpController::class, 'excluirExame'])->name('excluir.exame');
        Route::get('/visualizar-guia-sadt/{id}', [GuiaSpController::class, 'visualizarGuiaSadt'])->name('guia.sadt.visualizar');
        Route::get('guia-sp/{id}/editar', [GuiaSpController::class, 'editarGuia'])->name('guia-sp.editar');
        Route::post('/guia-sp', [GuiaSpController::class, 'glosaSadt'])->name('guia.sp.atualizar');

        Route::get('/gerar-guia-consulta/{id}', [GuiaConsultaController::class, 'gerarGuiaConsultaMODAL'])->name('gerar.guia.consulta');
        Route::post('/salvar-guia-consulta', [GuiaConsultaController::class, 'salvarGuiaConsulta'])->name('salvar.guiaConsulta');
        Route::get('/agenda/{id}/guia-consulta', [GuiaConsultaController::class, 'gerarGuiaConsulta'])->name('guia.consulta2');
        #GuiaConsulta
        Route::post('/verificar-numeracao-consulta', [GuiaConsultaController::class, 'verificarNumeracao'])->name('guias.verificarNumeracaoConsulta');
        Route::post('/gerar-zip-guia-consulta-em-lote', [GuiaConsultaController::class, 'gerarZipGuiaConsultaEmLote'])->name('guias.gerarZipConsultaEmLote');
        Route::post('/gerar-xml-guia-consulta-em-lote', [GuiaConsultaController::class, 'gerarXmlGuiaConsultaEmLote'])->name('guias.gerarXmlConsultaEmLote');
        Route::post('/gerar-xml-guia-consulta/{id}', [GuiaConsultaController::class, 'gerarXmlGuiaConsulta']);
        Route::post('/gerar-zip-guia-consulta/{id}', [GuiaConsultaController::class, 'gerarZipGuiaConsulta']);
        Route::get('/guias-consulta/{guiaConsulta}/editar', [GuiaConsultaController::class, 'edit'])->name('guias-consulta.editar');
        Route::put('/guias-consulta/{guiaConsulta}/update', [GuiaConsultaController::class, 'updateGuiaConsulta'])->name('guias-consulta.update');
        // Route::put('/guias-consulta/{guiaConsulta}', [GuiaConsultaController::class, 'update'])->name('guias-consulta.update');
        #GuiaSadt
        Route::post('/verificar-numeracao-sadt', [GuiaSpController::class, 'verificarNumeracao'])->name('guias.verificarNumeracaoSadt');
        Route::post('/gerar-zip-guia-sadt-em-lote', [GuiaSpController::class, 'gerarZipGuiasadtEmLote'])->name('guias.gerarZipEmLote');
        Route::post('/gerar-xml-guia-sadt-em-lote', [GuiaSpController::class, 'gerarXmlGuiasadtEmLote'])->name('guias.gerarXmlEmLote');
        Route::post('/gerar-xml-guia-sadt/{id}', [GuiaSpController::class, 'gerarXmlGuiasadt']);
        Route::post('/gerar-zip-guia-sadt/{id}', [GuiaSpController::class, 'gerarZipGuiasadt']);
        Route::get('/guias-sadt/{guiaSadt}/editar', [GuiaSpController::class, 'edit'])->name('guias-sadt.editar');
        Route::put('/guias-sadt/{guiaSadt}/update', [GuiaSpController::class, 'updateGuiasadt'])->name('guias-sadt.update');

        Route::get('/convenios/procedures', [ConvenioController::class, 'getProceduresIndex'])->name('convenios.index');
        Route::get('/convenios/procedures/{id}', [ConvenioController::class, 'getProcedures'])->name('convenios.getProcedures');
        Route::post('/convenios/update-procedures-values/{id}', [ConvenioController::class, 'updateProceduresValues']);

        Route::get('/medicamentos', [ProdutosController::class, 'listaMedicamentos'])->name('medicamentos.index');
        Route::get('/listaprodutos', [ProdutosController::class, 'listaProdutos'])->name('listaprodutos.index');
        Route::post('/produtor/edit', [ProdutosController::class, 'update'])->name('produtos.update');
        Route::get('/produtos', [ProdutosController::class, 'index'])->name('produtos.index');
        Route::delete('/produtos/{id}', [ProdutosController::class, 'destroy'])->name('produtos.destroy');


        Route::get('/get-agenda-data/{profissionalId}/{especialidadeId}/{selectedDate}', [AgendaController::class, 'getAgendaData']);
        Route::get('/get-disponibilidade/{profissionalId}', [AgendaController::class, 'getDisponibilidade'])->name('get.disponibilidade');

        Route::post('/save-disponibilidade', [HonorarioController::class, 'saveDisponibilidade']);
    });

    Route::post('/produtos', [ProdutosController::class, 'store'])->name('produtos.store');
    Route::post('/guia_consulta', [GuiaConsultaController::class, 'store'])->name('guiaconsulta.store');
    Route::post('/guia_tiss', [GuiaTissController::class, 'store'])->name('guiatiss.store');
    Route::post('/guia_sp', [GuiaSpController::class, 'store'])->name('guiasp.store');
    // Route::post('/guia_honorario', [GuiaHonorarioController::class, 'store'])->name('guiahonorario.store');
    // Route::post('/guias', [GuiaHonorarioController::class, 'store'])->name('guiahonorario.store');


    Route::get('/convenioProcedimento', [ConvenioController::class, 'convenioProcedimentoIndex'])->name('convenioProcedimento.index');
    Route::post('/convenioProcedimento', [ConvenioController::class, 'convenioProcedimentoStore'])->name('convenioProcedimento.store');
    Route::delete('/convenioProcedimento/bulkDestroy', [ConvenioController::class, 'bulkDestroy'])->name('convenioProcedimento.bulkDestroy');

    Route::get('/honorario', [HonorarioController::class, 'index'])->name('Honorario.index');
    Route::post('/honorario', [HonorarioController::class, 'store'])->name('honorario.store');
    Route::get('/honorarios/{profissionalId}', [HonorarioController::class, 'getHonorariosByProfissional'])->name('honorarios.getByProfissional');
    Route::post('/honorarios/{id}', [HonorarioController::class, 'update'])->name('honorarios.update');
    Route::post('/honorario/delete-selected', [HonorarioController::class, 'bulkDestroy'])->name('honorario.deleteSelected');

    Route::post('/convenio', [ConvenioController::class, 'store'])->name('convenio.store');
    Route::post('/convenio/{id}', [ConvenioController::class, 'update'])->name('convenio.update');
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
    Route::post('/verificar-feriado', [AgendaController::class, 'verificarFeriado']);
    Route::post('/consultorioPainel/update', [AgendaController::class, 'updateConsultorioPainel'])->name('consultorioPainel.update');

    // Pacientes
    Route::get('/pacientes', [PacientesController::class, 'index'])->name('paciente.index');
    Route::post('/pacientes', [PacientesController::class, 'store'])->name('paciente.store');
    Route::put('/pacientes/{id}', [PacientesController::class, 'update'])->name('paciente.update');
    Route::delete('/pacientes/{id}', [PacientesController::class, 'destroy'])->name('paciente.destroy');
    Route::get('/pacientes/{id}', [PacientesController::class, 'show'])->name('paciente.show');
    Route::post('/webcam-error', [PacientesController::class, 'handleWebcamError'])->name('handleWebcamError');
    Route::post('/webcam-check', [PacientesController::class, 'checkWebcam'])->name('webcam.check');


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
    Route::get('profissionais/{id}/edit', [ProfissionalController::class, 'edit'])->name('profissional.edit');
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
    Route::post('/remedios/store', [AtendimentosController::class, 'storeRemedio'])->name('remedios.store');
    Route::get('/remedios/{agenda_id}/{paciente_id}', [AtendimentosController::class, 'verificarRemedio']);
    Route::post('/exames/store', [AtendimentosController::class, 'storeExame'])->name('exames.store');

    #Formularios
    Route::post('/ficha', [AtendimentosController::class, 'ficha_atendimento'])->name('ficha');

    // web.php
    Route::get('/paciente/ficha/{id}', [PacientesController::class, 'fichaPaciente'])->name('paciente.ficha');
    Route::get('/guia/honorario/{id}', [GuiaHonorarioController::class, 'impressaoGuia'])->name('guia.honorario');
    Route::get('/guia/sp/{id}', [GuiaSpController::class, 'impressaoGuia'])->name('guia.sp');
    Route::get('/guia/consulta/{id}', [GuiaConsultaController::class, 'impressaoGuia'])->name('guia.consulta');
    // Route::get('/guia/tiss/{id}', [GuiaTissController::class, 'impressaoGuia'])->name('guia.tiss');


    Route::get('/ficha_atendimento', [AtendimentosController::class, 'processarFormulario'])->name('processarFormulario');

    Route::post('/solicitacoes', [AtendimentosController::class, 'solicitacoes']);
    Route::get('/formulario/atestado/{paciente_id}/{agenda_id}/{profissional_id}/{dia}/{obs}/{cid}', [AtendimentosController::class, 'atestadoView'])->name('formulario.atestado');

    Route::get('/formulario/receita/{paciente_id}/{agenda_id}/{profissional_id}', [AtendimentosController::class, 'receitaView'])->name('formulario.receita');
    Route::get('/formulario/exame/{paciente_id}/{agenda_id}/{profissional_id}', [AtendimentosController::class, 'exameView'])->name('formulario.exame');

    #Consultorio

    Route::post('/consultorio/painel', [AgendaController::class, 'storeConsultorioPainel'])->name('consultorioPainel.store');
    Route::get('/consultorio', [PainelController::class, 'index'])->name('painelConsultorio.index');
    Route::get('/painel/ultimo-registro-atualizado', [PainelController::class, 'getUltimoRegistroAtualizado']);
    Route::get('/main', [PainelController::class, 'showMain']);



    #RelatorioFinanceiro
    Route::get('/relatorioFinanceiro', [HonorarioController::class, 'relatorioFinanceiroIndex'])->name('relatorioFinanceiro.index');
    Route::post('/relatorioFinanceiro', [HonorarioController::class, 'relatorioFinanceiroIndex']);

    Route::get('/relatorioGuia', [HonorarioController::class, 'relatorioGuiaIndex'])->name('relatorioGuia.index');
    Route::post('/relatorioGuia', [HonorarioController::class, 'relatorioGuiaResult'])->name('relatorioGuia.result');


    Route::get('/TabelaProcedimento', [TabelaController::class, 'TabelaProcedimento'])->name('TabelaProcedimento.index');
    Route::post('/TabelaProcedimento', [TabelaController::class, 'store'])->name('TabelaProcedimento.store');
    Route::put('/TabelaProcedimento/{id}', [TabelaController::class, 'update'])->name('TabelaProcedimento.update');
    Route::delete('/TabelaProcedimento/{id}', [TabelaController::class, 'destroy'])->name('TabelaProcedimento.destroy');

    Route::post('/tabconvenios', [TabConvenioController::class, 'store'])->name('tabconvenios.store');
    Route::put('/tabconvenios/{id}', [TabConvenioController::class, 'update'])->name('tabconvenios.update');
    Route::delete('/tabconvenios/{id}', [TabConvenioController::class, 'destroy'])->name('tabconvenios.destroy');

    Route::get('/detalhesConsulta/{id}', [AgendaController::class, 'detalhesConsulta']);
    Route::post('/procedimentos/store', [AgendaController::class, 'storeProcedimento']);
    Route::get('/procedimentos/{agenda_id}/{paciente_id}', [AgendaController::class, 'verificarProcedimento']);
    Route::post('/medicamento/store', [AgendaController::class, 'storeMedicamento']);
    Route::get('/medicamento/{agenda_id}/{paciente_id}', [AgendaController::class, 'verificarMedicamento']);
    Route::post('/material/store', [AgendaController::class, 'storeMaterial']);
    Route::get('/material/{agenda_id}/{paciente_id}', [AgendaController::class, 'verificarMaterial']);
    Route::post('/taxa/store', [AgendaController::class, 'storeTaxa']);
    Route::get('/taxa/{agenda_id}/{paciente_id}', [AgendaController::class, 'verificarTaxa']);

    Route::post('/import-txt', [TabelaController::class, 'importarTxt'])->name('importarTxt');
    Route::get('/importar-excel', [TabelaController::class, 'importarExcelIndex'])->name('imp_tabela.index');
    Route::delete('/tabela/{nome}', [TabelaController::class, 'excluirTabela'])->name('tabela.excluir');
    Route::post('/importar-excel', [TabelaController::class, 'importarExcel']);

    Route::post('/porte/salvar', [TabelaController::class, 'porteSalvar'])->name('porte.salvar');
    Route::delete('/porte/{nome}', [TabelaController::class, 'porteExcluir'])->name('porte.excluir');
    Route::post('/ch/salvar', [TabelaController::class, 'chSalvar'])->name('ch.salvar');
    Route::delete('/ch/{nome}', [TabelaController::class, 'chExcluir'])->name('ch.excluir');

    Route::get('taxa', [TaxaController::class, 'index'])->name('taxa.index'); // Listar taxas
    Route::post('taxa', [TaxaController::class, 'store'])->name('taxa.store'); // Salvar nova taxa
    Route::put('taxa/{id}', [TaxaController::class, 'update'])->name('taxa.update'); // Atualizar taxa
    Route::delete('taxa/{id}', [TaxaController::class, 'destroy'])->name('taxa.destroy'); // Excluir taxa
    #Contas do Financeiro

    Route::get('/contasPagar', [ContasFinanceirasController::class, 'indexContasPagar'])->name('contasPagar.index');
    Route::get('/contasReceber', [ContasFinanceirasController::class, 'indexContasReceber'])->name('contasReceber.index');
    Route::post('/contasFinanceiro', [ContasFinanceirasController::class, 'store'])->name('contas.store');
    Route::put('/contasFinanceiro/{id}', [ContasFinanceirasController::class, 'update'])->name('contas.update');
    Route::delete('/contas/{tipo}/{id}', [ContasFinanceirasController::class, 'destroy'])->name('contas.destroy');

    #Fornecedores
    Route::get('/listafornecedores', [FornecedoresController::class, 'index1'])->name('listafornecedores.index1');
    Route::get('/fornecedores', [FornecedoresController::class, 'index'])->name('fornecedores.index');
    Route::post('/fornecedores', [FornecedoresController::class, 'store'])->name('fornecedores.store');
    Route::delete('/listafornecedores/{id}', [FornecedoresController::class, 'destroy'])->name('listafornecedores.destroy');

    #Bancos
    Route::get('/bancos', [BancosController::class, 'index'])->name('bancos.index');
    Route::post('/bancos', [BancosController::class, 'store'])->name('bancos.store');
    Route::put('/bancos/{id}', [BancosController::class, 'update'])->name('bancos.update');
    Route::delete('/bancos/{id}', [BancosController::class, 'destroy'])->name('bancos.destroy');

    #Baixas
    // Route::get('/faturamentoBaixas', [BaixasController::class, 'index'])->name('faturamentoBaixas.index');
    Route::get('/baixas/filtrar-consulta', [BaixasController::class, 'filtrarConsulta'])->name('baixas.filtrarConsulta');
    Route::get('/baixas/filtrar-sadt', [BaixasController::class, 'filtrarSadt'])->name('baixas.filtrarSadt');
    Route::post('/baixas/{id}', [BaixasController::class, 'storeBaixa'])->name('baixas.store');

    #Glosa/Baixa
    Route::get('/contas-guias/{contaId}', [BaixasController::class, 'buscarGuiasPorConta']);
    Route::get('/faturamentoGlosa', [BaixasController::class, 'indexGlosa'])->name('faturamentoGlosa.index');

    #Relatorio BI
    Route::get('/relatorio-bi', [RelatoriosController::class, 'index'])->name('relatorio.bi');

    #Chat
    Route::get('/chat', [MessageController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [MessageController::class, 'show'])->name('chat.show');
    Route::post('/chat', [MessageController::class, 'store'])->name('chat.store');
    Route::post('/chat2', [MessageController::class, 'update'])->name('chat.update');


    Route::middleware(['auth', 'check.question'])->group(function () {
        Route::post('/salvar-sala', [UserController::class, 'salvarSala']);
        Route::get('/home', function () {
            return view('home');
        });
    });
});
