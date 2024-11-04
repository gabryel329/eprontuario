<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Convenio;
use App\Models\Empresas;
use App\Models\GuiaSp;
use App\Models\Pacientes;
use App\Models\Profissional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuiaSpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guiasp = GuiaSp::all();
        $convenios = Convenio::all();
        return view('guias.guia_sp', compact('guiasp', 'convenios'));
    }

    public function listarGuiasSp(Request $request)
    {
        $convenio_id = $request->get('convenio_id');

        if (!$convenio_id) {
            return response()->json(['error' => 'Convênio não encontrado.'], 404);
        }

        $guiasp = GuiaSp::where('convenio_id', $convenio_id)->get();

        return response()->json(['guias' => $guiasp]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        $user_id = auth()->id();

        $convenio_id = $request->input('convenio_id');
        $registro_ans = $request->input('registro_ans');
        $numero_guia_prestador = $request->input('numero_guia_prestador');
        $data_autorizacao = $request->input('data_autorizacao');
        $senha = $request->input('senha');
        $validade_senha = $request->input('validade_senha');
        $numero_guia_op = $request->input('numero_guia_op');
        $numero_carteira = $request->input('numero_carteira');
        $validade_carteira = $request->input('validade_carteira');
        $nome_beneficiario = $request->input('nome_beneficiario');
        $atendimento_rn = $request->input('atendimento_rn');
        $codigo_operadora = $request->input('codigo_operadora');
        $nome_contratado = $request->input('nome_contratado');
        $nome_profissional_solicitante = $request->input('nome_profissional_solicitante');
        $conselho_profissional = $request->input('conselho_profissional');
        $numero_conselho = $request->input('conselho_1');
        $uf_conselho = $request->input('uf_conselho');
        $codigo_cbo = $request->input('codigo_cbo');
        $assinatura_profissional = $request->input('assinatura_profissional');
        $carater_atendimento = $request->input('carater_atendimento');
        $data_solicitacao = $request->input('data_solicitacao');
        $indicacao_clinica = $request->input('indicacao_clinica');
        $codigo_procedimento_solicitado = $request->input('codigo_procedimento_solicitado');
        $descricao_procedimento = $request->input('descricao_procedimento');
        $codigo_operadora_executante = $request->input('codigo_operadora_executante');
        $nome_contratado_executante = $request->input('nome_contratado_executante');
        $codigo_cnes = $request->input('cnes');
        $tipo_atendimento = $request->input('tipo_atendimento');
        $indicacao_acidente = $request->input('indicacao_acidente');
        $tipo_consulta = $request->input('tipo_consulta');
        $motivo_encerramento = $request->input('motivo_encerramento');
        $regime_atendimento = $request->input('regime_atendimento');
        $saude_ocupacional = $request->input('saude_ocupacional');
        $tabela = $request->input('tabela');
        $hora_inicio_atendimento = $request->input('hora_inicio_atendimento');
        $hora_fim_atendimento = $request->input('hora_fim_atendimento');
        $codigo_procedimento_realizado = $request->input('codigo_procedimento_realizado');
        $descricao_procedimento_realizado = $request->input('descricao_procedimento_realizado');
        $quantidade_solicitada = $request->input('quantidade_solicitada');
        $quantidade_autorizada = $request->input('quantidade_autorizada');
        $via = $request->input('via');
        $tecnica = $request->input('tecnica');
        $valor_unitario = $request->input('valor_unitario');
        $valor_total = $request->input('valor_total');
        $codigo_operadora_profissional = $request->input('codigo_operadora_profissional');
        $nome_profissional = $request->input('nome_profissional');
        $sigla_conselho = $request->input('sigla_conselho');
        $numero_conselho_profissional = $request->input('numero_conselho_profissional');
        $uf_profissional = $request->input('uf_profissional');
        $codigo_cbo_profissional = $request->input('codigo_cbo_profissional');
        $data_realizacao = $request->input('data_realizacao');
        $assinatura_beneficiario = $request->input('assinatura_beneficiario');
        $observacao = $request->input('observacao');
        $hash = $request->input('hash');

        $guiasp = GuiaSp::create([
            'user_id' => $user_id,
            'convenio_id' => $convenio_id,
            'registro_ans' => $registro_ans,
            'numero_guia_prestador' => $numero_guia_prestador,
            'data_autorizacao' => $data_autorizacao,
            'senha' => $senha,
            'validade_senha' => $validade_senha,
            'numero_guia_op' => $numero_guia_op,
            'numero_carteira' => $numero_carteira,
            'validade_carteira' => $validade_carteira,
            'nome_beneficiario' => $nome_beneficiario,
            'atendimento_rn' => $atendimento_rn,
            'codigo_operadora' => $codigo_operadora,
            'nome_contratado' => $nome_contratado,
            'nome_profissional_solicitante' => $nome_profissional_solicitante,
            'conselho_profissional' => $conselho_profissional,
            'conselho_1' => $numero_conselho,
            'uf_conselho' => $uf_conselho,
            'codigo_cbo' => $codigo_cbo,
            'assinatura_profissional' => $assinatura_profissional,
            'carater_atendimento' => $carater_atendimento,
            'data_solicitacao' => $data_solicitacao,
            'indicacao_clinica' => $indicacao_clinica,
            'codigo_procedimento_solicitado' => $codigo_procedimento_solicitado,
            'descricao_procedimento' => $descricao_procedimento,
            'codigo_operadora_executante' => $codigo_operadora_executante,
            'nome_contratado_executante' => $nome_contratado_executante,
            'codigo_cnes' => $codigo_cnes,
            'tipo_atendimento' => $tipo_atendimento,
            'indicacao_acidente' => $indicacao_acidente,
            'tipo_consulta' => $tipo_consulta,
            'motivo_encerramento' => $motivo_encerramento,
            'regime_atendimento' => $regime_atendimento,
            'saude_ocupacional' => $saude_ocupacional,
            'tabela' => $tabela,
            'hora_inicio_atendimento' => $hora_inicio_atendimento,
            'hora_fim_atendimento' => $hora_fim_atendimento,
            'codigo_procedimento_realizado' => $codigo_procedimento_realizado,
            'descricao_procedimento_realizado' => $descricao_procedimento_realizado,
            'quantidade_solicitada' => $quantidade_solicitada,
            'quantidade_autorizada' => $quantidade_autorizada,
            'via' => $via,
            'tecnica' => $tecnica,
            'valor_unitario' => $valor_unitario,
            'valor_total' => $valor_total,
            'codigo_operadora_profissional' => $codigo_operadora_profissional,
            'nome_profissional' => $nome_profissional,
            'sigla_conselho' => $sigla_conselho,
            'numero_conselho_profissional' => $numero_conselho_profissional,
            'uf_profissional' => $uf_profissional,
            'codigo_cbo_profissional' => $codigo_cbo_profissional,
            'data_realizacao' => $data_realizacao,
            'assinatura_beneficiario' => $assinatura_beneficiario,
            'observacao' => $observacao,
            'hash' => $hash,
        ]);

        return redirect()->back()->with('success', 'Guia SP/SADT criada com sucesso');
    }

    public function gerarXmlGuiaSp($id)
{
    // Buscar a guia pelo ID
    $guia = GuiaSp::findOrFail($id);

    // Criar o XML utilizando SimpleXMLElement com a estrutura fornecida
    $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><ans:mensagemTISS xmlns:ans="http://www.ans.gov.br/padroes/tiss/schemas" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.ans.gov.br/padroes/tiss/schemas http://www.ans.gov.br/padroes/tiss/schemas/tissV4_01_00.xsd"></ans:mensagemTISS>');

    // Cabeçalho
    $cabecalho = $xml->addChild('ans:cabecalho');
    $identificacaoTransacao = $cabecalho->addChild('ans:identificacaoTransacao');
    $identificacaoTransacao->addChild('ans:tipoTransacao', 'ENVIO_LOTE_GUIAS');
    $identificacaoTransacao->addChild('ans:sequencialTransacao', '0000000001');
    $identificacaoTransacao->addChild('ans:dataRegistroTransacao', date('Y-m-d'));
    $identificacaoTransacao->addChild('ans:horaRegistroTransacao', date('H:i:s'));

    $origem = $cabecalho->addChild('ans:origem');
    $identificacaoPrestador = $origem->addChild('ans:identificacaoPrestador');
    $identificacaoPrestador->addChild('ans:CPF', $guia->cpfContratado);  // Atualize conforme necessário

    $destino = $cabecalho->addChild('ans:destino');
    $destino->addChild('ans:registroANS', $guia->registro_ans);

    $cabecalho->addChild('ans:Padrao', '4.01.00');

    // Lote de Guias
    $prestadorParaOperadora = $xml->addChild('ans:prestadorParaOperadora');
    $loteGuias = $prestadorParaOperadora->addChild('ans:loteGuias');
    $loteGuias->addChild('ans:numeroLote', '0001');
    $guiasTISS = $loteGuias->addChild('ans:guiasTISS');

    // Guia SP/SADT
    $guiaSP = $guiasTISS->addChild('ans:guiaSP-SADT');
    $cabecalhoGuia = $guiaSP->addChild('ans:cabecalhoGuia');
    $cabecalhoGuia->addChild('ans:registroANS', $guia->registro_ans);
    $cabecalhoGuia->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_prestador);

    // Dados de Autorização
    $dadosAutorizacao = $guiaSP->addChild('ans:dadosAutorizacao');
    $dadosAutorizacao->addChild('ans:numeroGuiaOperadora', $guia->numero_guia_op);
    $dadosAutorizacao->addChild('ans:dataAutorizacao', $guia->data_autorizacao);
    $dadosAutorizacao->addChild('ans:senha', $guia->senha);
    $dadosAutorizacao->addChild('ans:dataValidadeSenha', $guia->validade_senha);

    // Dados do Beneficiário
    $dadosBeneficiario = $guiaSP->addChild('ans:dadosBeneficiario');
    $dadosBeneficiario->addChild('ans:numeroCarteira', $guia->numero_carteira);
    $dadosBeneficiario->addChild('ans:atendimentoRN', $guia->atendimento_rn);

    // Dados do Solicitante
    $dadosSolicitante = $guiaSP->addChild('ans:dadosSolicitante');
    $contratadoSolicitante = $dadosSolicitante->addChild('ans:contratadoSolicitante');
    $contratadoSolicitante->addChild('ans:cpfContratado', $guia->cpfContratado);
    $dadosSolicitante->addChild('ans:nomeContratadoSolicitante', $guia->nome_contratado);
    $profissionalSolicitante = $dadosSolicitante->addChild('ans:profissionalSolicitante');
    $profissionalSolicitante->addChild('ans:nomeProfissional', $guia->nome_profissional_solicitante);
    $profissionalSolicitante->addChild('ans:conselhoProfissional', $guia->conselho_profissional);
    $profissionalSolicitante->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho);
    $profissionalSolicitante->addChild('ans:UF', $guia->uf_conselho);
    $profissionalSolicitante->addChild('ans:CBOS', $guia->codigo_cbo);

    // Dados de Solicitação
    $dadosSolicitacao = $guiaSP->addChild('ans:dadosSolicitacao');
    $dadosSolicitacao->addChild('ans:dataSolicitacao', $guia->data_solicitacao);
    $dadosSolicitacao->addChild('ans:caraterAtendimento', $guia->carater_atendimento);
    $dadosSolicitacao->addChild('ans:indicacaoClinica', $guia->indicacao_clinica);

    // Dados do Atendimento
    $dadosAtendimento = $guiaSP->addChild('ans:dadosAtendimento');
    $dadosAtendimento->addChild('ans:tipoAtendimento', $guia->tipo_atendimento);
    $dadosAtendimento->addChild('ans:indicacaoAcidente', $guia->indicacao_acidente);
    $dadosAtendimento->addChild('ans:tipoConsulta', $guia->tipo_consulta);
    $dadosAtendimento->addChild('ans:regimeAtendimento', $guia->regime_atendimento);

    // Procedimentos Executados
    $procedimentosExecutados = $guiaSP->addChild('ans:procedimentosExecutados');
    $procedimentoExecutado = $procedimentosExecutados->addChild('ans:procedimentoExecutado');
    $procedimentoExecutado->addChild('ans:sequencialItem', '1');
    $procedimentoExecutado->addChild('ans:dataExecucao', $guia->data_realizacao);
    $procedimentoExecutado->addChild('ans:horaInicial', $guia->hora_inicio_atendimento);
    $procedimentoExecutado->addChild('ans:horaFinal', $guia->hora_fim_atendimento);
    $procedimento = $procedimentoExecutado->addChild('ans:procedimento');
    $procedimento->addChild('ans:codigoTabela', $guia->codigo_tabela);
    $procedimento->addChild('ans:codigoProcedimento', $guia->codigo_procedimento_realizado);
    $procedimento->addChild('ans:descricaoProcedimento', $guia->descricao_procedimento_realizado);

    // Epílogo
    $epilogo = $xml->addChild('ans:epilogo');
    $epilogo->addChild('ans:hash', $guia->hash);

    // Retornar o XML como resposta para download
    return response($xml->asXML(), 200)
        ->header('Content-Type', 'application/xml')
        ->header('Content-Disposition', 'attachment; filename="guia_sp_' . $guia->id . '.xml"');
}


public function gerarZipGuiaSp($id)
{
    // Buscar a guia pelo ID
    $guia = GuiaSp::findOrFail($id);

    // Criar o XML utilizando SimpleXMLElement com a estrutura fornecida
    $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><ans:mensagemTISS xmlns:ans="http://www.ans.gov.br/padroes/tiss/schemas" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.ans.gov.br/padroes/tiss/schemas http://www.ans.gov.br/padroes/tiss/schemas/tissV4_01_00.xsd"></ans:mensagemTISS>');

    // Cabeçalho
    $cabecalho = $xml->addChild('ans:cabecalho');
    $identificacaoTransacao = $cabecalho->addChild('ans:identificacaoTransacao');
    $identificacaoTransacao->addChild('ans:tipoTransacao', 'ENVIO_LOTE_GUIAS');
    $identificacaoTransacao->addChild('ans:sequencialTransacao', '0000000001');
    $identificacaoTransacao->addChild('ans:dataRegistroTransacao', date('Y-m-d'));
    $identificacaoTransacao->addChild('ans:horaRegistroTransacao', date('H:i:s'));

    $origem = $cabecalho->addChild('ans:origem');
    $identificacaoPrestador = $origem->addChild('ans:identificacaoPrestador');
    $identificacaoPrestador->addChild('ans:CPF', $guia->cpfContratado);

    $destino = $cabecalho->addChild('ans:destino');
    $destino->addChild('ans:registroANS', $guia->registro_ans);

    $cabecalho->addChild('ans:Padrao', '4.01.00');

    // Lote de Guias
    $prestadorParaOperadora = $xml->addChild('ans:prestadorParaOperadora');
    $loteGuias = $prestadorParaOperadora->addChild('ans:loteGuias');
    $loteGuias->addChild('ans:numeroLote', '0001');
    $guiasTISS = $loteGuias->addChild('ans:guiasTISS');

    // Guia SP/SADT
    $guiaSP = $guiasTISS->addChild('ans:guiaSP-SADT');
    $cabecalhoGuia = $guiaSP->addChild('ans:cabecalhoGuia');
    $cabecalhoGuia->addChild('ans:registroANS', $guia->registro_ans);
    $cabecalhoGuia->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_prestador);

    // Dados de Autorização
    $dadosAutorizacao = $guiaSP->addChild('ans:dadosAutorizacao');
    $dadosAutorizacao->addChild('ans:numeroGuiaOperadora', $guia->numero_guia_op);
    $dadosAutorizacao->addChild('ans:dataAutorizacao', $guia->data_autorizacao);
    $dadosAutorizacao->addChild('ans:senha', $guia->senha);
    $dadosAutorizacao->addChild('ans:dataValidadeSenha', $guia->validade_senha);

    // Dados do Beneficiário
    $dadosBeneficiario = $guiaSP->addChild('ans:dadosBeneficiario');
    $dadosBeneficiario->addChild('ans:numeroCarteira', $guia->numero_carteira);
    $dadosBeneficiario->addChild('ans:atendimentoRN', $guia->atendimento_rn);

    // Dados do Solicitante
    $dadosSolicitante = $guiaSP->addChild('ans:dadosSolicitante');
    $contratadoSolicitante = $dadosSolicitante->addChild('ans:contratadoSolicitante');
    $contratadoSolicitante->addChild('ans:cpfContratado', $guia->cpfContratado);
    $dadosSolicitante->addChild('ans:nomeContratadoSolicitante', $guia->nome_contratado);
    $profissionalSolicitante = $dadosSolicitante->addChild('ans:profissionalSolicitante');
    $profissionalSolicitante->addChild('ans:nomeProfissional', $guia->nome_profissional_solicitante);
    $profissionalSolicitante->addChild('ans:conselhoProfissional', $guia->conselho_profissional);
    $profissionalSolicitante->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho);
    $profissionalSolicitante->addChild('ans:UF', $guia->uf_conselho);
    $profissionalSolicitante->addChild('ans:CBOS', $guia->codigo_cbo);

    // Dados de Solicitação
    $dadosSolicitacao = $guiaSP->addChild('ans:dadosSolicitacao');
    $dadosSolicitacao->addChild('ans:dataSolicitacao', $guia->data_solicitacao);
    $dadosSolicitacao->addChild('ans:caraterAtendimento', $guia->carater_atendimento);
    $dadosSolicitacao->addChild('ans:indicacaoClinica', $guia->indicacao_clinica);

    // Dados do Atendimento
    $dadosAtendimento = $guiaSP->addChild('ans:dadosAtendimento');
    $dadosAtendimento->addChild('ans:tipoAtendimento', $guia->tipo_atendimento);
    $dadosAtendimento->addChild('ans:indicacaoAcidente', $guia->indicacao_acidente);
    $dadosAtendimento->addChild('ans:tipoConsulta', $guia->tipo_consulta);
    $dadosAtendimento->addChild('ans:regimeAtendimento', $guia->regime_atendimento);

    // Procedimentos Executados
    $procedimentosExecutados = $guiaSP->addChild('ans:procedimentosExecutados');
    $procedimentoExecutado = $procedimentosExecutados->addChild('ans:procedimentoExecutado');
    $procedimentoExecutado->addChild('ans:sequencialItem', '1');
    $procedimentoExecutado->addChild('ans:dataExecucao', $guia->data_realizacao);
    $procedimentoExecutado->addChild('ans:horaInicial', $guia->hora_inicio_atendimento);
    $procedimentoExecutado->addChild('ans:horaFinal', $guia->hora_fim_atendimento);
    $procedimento = $procedimentoExecutado->addChild('ans:procedimento');
    $procedimento->addChild('ans:codigoTabela', $guia->codigo_tabela);
    $procedimento->addChild('ans:codigoProcedimento', $guia->codigo_procedimento_realizado);
    $procedimento->addChild('ans:descricaoProcedimento', $guia->descricao_procedimento_realizado);

    // Epílogo
    $epilogo = $xml->addChild('ans:epilogo');
    $epilogo->addChild('ans:hash', $guia->hash);

    // Salvar o XML temporariamente no servidor
    $fileName = 'guia_sp_' . $guia->id . '.xml';
    $filePath = storage_path('app/public/' . $fileName);
    $xml->asXML($filePath);

    // Criar um arquivo ZIP contendo o XML
    $zipFileName = 'guia_sp_' . $guia->id . '.zip';
    $zipFilePath = storage_path('app/public/' . $zipFileName);

    $zip = new \ZipArchive;
    if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
        $zip->addFile($filePath, $fileName);  // Adiciona o XML ao ZIP
        $zip->close();
    }

    // Excluir o XML temporário após adicionar ao ZIP
    unlink($filePath);

    // Retornar o arquivo ZIP como download e excluir após o envio
    return response()->download($zipFilePath)->deleteFileAfterSend(true);
}




    public function impressaoGuia($id)
    {
        $guia = GuiaSp::find($id);
        $empresa = Empresas::first();

        return view('formulario.guiasp', compact('guia', 'empresa'));
    }

    public function gerarGuiaSADTMODAL($id)
    {
        // Buscar a agenda pelo ID
        $agenda = Agenda::findOrFail($id);

        // Buscar paciente pelo ID associado à agenda
        $paciente = Pacientes::find($agenda->paciente_id);

        // Buscar profissional com sua especialidade
        $profissional = Profissional::join('especialidade_profissional', 'profissionals.id', '=', 'especialidade_profissional.profissional_id')
            ->leftJoin('especialidades', 'especialidade_profissional.especialidade_id', '=', 'especialidades.id')
            ->select(
                'profissionals.*', // Trazer todos os campos do profissional
                'especialidades.conselho as conselho_profissional',
            )
            ->where('profissionals.id', $agenda->profissional_id)
            ->first();

        // Buscar guia relacionada à agenda
        $guia = GuiaSp::where('agenda_id', $agenda->id)->first();

        // Buscar convênio associado à agenda
        $convenio = Convenio::find($agenda->convenio_id);

        // Buscar primeira empresa cadastrada
        $empresa = Empresas::first();

        // Retornar os dados como JSON para o AJAX preencher o modal
        return response()->json([
            'agenda' => $agenda,
            'paciente' => $paciente,
            'profissional' => $profissional,
            'convenio' => $convenio,
            'empresa' => $empresa,
            'guia' => $guia,
        ]);
    }

    // GuiaSpController.php
    public function gerarGuiaSadt($id)
    {
        // Buscar a agenda pelo ID
        $agenda = Agenda::findOrFail($id);

        // Buscar a guia SADT relacionada
        $guia = GuiaSp::where('agenda_id', $agenda->id)->first();

        // Buscar a empresa associada
        $empresa = Empresas::first();

        // Retornar a view de impressão da Guia SADT
        return view('formulario.guiasp', [
            'agenda' => $agenda,
            'guia' => $guia,
            'empresa' => $empresa,
        ]);
    }

    public function salvarGuiaSADT(Request $request)
    {
        // Verifica se já existe uma guia para o mesmo agenda_id
        $guiaExistente = GuiaSp::where('agenda_id', $request->input('agenda_id'))->exists();

        if ($guiaExistente) {
            // Retorna uma mensagem informando que a guia já existe
            return response()->json([
                'success' => true,
                'message' => 'Guia SADT já existente.',
            ]);
        }

        // Cria uma nova guia SADT
        $guia = new GuiaSp();
        $guia->user_id = auth()->user()->id; // ID do usuário autenticado
        $guia->convenio_id = $request->input('convenio_id');
        $guia->paciente_id = $request->input('paciente_id');
        $guia->profissional_id = $request->input('profissional_id');
        $guia->agenda_id = $request->input('agenda_id');
        $guia->registro_ans = $request->input('registro_ans');
        $guia->numero_guia_prestador = $request->input('numero_guia_prestador');
        $guia->data_autorizacao = $request->input('data_autorizacao');
        $guia->senha = $request->input('senha');
        $guia->validade_senha = $request->input('validade_senha');
        $guia->numero_guia_op = $request->input('numero_guia_op');
        $guia->numero_carteira = $request->input('numero_carteira');
        $guia->validade_carteira = $request->input('validade_carteira');
        $guia->nome_social = $request->input('nome_social');
        $guia->nome_beneficiario = $request->input('nome_beneficiario');
        $guia->atendimento_rn = $request->input('atendimento_rn');
        $guia->codigo_operadora = $request->input('codigo_operadora');
        $guia->nome_contratado = $request->input('nome_contratado');
        $guia->nome_profissional_solicitante = $request->input('nome_profissional_solicitante');
        $guia->conselho_profissional = $request->input('conselho_profissional');
        $guia->numero_conselho = $request->input('conselho_1');
        $guia->uf_conselho = $request->input('uf_conselho');
        $guia->codigo_cbo = $request->input('codigo_cbo');
        $guia->indicacao_acidente = $request->input('indicacao_acidente');
        $guia->regime_atendimento = $request->input('regime_atendimento');
        $guia->saude_ocupacional = $request->input('saude_ocupacional');
        $guia->tipo_atendimento = $request->input('tipo_atendimento');
        $guia->codigo_procedimento_solicitado = $request->input('codigo_procedimento_solicitado');
        $guia->descricao_procedimento = $request->input('descricao_procedimento');
        $guia->codigo_operadora_executante = $request->input('codigo_operadora_executante');
        $guia->nome_contratado_executante = $request->input('nome_contratado_executante');
        $guia->codigo_cnes = $request->input('cnes');
        $guia->observacao = $request->input('observacao');
        $guia->assinatura_profissional = $request->input('assinatura_profissional');
        $guia->carater_atendimento = $request->input('carater_atendimento');
        $guia->data_solicitacao = $request->input('data_solicitacao');
        $guia->indicacao_clinica = $request->input('indicacao_clinica');
        $guia->tipo_consulta = $request->input('tipo_consulta');
        $guia->motivo_encerramento = $request->input('motivo_encerramento');
        $guia->tabela = $request->input('tabela');
        // $guia->hora_inicio_atendimento = $request->input('data_atendimento');
        // $guia->hora_fim_atendimento = $request->input('data_atendimento');
        $guia->codigo_procedimento_realizado = $request->input('codigo_procedimento_realizado');
        $guia->descricao_procedimento_realizado = $request->input('descricao_procedimento_realizado');
        $guia->quantidade_solicitada = $request->input('quantidade_solicitada');
        $guia->quantidade_autorizada = $request->input('quantidade_autorizada');
        $guia->via = $request->input('via');
        $guia->tecnica = $request->input('tecnica');
        $guia->valor_unitario = $request->input('valor_unitario');
        $guia->valor_total = $request->input('valor_total');
        $guia->codigo_operadora_profissional = $request->input('codigo_operadora_profissional');
        $guia->nome_profissional = $request->input('nome_profissional_solicitante');
        $guia->sigla_conselho = $request->input('conselho_profissional');
        $guia->numero_conselho_profissional = $request->input('conselho_1');
        $guia->uf_profissional = $request->input('uf_conselho');
        $guia->codigo_cbo_profissional = $request->input('codigo_cbo');
        // $guia->data_realizacao = $request->input('data_atendimento');
        $guia->assinatura_beneficiario = $request->input('assinatura_beneficiario');
        $guia->hash = $request->input('hash');

        // Salva a guia no banco de dados
        $guia->save();


        // Retorna uma resposta de sucesso
        return response()->json([
            'success' => true,
            'message' => 'Guia SADT criada com sucesso!',
        ]);
    }
    public function visualizarSp($id)
    {
        $guia = GuiaSp::find($id);
        if ($guia) {
            return response()->json($guia); // Enviar os dados como JSON para preenchimento do modal
        } else {
            return response()->json(['error' => 'Guia não encontrada.'], 404);
        }
    }

    public function visualizarGuiaSADT($id)
    {
        // Buscar a agenda pelo ID
        $agenda = Agenda::findOrFail($id);

        // Buscar o paciente relacionado
        $paciente = Pacientes::find($agenda->paciente_id);

        // Buscar o profissional e sua especialidade
        $profissional = Profissional::join('especialidade_profissional', 'profissionals.id', '=', 'especialidade_profissional.profissional_id')
            ->leftJoin('especialidades', 'especialidade_profissional.especialidade_id', '=', 'especialidades.id')
            ->select('profissionals.*', 'especialidades.conselho as conselho_profissional')
            ->where('profissionals.id', $agenda->profissional_id)
            ->first();

        // Buscar a guia SADT relacionada
        $guia = GuiaSp::where('agenda_id', $agenda->id)->first();

        // Buscar o convênio relacionado
        $convenio = Convenio::find($agenda->convenio_id);

        // Buscar a empresa relacionada
        $empresa = Empresas::first();

        // Retornar os dados em JSON para o AJAX
        return response()->json([
            'agenda' => $agenda,
            'paciente' => $paciente,
            'profissional' => $profissional,
            'convenio' => $convenio,
            'empresa' => $empresa,
            'guia' => $guia,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(GuiaSp $guiasp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuiaSp $guiasp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuiaSp $guiasp)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'convenio_id' => 'required|exists:convenios,id',
            'registro_ans' => 'required|string|max:255',
            'numero_guia_prestador' => 'required|string|max:255',
            'numero_carteira' => 'required|string|max:255',
            'nome_beneficiario' => 'required|string|max:255',
            'data_atendimento' => 'required|date',
            'hora_inicio_atendimento' => 'required|date_format:H:i',
            'tipo_consulta' => 'required|string|max:255',
            'indicacao_acidente' => 'nullable|string|max:255',
            'codigo_tabela' => 'required|string|max:255',
            'codigo_procedimento' => 'required|string|max:255',
            'valor_procedimento' => 'required|numeric|min:0',
            'nome_profissional' => 'required|string|max:255',
            'sigla_conselho' => 'required|string|max:10',
            'conselho_1' => 'required|string|max:255',
            'uf_conselho' => 'required|string|max:2',
            'cbo' => 'required|string|max:255',
            'observacao' => 'nullable|string',
            'hash' => 'nullable|string|max:255',
        ]);

        // Atualizar a guia TISS
        $guiasp->update($validatedData);

        return redirect()->back()->with('success', 'Guia TISS atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuiaSp $guiasp)
    {
        //
    }
}
