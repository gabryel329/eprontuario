<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\ContaGuia;
use App\Models\ContasFinanceiras;
use App\Models\Convenio;
use App\Models\Empresas;
use App\Models\Exames;
use App\Models\ExamesAutSadt;
use App\Models\ExamesSadt;
use App\Models\GuiaSp;
use App\Models\MatAgenda;
use App\Models\MedAgenda;
use App\Models\Medicamento;
use App\Models\Pacientes;
use App\Models\ProcAgenda;
use App\Models\Profissional;
use App\Models\TaxaAgenda;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

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
        $identificador = $request->get('identificador');

        // Verifica se o convênio foi fornecido
        if (!$convenio_id) {
            return response()->json(['error' => 'Convênio não encontrado.'], 404);
        }

        // Consulta com base no convênio e identificador (se fornecido)
        $query = GuiaSp::where('convenio_id', $convenio_id);

        if ($identificador) {
            $query->where('identificador', $identificador);
        }

        $guiasp = $query->get();

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
        $cabecalhoGuia->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_op);

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
        $dadosAtendimento->addChild('ans:regimeAtendimento', $guia->regime_atendimento ?? '01');

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

        // Criar nova conta financeira
        $conta = ContasFinanceiras::create([
            'user_id' => auth()->id(),
            'status' => 'Aberto',
            'tipo_conta' => 'Receber',
            'convenio_id' => $guia->convenio_id,
            'tipo_guia' => 'SADT', // Altere conforme necessário
            'parcelas' => '1/1',
            'data_emissao' => Carbon::parse($guia->data_atendimento)->format('Y-m-d'),
            'competencia' => Carbon::parse($guia->data_atendimento)->format('Y-m-d'),
            'data_vencimento' => now()->addDays(30)->format('Y-m-d'),
            'referencia' => $guia->numeracao,
            'tipo_doc' => 'XML',
            'centro_custos' => $guia->nome_contratado_executante ?? 'Desconhecido',
            'documento' => 'lote_guias_SADT_' . $guia->numeracao . '.xml',
            'valor' => $guia->valor_procedimento ?? 0,
            'historico' => 'Guia de SADT - ' . $guia->data_atendimento,
        ]);

        // Criar relacionamento em `conta_guias`
        ContaGuia::create([
            'conta_financeira_id' => $conta->id,
            'guia_id' => $guia->id,
            'tipo_guia' => 'SADT', // Altere conforme necessário
            'lote' => $guia->numeracao,
        ]);

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
        $cabecalhoGuia->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_op);

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
        $dadosAtendimento->addChild('ans:regimeAtendimento', $guia->regime_atendimento ?? '01');

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
        $agenda = Agenda::where('id', $guia->agenda_id)->first();

        // $user = User::where('id', $guia->user_id)->get();
        $ExameSolis = ExamesSadt::where('guia_sps_id', $guia->id)
            ->whereNotNull('codigo_procedimento_solicitado')
            ->get();

        $ExameAuts = ExamesAutSadt::where('guia_sps_id', $guia->id)->get();

        $tabelaMed = $agenda->convenio->tab_med_id; // Nome da tabela de medicamentos do convênio

        if (Schema::hasTable($tabelaMed)) { // Verifica se a tabela existe no banco
            $medicamentos = MedAgenda::where('agenda_id', $agenda->id)
                ->join($tabelaMed, "$tabelaMed.id", '=', 'med_agendas.medicamento_id') // Realiza o INNER JOIN
                ->select('med_agendas.*', "$tabelaMed.medicamento as nome_medicamento") // Seleciona as colunas desejadas
                ->get();
        } else {
            $medicamentos = MedAgenda::where('agenda_id', $agenda->id)
                ->join('medicamentos', 'medicamentos.id', '=', 'med_agendas.medicamento_id')
                ->select('med_agendas.*', 'medicamentos.nome as nome_medicamento') // Seleciona as colunas desejadas
                ->get();// Retorna uma coleção vazia se a tabela não existir
        }
        
        $tabelaMat = $agenda->convenio->tab_mat_id; // Nome da tabela de medicamentos do convênio

        if (Schema::hasTable($tabelaMat)) { // Verifica se a tabela existe no banco
            $materiais = MatAgenda::where('agenda_id', $agenda->id)
                ->join($tabelaMat, "$tabelaMat.id", '=', 'mat_agendas.material_id') // Realiza o INNER JOIN
                ->select('mat_agendas.*', "$tabelaMat.medicamento as nome_material") // Seleciona as colunas desejadas
                ->get();
        } else {
            $materiais = MatAgenda::where('agenda_id', $agenda->id) 
            ->join('produtos', 'produtos.id', '=', 'mat_agendas.material_id') // Realiza o INNER JOIN
            ->select('mat_agendas.*', 'produtos.nome as nome_material') // Seleciona as colunas desejadas
            ->get();
        }
        // Buscar a empresa associada
        $empresa = Empresas::first();

        // Retornar a view de impressão da Guia SADT
        return view('formulario.guiasp', [
            'agenda' => $agenda,
            'guia' => $guia,
            'empresa' => $empresa,
            'ExameSolis' => $ExameSolis,
            'ExameAuts' => $ExameAuts,
            'medicamentos' => $medicamentos,
            'materiais' => $materiais,
            // 'user' => $user,
        ]);
    }

    public function gerarGuiaSADTMODAL($id)
    {
        // Buscar a agenda pelo ID
        $agenda = Agenda::findOrFail($id);

        $procedimentos = ProcAgenda::where('agenda_id', $agenda->id)->get()->map(function ($proc) use ($agenda) {
            $detalhes = null;

            if ($agenda->convenio && $agenda->convenio->tab_proc_id) {
                $tabelaProcedimentos = $agenda->convenio->tab_proc_id;

                // Verifica se a tabela de procedimentos é válida
                if (Schema::hasTable($tabelaProcedimentos)) {
                    if (str_starts_with($tabelaProcedimentos, 'tab_amb92') || str_starts_with($tabelaProcedimentos, 'tab_amb96')) {
                        $detalhes = DB::table($tabelaProcedimentos)
                            ->where('id', $proc->procedimento_id)
                            ->select('descricao as procedimento', 'valor_proc')
                            ->first();
                    } elseif (str_starts_with($tabelaProcedimentos, 'tab_cbhpm')) {
                        $detalhes = DB::table($tabelaProcedimentos)
                            ->where('id', $proc->procedimento_id)
                            ->select('procedimento', 'valor_proc')
                            ->first();
                    }
                }
            }

            // Verifica se o `tab_proc_id` é nulo ou se nenhuma tabela foi encontrada
            if (!$detalhes) {
                $detalhes = DB::table('procedimentos')
                    ->where('id', $proc->procedimento_id)
                    ->select('procedimento', 'valor_proc')
                    ->first();
            }

            // Adiciona os detalhes encontrados ou valores padrão ao ProcAgenda
            return array_merge($proc->toArray(), [
                'procedimento_nome' => $detalhes->procedimento ?? 'Procedimento não encontrado',
                'valor_proc' => $detalhes->valor_proc ?? 0,
                'dataproc' => $proc->dataproc ?? '0000-00-00',
            ]);
        });

        $guia = GuiaSp::where('agenda_id', $agenda->id)->first();

        $ExameSolis = ExamesSadt::where('guia_sps_id', $agenda->id)
            ->whereNotNull('codigo_procedimento_solicitado')
            ->get();

        $ExameAuts = ExamesAutSadt::where('guia_sps_id', $agenda->id)->get();

        if ($agenda && $agenda->paciente && $agenda->paciente->convenio) {
            $tabelaProcedimentos = $agenda->paciente->convenio->tab_proc_id;

            if ($tabelaProcedimentos === null) {
                $exames = DB::table('exames')
                    ->join('procedimentos', 'exames.procedimento_id', '=', 'procedimentos.id')
                    ->where('exames.agenda_id', $agenda->id)
                    ->select('exames.*', 'procedimentos.procedimento as procedimento', 'procedimentos.codigo as codigo')
                    ->orderBy('med_agendas.id', 'asc')
                    ->get();
            } elseif (Schema::hasTable($tabelaProcedimentos)) {
                if (str_starts_with($tabelaProcedimentos, 'tab_amb92') || str_starts_with($tabelaProcedimentos, 'tab_amb96')) {
                    $exames = DB::table('exames')
                        ->join($tabelaProcedimentos, 'exames.procedimento_id', '=', "$tabelaProcedimentos.id")
                        ->where('exames.agenda_id', $agenda->id)
                        ->select('exames.*', "$tabelaProcedimentos.descricao as procedimento", "$tabelaProcedimentos.codigo as codigo")
                        ->orderBy('exames.id', 'asc')
                        ->get();
                } elseif (str_starts_with($tabelaProcedimentos, 'tab_cbhpm')) {
                    $exames = DB::table('exames')
                        ->join($tabelaProcedimentos, 'exames.procedimento_id', '=', "$tabelaProcedimentos.id")
                        ->where('exames.agenda_id', $agenda->id)
                        ->select('exames.*', "$tabelaProcedimentos.procedimento as procedimento", "$tabelaProcedimentos.codigo_anatomico as codigo")
                        ->orderBy('exames.id', 'asc')
                        ->get();
                } else {
                    $exames = collect();
                }
            } else {
                $exames = collect();
            }
        } else {
            $exames = collect();
        }

        // Buscar paciente pelo ID associado à agenda
        $paciente = Pacientes::find($agenda->paciente_id);

        // $tabelaMed = $agenda->convenio->tab_med_id; // Nome da tabela de medicamentos do convênio

        // if (Schema::hasTable($tabelaMed)) { // Verifica se a tabela existe no banco
        //     $medicamentos = MedAgenda::where('agenda_id', $agenda->id)
        //         ->join($tabelaMed, "$tabelaMed.id", '=', 'med_agendas.medicamento_id') // Realiza o INNER JOIN
        //         ->select('med_agendas.*', "$tabelaMed.medicamento as nome_medicamento") // Seleciona as colunas desejadas
        //         ->get();
        // } else {
        //     $medicamentos = collect(); // Retorna uma coleção vazia se a tabela não existir
        // }



        if ($agenda && $agenda->paciente && $agenda->paciente->convenio) {
            $tabelaMedicamentos = $agenda->paciente->convenio->tab_med_id;

            if ($tabelaMedicamentos === null) {
                $medicamentos = DB::table('med_agendas')
                    ->join('medicamentos', 'med_agendas.medicamento_id', '=', 'medicamentos.id')
                    ->where('med_agendas.agenda_id', $agenda->id)
                    ->select('med_agendas.*', 'medicamentos.nome as nome_medicamento', 'medicamentos.tipo as codigo')
                    ->orderBy('med_agendas.id', 'asc')
                    ->get();
            } elseif (Schema::hasTable($tabelaMedicamentos)) {
                if (str_starts_with($tabelaMedicamentos, 'tab_brasindice')) {
                    $medicamentos = DB::table('med_agendas')
                        ->join($tabelaMedicamentos, 'med_agendas.medicamento_id', '=', "$tabelaMedicamentos.id")
                        ->where('med_agendas.agenda_id', $agenda->id)
                        ->select('med_agendas.*', "$tabelaMedicamentos.medicamento as nome_medicamento")
                        ->orderBy('med_agendas.id', 'asc')
                        ->get();
                } elseif (str_starts_with($tabelaMedicamentos, 'tab_simpro')) {
                    $medicamentos = DB::table('med_agendas')
                        ->join($tabelaMedicamentos, 'med_agendas.medicamento_id', '=', "$tabelaMedicamentos.id")
                        ->where('med_agendas.agenda_id', $agenda->id)
                        ->select('med_agendas.*', "$tabelaMedicamentos.medicamento as nome_medicamento")
                        ->orderBy('med_agendas.id', 'asc')
                        ->get();
                } else {
                    $medicamentos = collect();
                }
            } else {
                $medicamentos = collect();
            }
        } else {
            $medicamentos = collect();
        }


        if ($agenda && $agenda->paciente && $agenda->paciente->convenio) {
            $tabelaMaterias = $agenda->paciente->convenio->tab_mat_id;

            if ($tabelaMaterias === null) {
                $materiais = DB::table('mat_agendas')
                    ->join('medicamentos', 'mat_agendas.material_id', '=', 'medicamentos.id')
                    ->where('mat_agendas.agenda_id', $agenda->id)
                    ->select('mat_agendas.*', 'medicamentos.nome as nome_material')
                    ->orderBy('mat_agendas.id', 'asc')
                    ->get();
            } elseif (Schema::hasTable($tabelaMaterias)) {
                if (str_starts_with($tabelaMaterias, 'tab_brasindice')) {
                    $materiais = DB::table('mat_agendas')
                        ->join($tabelaMaterias, 'mat_agendas.material_id', '=', "$tabelaMaterias.id")
                        ->where('mat_agendas.agenda_id', $agenda->id)
                        ->select('mat_agendas.*', "$tabelaMaterias.medicamento as nome_material")
                        ->orderBy('mat_agendas.id', 'asc')
                        ->get();
                } elseif (str_starts_with($tabelaMaterias, 'tab_simpro')) {
                    $materiais = DB::table('mat_agendas')
                        ->join($tabelaMaterias, 'mat_agendas.material_id', '=', "$tabelaMaterias.id")
                        ->where('mat_agendas.agenda_id', $agenda->id)
                        ->select('mat_agendas.*', "$tabelaMaterias.medicamento as nome_material")
                        ->orderBy('mat_agendas.id', 'asc')
                        ->get();
                } else {
                    $materiais = collect();
                }
            } else {
                $materiais = collect();
            }
        } else {
            $materiais = collect();
        }

        $taxas = TaxaAgenda::where('agenda_id', $agenda->id)
            ->join('taxas', 'taxas.id', '=', 'taxa_agendas.id') // Realiza o INNER JOIN
            ->select('taxa_agendas.*', 'taxas.descricao as nome_taxa') // Seleciona as colunas desejadas
            ->get();

        // Buscar profissional com sua especialidade
        $profissional = Profissional::join('especialidade_profissional', 'profissionals.id', '=', 'especialidade_profissional.profissional_id')
            ->leftJoin('especialidades', 'especialidade_profissional.especialidade_id', '=', 'especialidades.id')
            ->select(
                'profissionals.*', // Trazer todos os campos do profissional
                'especialidades.conselho as conselho_profissional',
            )
            ->where('profissionals.id', $agenda->profissional_id)
            ->first();

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
            'taxas' => $taxas,
            'exames' => $exames,
            'procedimentos' => $procedimentos,
            'ExameSolis' => $ExameSolis,
            'ExameAuts' => $ExameAuts,
            'medicamentos' => $medicamentos,
            'materiais' => $materiais,
        ]);
    }

    public function getProcedimentos($pacienteId)
    {
        $agendas = Agenda::where('id', $pacienteId)->first();

        if ($agendas && $agendas->paciente && $agendas->paciente->convenio) {
            $tabelaProcedimentos = $agendas->paciente->convenio->tab_proc_id;

            if ($tabelaProcedimentos === null) {
                $procedimentos = DB::table('procedimentos')
                    ->select('id', 'procedimento', 'codigo', 'valor_proc')
                    ->orderBy('id', 'asc')
                    ->get();
            } elseif (Schema::hasTable($tabelaProcedimentos)) {
                if (str_starts_with($tabelaProcedimentos, 'tab_amb92') || str_starts_with($tabelaProcedimentos, 'tab_amb96')) {
                    $procedimentos = DB::table($tabelaProcedimentos)
                        ->select('id', 'descricao as procedimento', 'codigo', 'valor_proc')
                        ->orderBy('id', 'asc')
                        ->get();
                } elseif (str_starts_with($tabelaProcedimentos, 'tab_cbhpm')) {
                    $procedimentos = DB::table($tabelaProcedimentos)
                        ->select('id', 'procedimento', 'codigo_anatomico as codigo', 'valor_proc')
                        ->orderBy('id', 'asc')
                        ->get();
                } else {
                    $procedimentos = [];
                }
            } else {
                $procedimentos = [];
            }
        } else {
            $procedimentos = [];
        }

        return response()->json($procedimentos);
    }


    public function gerarXmlGuiasadtEmLote(Request $request)
    {
        $guiaIds = $request->input('guia_ids');
        $numeracao = $request->input('numeracao'); // Recebe a numeração do frontend, se fornecida

        $guias = GuiaSp::with('profissional', 'paciente.convenio')->whereIn('id', $guiaIds)->get();

        $exameSadtAut = ExamesAutSadt::whereIn('guia_sps_id', $guiaIds)->get();
        // Verificar a presença de `numeracao`
        $sequencialTransacao = $numeracao ?? $guias->firstWhere('numeracao', '!=', null)->numeracao;

        // Se nenhuma `numeracao` estiver disponível, retorne um erro
        if (is_null($sequencialTransacao)) {
            return response()->json([
                'error' => 'Numeração não encontrada para o lote. Por favor, insira a numeração para o lote.'
            ], 422);
        }

        // Atualiza ou define a numeração para todas as guias
        foreach ($guias as $guia) {
            if (is_null($guia->numeracao)) {
                $guia->numeracao = $sequencialTransacao;
                $guia->save();
            }
        }

        // Criar o XML utilizando SimpleXMLElement
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><ans:mensagemTISS xmlns:ans="http://www.ans.gov.br/padroes/tiss/schemas" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.ans.gov.br/padroes/tiss/schemas http://www.ans.gov.br/padroes/tiss/schemas/tissV4_01_00.xsd"></ans:mensagemTISS>');

        // Cabeçalho
        $cabecalho = $xml->addChild('ans:cabecalho');
        $identificacaoTransacao = $cabecalho->addChild('ans:identificacaoTransacao');
        $identificacaoTransacao->addChild('ans:tipoTransacao', 'ENVIO_LOTE_GUIAS');
        $identificacaoTransacao->addChild('ans:sequencialTransacao', $sequencialTransacao);
        $identificacaoTransacao->addChild('ans:dataRegistroTransacao', date('Y-m-d'));
        $identificacaoTransacao->addChild('ans:horaRegistroTransacao', date('H:i:s'));

        $origem = $cabecalho->addChild('ans:origem');
        $identificacaoPrestador = $origem->addChild('ans:identificacaoPrestador');
        $identificacaoPrestador->addChild('ans:CNPJ', $guia->codigo_operadora); // CPF do profissional da primeira guia

        $destino = $cabecalho->addChild('ans:destino');
        $destino->addChild('ans:registroANS', $guias->first()->registro_ans);

        $cabecalho->addChild('ans:Padrao', '4.01.00');

        // Lote de Guias
        $prestadorParaOperadora = $xml->addChild('ans:prestadorParaOperadora');
        $loteGuias = $prestadorParaOperadora->addChild('ans:loteGuias');
        $loteGuias->addChild('ans:numeroLote', $sequencialTransacao);
        $guiasTISS = $loteGuias->addChild('ans:guiasTISS');

        // Iterar sobre cada guia
        foreach ($guias as $guia) {
            // Puxar os procedimentos e materiais relacionados à guia
            $procedimentos = DB::table('exames_aut_sadt')
                ->where('guia_sps_id', $guia->id)
                ->get();

            $materiais = collect();
            if ($guia->paciente->convenio) {
                $tabelaMateriais = $guia->paciente->convenio->tab_mat_id;

                if ($tabelaMateriais && Schema::hasTable($tabelaMateriais)) {
                    $materiais = DB::table('mat_agendas')
                        ->join($tabelaMateriais, 'mat_agendas.material_id', '=', "{$tabelaMateriais}.id")
                        ->where('mat_agendas.agenda_id', $guia->agenda_id)
                        ->select(
                            'mat_agendas.id as id',
                            'mat_agendas.quantidade as quantidade',
                            'mat_agendas.unidade_medida',
                            "{$tabelaMateriais}.medicamento as nome_produto",
                            "{$tabelaMateriais}.medicamento as descricao_produto",
                            DB::raw("'MEDICAMENTO' as tipo_produto"),
                            "{$tabelaMateriais}.preco as valor_unitario_produto",
                            "{$tabelaMateriais}.id as material_id"
                        )
                        ->get();
                }
            }

            $medicamentos = collect();
            if ($guia->paciente->convenio) {
                $tabelaMedicamentos = $guia->paciente->convenio->tab_med_id;

                if ($tabelaMedicamentos && Schema::hasTable($tabelaMedicamentos)) {
                    $medicamentos = DB::table('med_agendas')
                        ->join($tabelaMedicamentos, 'med_agendas.medicamento_id', '=', "{$tabelaMedicamentos}.id")
                        ->where('med_agendas.agenda_id', $guia->agenda_id)
                        ->select(
                            'med_agendas.id as id',
                            'med_agendas.quantidade as quantidade',
                            'med_agendas.unidade_medida',
                            "{$tabelaMedicamentos}.medicamento as nome_produto",
                            "{$tabelaMedicamentos}.medicamento as descricao_produto",
                            DB::raw("'MEDICAMENTO' as tipo_produto"),
                            "{$tabelaMedicamentos}.preco as valor_unitario_produto",
                            "{$tabelaMedicamentos}.id as material_id"
                        )
                        ->get();
                }
            }

            $outrasDespesasItems = $materiais->concat($medicamentos);

            // Calcular valores totais
            $valorProcedimentos = $procedimentos->sum('valor_total');
            $valorMateriais = $materiais->sum(fn($item) => $item->quantidade * $item->valor_unitario_produto);
            $valorMedicamentos = $medicamentos->sum(fn($item) => $item->quantidade * $item->valor_unitario_produto);
            $valorOPME = 0.00; // Adicionar lógica para OPME se necessário
            $valorTotalGeral = $valorProcedimentos + $valorMateriais + $valorMedicamentos + $valorOPME;


            // Adicionar cada guia ao XML
            $guiaSadt = $guiasTISS->addChild('ans:guiaSP-SADT');

            // Cabeçalho da Guia
            $cabecalhoGuia = $guiaSadt->addChild('ans:cabecalhoGuia');
            $cabecalhoGuia->addChild('ans:registroANS', $guia->registro_ans);
            $cabecalhoGuia->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_op);

            // Dados de Autorização
            $dadosAutorizacao = $guiaSadt->addChild('ans:dadosAutorizacao');
            $dadosAutorizacao->addChild('ans:numeroGuiaOperadora', $guia->numero_guia_op);
            $dadosAutorizacao->addChild('ans:dataAutorizacao', $guia->data_autorizacao);
            $dadosAutorizacao->addChild('ans:senha', $guia->senha);
            $dadosAutorizacao->addChild('ans:dataValidadeSenha', $guia->validade_senha);

            // Dados do Beneficiário
            $dadosBeneficiario = $guiaSadt->addChild('ans:dadosBeneficiario');
            $dadosBeneficiario->addChild('ans:numeroCarteira', $guia->numero_carteira);
            $dadosBeneficiario->addChild('ans:atendimentoRN', $guia->atendimento_rn);

            // Dados do Solicitante
            $dadosSolicitante = $guiaSadt->addChild('ans:dadosSolicitante');
            $contratadoSolicitante = $dadosSolicitante->addChild('ans:contratadoSolicitante');
            $contratadoSolicitante->addChild('ans:cnpjContratado', $guia->codigo_operadora ?? '');
            $dadosSolicitante->addChild('ans:nomeContratadoSolicitante', $guia->nome_contratado_executante);
            $profissionalSolicitante = $dadosSolicitante->addChild('ans:profissionalSolicitante');
            $profissionalSolicitante->addChild('ans:nomeProfissional', $guia->nome_profissional_solicitante);
            $profissionalSolicitante->addChild('ans:conselhoProfissional', $guia->conselho_profissional);
            $profissionalSolicitante->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho);
            $profissionalSolicitante->addChild('ans:UF', $guia->uf_conselho);
            $profissionalSolicitante->addChild('ans:CBOS', $guia->codigo_cbo);

            // Dados Solicitação
            $dadosSolicitacao = $guiaSadt->addChild('ans:dadosSolicitacao');
            $dadosSolicitacao->addChild('ans:dataSolicitacao', $guia->data_autorizacao);
            $dadosSolicitacao->addChild('ans:caraterAtendimento', $guia->carater_atendimento);
            $dadosSolicitacao->addChild('ans:indicacaoClinica', $guia->indicacao_clinica);

            // Dados do Executante
            $dadosExecutante = $guiaSadt->addChild('ans:dadosExecutante');
            $contratadoExecutante = $dadosExecutante->addChild('ans:contratadoExecutante');
            $contratadoExecutante->addChild('ans:cpfContratado', $guia->profissional->cpf ?? '');
            $dadosExecutante->addChild('ans:CNES', $guia->codigo_cnes);

            // Dados do Atendimento
            $dadosAtendimento = $guiaSadt->addChild('ans:dadosAtendimento');
            $dadosAtendimento->addChild('ans:tipoAtendimento', $guia->tipo_atendimento);
            $dadosAtendimento->addChild('ans:indicacaoAcidente', $guia->indicacao_acidente);
            $dadosAtendimento->addChild('ans:tipoConsulta', $guia->tipo_consulta);
            $dadosAtendimento->addChild('ans:regimeAtendimento', $guia->regime_atendimento ?? '01');

            // Procedimentos Executados
            $procedimentosExecutados = $guiaSadt->addChild('ans:procedimentosExecutados');
            foreach ($procedimentos as $index => $procedimento) {
                $procedimentoExecutado = $procedimentosExecutados->addChild('ans:procedimentoExecutado');
                $procedimentoExecutado->addChild('ans:sequencialItem', $index + 1);
                $procedimentoExecutado->addChild('ans:dataExecucao', $procedimento->data_real ?? $guia->data_autorizacao);
                $procedimentoExecutado->addChild('ans:horaInicial', $procedimento->hora_inicio_atendimento ?? $guia->hora_inicio_atendimento);
                $procedimentoExecutado->addChild('ans:horaFinal', $procedimento->hora_fim_atendimento ?? $guia->hora_fim_atendimento);

                $dadosProcedimento = $procedimentoExecutado->addChild('ans:procedimento');
                $dadosProcedimento->addChild('ans:codigoTabela', $procedimento->tabela);
                $dadosProcedimento->addChild('ans:codigoProcedimento', $procedimento->codigo_procedimento_realizado);
                $dadosProcedimento->addChild('ans:descricaoProcedimento', $procedimento->descricao_procedimento_realizado);
                $procedimentoExecutado->addChild('ans:quantidadeExecutada', $procedimento->quantidade_autorizada);
                if (!empty($procedimento->via)) {
                    $procedimentoExecutado->addChild('ans:viaAcesso', $procedimento->via);
                }
                $procedimentoExecutado->addChild('ans:reducaoAcrescimo', $procedimento->fator_red_acres);
                $procedimentoExecutado->addChild('ans:valorUnitario', $procedimento->valor_unitario);
                $procedimentoExecutado->addChild('ans:valorTotal', $procedimento->valor_total);

                // Adicionando a equipe da guia diretamente da $guia
                $equipeSadt = $procedimentoExecutado->addChild('ans:equipeSadt');
                // Profissional 1 (sempre presente)
                if (!empty($guia->grua) && !empty($guia->codigo_operadora_profissional)) {
                    $codProfissional = $equipeSadt->addChild('ans:grauPart', $guia->grua);
                    $codProfissional = $equipeSadt->addChild('ans:codProfissional');
                    $codProfissional->addChild('ans:cpfContratado', $guia->codigo_operadora_profissional);

                    $equipeSadt->addChild('ans:nomeProf', $guia->nome_profissional);
                    $equipeSadt->addChild('ans:conselho', $guia->sigla_conselho);
                    $equipeSadt->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho_profissional);
                    $equipeSadt->addChild('ans:UF', $guia->uf_profissional);
                    $equipeSadt->addChild('ans:CBOS', $guia->codigo_cbo_profissional);
                }

                // Profissional 2 (só adiciona se houver dados)
                if (!empty($guia->grau1) && !empty($guia->codigo_operadora_profissional1)) {
                    $codProfissional = $equipeSadt->addChild('ans:grauPart', $guia->grau1);
                    $codProfissional = $equipeSadt->addChild('ans:codProfissional');
                    $codProfissional->addChild('ans:cpfContratado', $guia->codigo_operadora_profissional1);

                    $equipeSadt->addChild('ans:nomeProf', $guia->nome_profissional1);
                    $equipeSadt->addChild('ans:conselho', $guia->sigla_conselho1);
                    $equipeSadt->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho_profissional1);
                    $equipeSadt->addChild('ans:UF', $guia->uf_profissional1);
                    $equipeSadt->addChild('ans:CBOS', $guia->codigo_cbo_profissional1);
                }

                // Profissional 3 (só adiciona se houver dados)
                if (!empty($guia->grau2) && !empty($guia->codigo_operadora_profissional2)) {
                    $codProfissional = $equipeSadt->addChild('ans:grauPart', $guia->grau2);
                    $codProfissional = $equipeSadt->addChild('ans:codProfissional');
                    $codProfissional->addChild('ans:cpfContratado', $guia->codigo_operadora_profissional2);

                    $equipeSadt->addChild('ans:nomeProf', $guia->nome_profissional2);
                    $equipeSadt->addChild('ans:conselho', $guia->sigla_conselho2);
                    $equipeSadt->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho_profissional2);
                    $equipeSadt->addChild('ans:UF', $guia->uf_profissional2);
                    $equipeSadt->addChild('ans:CBOS', $guia->codigo_cbo_profissional2);
                }
            }
            if (is_array($outrasDespesasItems) && count($outrasDespesasItems) > 0) {
                $outrasDespesas = $guiaSadt->addChild('ans:outrasDespesas');
                foreach ($outrasDespesasItems as $index => $item) {
                    $despesa = $outrasDespesas->addChild('ans:despesa');
                    $despesa->addChild('ans:sequencialItem', $index + 1);
                    $despesa->addChild('ans:codigoDespesa');

                    $servicosExecutados = $despesa->addChild('ans:servicosExecutados');
                    $servicosExecutados->addChild('ans:dataExecucao', $guia->data_autorizacao);
                    $servicosExecutados->addChild('ans:horaInicial', $guia->hora_inicio_atendimento);
                    $servicosExecutados->addChild('ans:horaFinal', $guia->hora_fim_atendimento);

                    $codigoTabela = strtoupper(trim($item->tipo_produto)) === 'MEDICAMENTO' ? '20' : '19';
                    $servicosExecutados->addChild('ans:codigoTabela', $codigoTabela);

                    $servicosExecutados->addChild('ans:codigoProcedimento', $item->material_id);
                    $servicosExecutados->addChild('ans:quantidadeExecutada', $item->quantidade);
                    $servicosExecutados->addChild('ans:unidadeMedida', $item->unidade_medida);
                    $servicosExecutados->addChild('ans:reducaoAcrescimo', '1.00');
                    $servicosExecutados->addChild('ans:valorUnitario', $item->valor_unitario_produto);
                    $servicosExecutados->addChild('ans:valorTotal', $item->quantidade * $item->valor_unitario_produto);
                    $servicosExecutados->addChild('ans:descricaoProcedimento', $item->nome_produto);
                }
            }
        }

        $valorTotal = $guiaSadt->addChild('ans:valorTotal');
        $valorTotal->addChild('ans:valorProcedimentos', number_format($valorProcedimentos, 2, '.', ''));
        $valorTotal->addChild('ans:valorMateriais', number_format($valorMateriais, 2, '.', ''));
        $valorTotal->addChild('ans:valorMedicamentos', number_format($valorMedicamentos, 2, '.', ''));
        $valorTotal->addChild('ans:valorOPME', number_format($valorOPME, 2, '.', ''));
        $valorTotal->addChild('ans:valorTotalGeral', number_format($valorTotalGeral, 2, '.', ''));

        // Epílogo
        $epilogo = $xml->addChild('ans:epilogo');
        $epilogo->addChild('ans:hash', md5($xml->asXML()));

        // Verifica se já existe uma conta financeira para esse lote
        $contaExistente = ContaGuia::where('lote', $sequencialTransacao)->first();

        if (!$contaExistente) {
            // Atualiza as guias com a numeração correta
            foreach ($guias as $guia) {
                $guia->identificador = 'GERADO';
                $guia->save();
            }

            // Calcula o valor total do lote
            $valorTotal = $exameSadtAut->sum('valor_total');

            $referencia = $sequencialTransacao;

            // Cria a conta financeira
            $conta = ContasFinanceiras::create([
                'user_id' => auth()->id(),
                'status' => 'Aberto',
                'tipo_conta' => 'Receber',
                'convenio_id' => $guias->first()->convenio_id,
                'tipo_guia' => 'SADT',
                'parcelas' => '1/1',
                'data_emissao' => Carbon::parse($guia->data_realizacao)->format('Y-m-d'),
                'competencia' => Carbon::parse($guia->data_realizacao)->format('Y-m-d'),
                'data_vencimento' => now()->addDays(30)->format('Y-m-d'),
                'referencia' => $referencia,
                'tipo_doc' => 'XML',
                'centro_custos' => $guias->first()->nome_contratado ?? 'Desconhecido',
                'documento' => 'lote_guias_sadt_' . $sequencialTransacao . '.xml',
                'valor' => $valorTotal,
                'historico' => 'Guia SADT - ' . $guia->data_realizacao,
            ]);

            // Salva o relacionamento na tabela `conta_guias`
            foreach ($guias as $guia) {
                ContaGuia::create([
                    'conta_financeira_id' => $conta->id,
                    'guia_id' => $guia->id,
                    'tipo_guia' => 'SADT',
                    'lote' => $sequencialTransacao,
                ]);
            }
        } else {
            // Apenas atualiza as guias e registra o relacionamento se não existirem
            foreach ($guias as $guia) {
                $existeRelacionamento = ContaGuia::where('guia_id', $guia->id)
                    ->where('tipo_guia', 'SADT')
                    ->exists();

                if (!$existeRelacionamento) {
                    $guia->numeracao = $sequencialTransacao;
                    $guia->identificador = 'GERADO';
                    $guia->save();

                    ContaGuia::create([
                        'conta_financeira_id' => $contaExistente->conta_financeira_id,
                        'guia_id' => $guia->id,
                        'tipo_guia' => 'SADT',
                        'lote' => $sequencialTransacao,
                    ]);
                }
            }
        }

        // Retorna o XML como download
        $fileName = 'lote_guias_sadt.xml';
        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function gerarZipGuiasadtEmLote(Request $request)
    {
        $guiaIds = $request->input('guia_ids');
        $numeracao = $request->input('numeracao');

        $guias = GuiaSp::with('profissional', 'paciente.convenio')->whereIn('id', $guiaIds)->get();

        $sequencialTransacao = $numeracao ?? $guias->firstWhere('numeracao', '!=', null)->numeracao;

        // Atualiza ou define a numeração para todas as guias
        foreach ($guias as $guia) {
            if (is_null($guia->numeracao)) {
                $guia->numeracao = $sequencialTransacao;
                $guia->save();
            }
        }

        // Criar o XML utilizando SimpleXMLElement
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><ans:mensagemTISS xmlns:ans="http://www.ans.gov.br/padroes/tiss/schemas" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.ans.gov.br/padroes/tiss/schemas http://www.ans.gov.br/padroes/tiss/schemas/tissV4_01_00.xsd"></ans:mensagemTISS>');

        // Cabeçalho
        $cabecalho = $xml->addChild('ans:cabecalho');
        $identificacaoTransacao = $cabecalho->addChild('ans:identificacaoTransacao');
        $identificacaoTransacao->addChild('ans:tipoTransacao', 'ENVIO_LOTE_GUIAS');
        $identificacaoTransacao->addChild('ans:sequencialTransacao', $sequencialTransacao);
        $identificacaoTransacao->addChild('ans:dataRegistroTransacao', date('Y-m-d'));
        $identificacaoTransacao->addChild('ans:horaRegistroTransacao', date('H:i:s'));

        $origem = $cabecalho->addChild('ans:origem');
        $identificacaoPrestador = $origem->addChild('ans:identificacaoPrestador');
        $identificacaoPrestador->addChild('ans:CNPJ', $guia->codigo_operadora); // CPF do profissional da primeira guia

        $destino = $cabecalho->addChild('ans:destino');
        $destino->addChild('ans:registroANS', $guias->first()->registro_ans);

        $cabecalho->addChild('ans:Padrao', '4.01.00');

        // Lote de Guias
        $prestadorParaOperadora = $xml->addChild('ans:prestadorParaOperadora');
        $loteGuias = $prestadorParaOperadora->addChild('ans:loteGuias');
        $loteGuias->addChild('ans:numeroLote', $sequencialTransacao);
        $guiasTISS = $loteGuias->addChild('ans:guiasTISS');

        // Iterar sobre cada guia
        foreach ($guias as $guia) {
            // Puxar os procedimentos e materiais relacionados à guia
            $procedimentos = DB::table('exames_aut_sadt')
                ->where('guia_sps_id', $guia->id)
                ->get();

            $materiais = collect();
            if ($guia->paciente->convenio) {
                $tabelaMateriais = $guia->paciente->convenio->tab_mat_id;

                if ($tabelaMateriais && Schema::hasTable($tabelaMateriais)) {
                    $materiais = DB::table('mat_agendas')
                        ->join($tabelaMateriais, 'mat_agendas.material_id', '=', "{$tabelaMateriais}.id")
                        ->where('mat_agendas.agenda_id', $guia->agenda_id)
                        ->select(
                            'mat_agendas.id as id',
                            'mat_agendas.quantidade as quantidade',
                            'mat_agendas.unidade_medida',
                            "{$tabelaMateriais}.medicamento as nome_produto",
                            "{$tabelaMateriais}.medicamento as descricao_produto",
                            DB::raw("'MEDICAMENTO' as tipo_produto"),
                            "{$tabelaMateriais}.preco as valor_unitario_produto",
                            "{$tabelaMateriais}.id as material_id"
                        )
                        ->get();
                }
            }

            $medicamentos = collect();
            if ($guia->paciente->convenio) {
                $tabelaMedicamentos = $guia->paciente->convenio->tab_med_id;

                if ($tabelaMedicamentos && Schema::hasTable($tabelaMedicamentos)) {
                    $medicamentos = DB::table('med_agendas')
                        ->join($tabelaMedicamentos, 'med_agendas.medicamento_id', '=', "{$tabelaMedicamentos}.id")
                        ->where('med_agendas.agenda_id', $guia->agenda_id)
                        ->select(
                            'med_agendas.id as id',
                            'med_agendas.quantidade as quantidade',
                            'med_agendas.unidade_medida',
                            "{$tabelaMedicamentos}.medicamento as nome_produto",
                            "{$tabelaMedicamentos}.medicamento as descricao_produto",
                            DB::raw("'MEDICAMENTO' as tipo_produto"),
                            "{$tabelaMedicamentos}.preco as valor_unitario_produto",
                            "{$tabelaMedicamentos}.id as material_id"
                        )
                        ->get();
                }
            }

            $outrasDespesasItems = $materiais->concat($medicamentos);

            // Calcular valores totais
            $valorProcedimentos = $procedimentos->sum('valor_total');
            $valorMateriais = $materiais->sum(fn($item) => $item->quantidade * $item->valor_unitario_produto);
            $valorMedicamentos = $medicamentos->sum(fn($item) => $item->quantidade * $item->valor_unitario_produto);
            $valorOPME = 0.00; // Adicionar lógica para OPME se necessário
            $valorTotalGeral = $valorProcedimentos + $valorMateriais + $valorMedicamentos + $valorOPME;


            // Adicionar cada guia ao XML
            $guiaSadt = $guiasTISS->addChild('ans:guiaSP-SADT');

            // Cabeçalho da Guia
            $cabecalhoGuia = $guiaSadt->addChild('ans:cabecalhoGuia');
            $cabecalhoGuia->addChild('ans:registroANS', $guia->registro_ans);
            $cabecalhoGuia->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_op);

            // Dados de Autorização
            $dadosAutorizacao = $guiaSadt->addChild('ans:dadosAutorizacao');
            $dadosAutorizacao->addChild('ans:numeroGuiaOperadora', $guia->numero_guia_op);
            $dadosAutorizacao->addChild('ans:dataAutorizacao', $guia->data_autorizacao);
            $dadosAutorizacao->addChild('ans:senha', $guia->senha);
            $dadosAutorizacao->addChild('ans:dataValidadeSenha', $guia->validade_senha);

            // Dados do Beneficiário
            $dadosBeneficiario = $guiaSadt->addChild('ans:dadosBeneficiario');
            $dadosBeneficiario->addChild('ans:numeroCarteira', $guia->numero_carteira);
            $dadosBeneficiario->addChild('ans:atendimentoRN', $guia->atendimento_rn);

            // Dados do Solicitante
            $dadosSolicitante = $guiaSadt->addChild('ans:dadosSolicitante');
            $contratadoSolicitante = $dadosSolicitante->addChild('ans:contratadoSolicitante');
            $contratadoSolicitante->addChild('ans:cnpjContratado', $guia->codigo_operadora ?? '');
            $dadosSolicitante->addChild('ans:nomeContratadoSolicitante', $guia->nome_contratado_executante);
            $profissionalSolicitante = $dadosSolicitante->addChild('ans:profissionalSolicitante');
            $profissionalSolicitante->addChild('ans:nomeProfissional', $guia->nome_profissional_solicitante);
            $profissionalSolicitante->addChild('ans:conselhoProfissional', $guia->conselho_profissional);
            $profissionalSolicitante->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho);
            $profissionalSolicitante->addChild('ans:UF', $guia->uf_conselho);
            $profissionalSolicitante->addChild('ans:CBOS', $guia->codigo_cbo);

            // Dados Solicitação
            $dadosSolicitacao = $guiaSadt->addChild('ans:dadosSolicitacao');
            $dadosSolicitacao->addChild('ans:dataSolicitacao', $guia->data_autorizacao);
            $dadosSolicitacao->addChild('ans:caraterAtendimento', $guia->carater_atendimento);
            $dadosSolicitacao->addChild('ans:indicacaoClinica', $guia->indicacao_clinica);

            // Dados do Executante
            $dadosExecutante = $guiaSadt->addChild('ans:dadosExecutante');
            $contratadoExecutante = $dadosExecutante->addChild('ans:contratadoExecutante');
            $contratadoExecutante->addChild('ans:cpfContratado', $guia->profissional->cpf ?? '');
            $dadosExecutante->addChild('ans:CNES', $guia->codigo_cnes);

            // Dados do Atendimento
            $dadosAtendimento = $guiaSadt->addChild('ans:dadosAtendimento');
            $dadosAtendimento->addChild('ans:tipoAtendimento', $guia->tipo_atendimento);
            $dadosAtendimento->addChild('ans:indicacaoAcidente', $guia->indicacao_acidente);
            $dadosAtendimento->addChild('ans:tipoConsulta', $guia->tipo_consulta);
            $dadosAtendimento->addChild('ans:regimeAtendimento', $guia->regime_atendimento ?? '01');

            // Procedimentos Executados
            $procedimentosExecutados = $guiaSadt->addChild('ans:procedimentosExecutados');
            foreach ($procedimentos as $index => $procedimento) {
                $procedimentoExecutado = $procedimentosExecutados->addChild('ans:procedimentoExecutado');
                $procedimentoExecutado->addChild('ans:sequencialItem', $index + 1);
                $procedimentoExecutado->addChild('ans:dataExecucao', $procedimento->data_real ?? $guia->data_autorizacao);
                $procedimentoExecutado->addChild('ans:horaInicial', $procedimento->hora_inicio_atendimento ?? $guia->hora_inicio_atendimento);
                $procedimentoExecutado->addChild('ans:horaFinal', $procedimento->hora_fim_atendimento ?? $guia->hora_fim_atendimento);

                $dadosProcedimento = $procedimentoExecutado->addChild('ans:procedimento');
                $dadosProcedimento->addChild('ans:codigoTabela', $procedimento->tabela);
                $dadosProcedimento->addChild('ans:codigoProcedimento', $procedimento->codigo_procedimento_realizado);
                $dadosProcedimento->addChild('ans:descricaoProcedimento', $procedimento->descricao_procedimento_realizado);
                $procedimentoExecutado->addChild('ans:quantidadeExecutada', $procedimento->quantidade_autorizada);
                if (!empty($procedimento->via)) {
                    $procedimentoExecutado->addChild('ans:viaAcesso', $procedimento->via);
                }
                $procedimentoExecutado->addChild('ans:reducaoAcrescimo', '1.00');
                $procedimentoExecutado->addChild('ans:valorUnitario', $procedimento->valor_unitario);
                $procedimentoExecutado->addChild('ans:valorTotal', $procedimento->valor_total);

                // Adicionando a equipe da guia diretamente da $guia
                $equipeSadt = $procedimentoExecutado->addChild('ans:equipeSadt');
                // Profissional 1 (sempre presente)
                if (!empty($guia->grua) && !empty($guia->codigo_operadora_profissional)) {
                    $codProfissional = $equipeSadt->addChild('ans:grauPart', $guia->grua);
                    $codProfissional = $equipeSadt->addChild('ans:codProfissional');
                    $codProfissional->addChild('ans:cpfContratado', $guia->codigo_operadora_profissional);

                    $equipeSadt->addChild('ans:nomeProf', $guia->nome_profissional);
                    $equipeSadt->addChild('ans:conselho', $guia->sigla_conselho);
                    $equipeSadt->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho_profissional);
                    $equipeSadt->addChild('ans:UF', $guia->uf_profissional);
                    $equipeSadt->addChild('ans:CBOS', $guia->codigo_cbo_profissional);
                }

                // Profissional 2 (só adiciona se houver dados)
                if (!empty($guia->grau1) && !empty($guia->codigo_operadora_profissional1)) {
                    $codProfissional = $equipeSadt->addChild('ans:grauPart', $guia->grau1);
                    $codProfissional = $equipeSadt->addChild('ans:codProfissional');
                    $codProfissional->addChild('ans:cpfContratado', $guia->codigo_operadora_profissional1);

                    $equipeSadt->addChild('ans:nomeProf', $guia->nome_profissional1);
                    $equipeSadt->addChild('ans:conselho', $guia->sigla_conselho1);
                    $equipeSadt->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho_profissional1);
                    $equipeSadt->addChild('ans:UF', $guia->uf_profissional1);
                    $equipeSadt->addChild('ans:CBOS', $guia->codigo_cbo_profissional1);
                }

                // Profissional 3 (só adiciona se houver dados)
                if (!empty($guia->grau2) && !empty($guia->codigo_operadora_profissional2)) {
                    $codProfissional = $equipeSadt->addChild('ans:grauPart', $guia->grau2);
                    $codProfissional = $equipeSadt->addChild('ans:codProfissional');
                    $codProfissional->addChild('ans:cpfContratado', $guia->codigo_operadora_profissional2);

                    $equipeSadt->addChild('ans:nomeProf', $guia->nome_profissional2);
                    $equipeSadt->addChild('ans:conselho', $guia->sigla_conselho2);
                    $equipeSadt->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho_profissional2);
                    $equipeSadt->addChild('ans:UF', $guia->uf_profissional2);
                    $equipeSadt->addChild('ans:CBOS', $guia->codigo_cbo_profissional2);
                }
            }
            if (is_array($outrasDespesasItems) && count($outrasDespesasItems) > 0) {
                $outrasDespesas = $guiaSadt->addChild('ans:outrasDespesas');
                foreach ($outrasDespesasItems as $index => $item) {
                    $despesa = $outrasDespesas->addChild('ans:despesa');
                    $despesa->addChild('ans:sequencialItem', $index + 1);
                    $despesa->addChild('ans:codigoDespesa');

                    $servicosExecutados = $despesa->addChild('ans:servicosExecutados');
                    $servicosExecutados->addChild('ans:dataExecucao', $guia->data_autorizacao);
                    $servicosExecutados->addChild('ans:horaInicial', $guia->hora_inicio_atendimento);
                    $servicosExecutados->addChild('ans:horaFinal', $guia->hora_fim_atendimento);

                    $codigoTabela = strtoupper(trim($item->tipo_produto)) === 'MEDICAMENTO' ? '20' : '19';
                    $servicosExecutados->addChild('ans:codigoTabela', $codigoTabela);

                    $servicosExecutados->addChild('ans:codigoProcedimento', $item->material_id);
                    $servicosExecutados->addChild('ans:quantidadeExecutada', $item->quantidade);
                    $servicosExecutados->addChild('ans:unidadeMedida', $item->unidade_medida);
                    $servicosExecutados->addChild('ans:reducaoAcrescimo', '1.00');
                    $servicosExecutados->addChild('ans:valorUnitario', $item->valor_unitario_produto);
                    $servicosExecutados->addChild('ans:valorTotal', $item->quantidade * $item->valor_unitario_produto);
                    $servicosExecutados->addChild('ans:descricaoProcedimento', $item->nome_produto);
                }
            }
        }
        // Adicionar valores totais conforme o padrão TISS
        $valorTotal = $guiaSadt->addChild('ans:valorTotal');
        $valorTotal->addChild('ans:valorProcedimentos', number_format($valorProcedimentos, 2, '.', ''));
        $valorTotal->addChild('ans:valorMateriais', number_format($valorMateriais, 2, '.', ''));
        $valorTotal->addChild('ans:valorMedicamentos', number_format($valorMedicamentos, 2, '.', ''));
        $valorTotal->addChild('ans:valorOPME', number_format($valorOPME, 2, '.', ''));
        $valorTotal->addChild('ans:valorTotalGeral', number_format($valorTotalGeral, 2, '.', ''));

        $epilogo = $xml->addChild('ans:epilogo');
        $hash = md5($xml->asXML());
        $epilogo->addChild('ans:hash', $hash);

        $guia->identificador = 'GERADO';
        $guia->save();

        $fileName = 'lote_guias_sadt.xml';
        $filePath = storage_path('app/public/' . $fileName);

        if (!$xml->asXML($filePath)) {
            return response()->json(['error' => 'Erro ao salvar o arquivo XML.'], 500);
        }

        $zipFileName = 'lote_guias_sadt.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        $zip = new \ZipArchive;
        if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
            $zip->addFile($filePath, $fileName);
            $zip->close();
        } else {
            return response()->json(['error' => 'Erro ao criar o arquivo ZIP.'], 500);
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function gerarXmlGuiasadt($id, Request $request)
    {
        // Verificar se a guia existe
        $guia = GuiaSp::with('profissional')->findOrFail($id);

        $exameSadtAut = ExamesAutSadt::whereIn('guia_sps_id', $id)->get();
        // Verificar se a numeração é fornecida na requisição ou já existe na guia
        if ($request->has('numeracao')) {
            $guia->numeracao = $request->input('numeracao');
        } elseif (is_null($guia->numeracao)) {
            // Verificar se existe alguma numeração em outra guia
            $ultimaNumeracao = GuiaSp::whereNotNull('numeracao')->max('numeracao');

            if ($ultimaNumeracao) {
                // Incrementa a numeração automaticamente se existe uma anterior
                $guia->numeracao = $ultimaNumeracao + 1;
            } else {
                // Retorna erro se não há nenhuma numeração existente
                return response()->json([
                    'error' => 'Numeração não encontrada. Por favor, insira a numeração para esta guia.'
                ], 422);
            }
        }

        // Salvar a numeração na guia
        $guia->save();

        // Puxar os procedimentos das tabelas relacionadas
        $procedimentos = DB::table('exames_aut_sadt')
            ->where('guia_sps_id', $id)
            ->get();

        // Recuperar materiais relacionados à agenda_id da guia
        $materiais = collect();
        if ($guia->paciente->convenio) {
            $tabelaMateriais = $guia->paciente->convenio->tab_mat_id;

            if ($tabelaMateriais && Schema::hasTable($tabelaMateriais)) {
                $materiais = DB::table('mat_agendas')
                    ->join($tabelaMateriais, 'mat_agendas.material_id', '=', "{$tabelaMateriais}.id")
                    ->where('mat_agendas.agenda_id', $guia->agenda_id)
                    ->select(
                        'mat_agendas.id as id',
                        'mat_agendas.quantidade as quantidade',
                        'mat_agendas.unidade_medida',
                        "{$tabelaMateriais}.medicamento as nome_produto",
                        "{$tabelaMateriais}.medicamento as descricao_produto",
                        DB::raw("'MEDICAMENTO' as tipo_produto"),
                        "{$tabelaMateriais}.preco as valor_unitario_produto",
                        "{$tabelaMateriais}.id as material_id"
                    )
                    ->get();
            }
        }


        // Verificar se o convênio tem uma tabela de medicamentos dinâmica
        $medicamentos = collect(); // Inicializando como vazio caso não seja encontrado
        if ($guia->paciente->convenio) {
            $tabelaMedicamentos = $guia->paciente->convenio->tab_med_id;

            if ($tabelaMedicamentos && Schema::hasTable($tabelaMedicamentos)) {
                $medicamentos = DB::table('med_agendas')
                    ->join($tabelaMedicamentos, 'med_agendas.medicamento_id', '=', "{$tabelaMedicamentos}.id")
                    ->where('med_agendas.agenda_id', $guia->agenda_id)
                    ->select(
                        'med_agendas.id as id',
                        'med_agendas.quantidade as quantidade',
                        'med_agendas.unidade_medida',
                        "{$tabelaMedicamentos}.medicamento as nome_produto",
                        "{$tabelaMedicamentos}.medicamento as descricao_produto",
                        DB::raw("'MEDICAMENTO' as tipo_produto"),
                        "{$tabelaMedicamentos}.preco as valor_unitario_produto",
                        "{$tabelaMedicamentos}.id as material_id"
                    )
                    ->get();
            }
        }

        // Combinar os resultados de materiais e medicamentos
        $outrasDespesasItems = $materiais->concat($medicamentos); // Usando concat para mesclar coleções

        // Calcular valores totais
        $valorProcedimentos = $procedimentos->sum('valor_total');
        $valorMateriais = $materiais->sum(fn($item) => $item->quantidade * $item->valor_unitario_produto);
        $valorMedicamentos = $medicamentos->sum(fn($item) => $item->quantidade * $item->valor_unitario_produto);
        $valorOPME = 0.00; // Adicionar lógica para OPME se necessário
        $valorTotalGeral = $valorProcedimentos + $valorMateriais + $valorMedicamentos + $valorOPME;

        // Criar o XML utilizando SimpleXMLElement
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><ans:mensagemTISS xmlns:ans="http://www.ans.gov.br/padroes/tiss/schemas" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.ans.gov.br/padroes/tiss/schemas http://www.ans.gov.br/padroes/tiss/schemas/tissV4_01_00.xsd"></ans:mensagemTISS>');

        // Cabeçalho
        $cabecalho = $xml->addChild('ans:cabecalho');
        $identificacaoTransacao = $cabecalho->addChild('ans:identificacaoTransacao');
        $identificacaoTransacao->addChild('ans:tipoTransacao', 'ENVIO_LOTE_GUIAS');
        $identificacaoTransacao->addChild('ans:sequencialTransacao', $guia->numeracao);
        $identificacaoTransacao->addChild('ans:dataRegistroTransacao', date('Y-m-d'));
        $identificacaoTransacao->addChild('ans:horaRegistroTransacao', date('H:i:s'));

        $origem = $cabecalho->addChild('ans:origem');
        $identificacaoPrestador = $origem->addChild('ans:identificacaoPrestador');
        $identificacaoPrestador->addChild('ans:CNPJ', $guia->codigo_operadora ?? '');

        $destino = $cabecalho->addChild('ans:destino');
        $destino->addChild('ans:registroANS', $guia->registro_ans);

        $cabecalho->addChild('ans:Padrao', '4.01.00');

        // Lote de Guias
        $prestadorParaOperadora = $xml->addChild('ans:prestadorParaOperadora');
        $loteGuias = $prestadorParaOperadora->addChild('ans:loteGuias');
        $loteGuias->addChild('ans:numeroLote', $guia->numeracao);
        $guiasTISS = $loteGuias->addChild('ans:guiasTISS');

        // Guia SP-SADT
        $guiaSadt = $guiasTISS->addChild('ans:guiaSP-SADT');

        // Cabeçalho da Guia
        $cabecalhoGuia = $guiaSadt->addChild('ans:cabecalhoGuia');
        $cabecalhoGuia->addChild('ans:registroANS', $guia->registro_ans);
        $cabecalhoGuia->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_op);

        // Dados de Autorização
        $dadosAutorizacao = $guiaSadt->addChild('ans:dadosAutorizacao');
        $dadosAutorizacao->addChild('ans:numeroGuiaOperadora', $guia->numero_guia_op);
        $dadosAutorizacao->addChild('ans:dataAutorizacao', $guia->data_autorizacao);
        $dadosAutorizacao->addChild('ans:senha', $guia->senha);
        $dadosAutorizacao->addChild('ans:dataValidadeSenha', $guia->validade_senha);

        // Dados do Beneficiário
        $dadosBeneficiario = $guiaSadt->addChild('ans:dadosBeneficiario');
        $dadosBeneficiario->addChild('ans:numeroCarteira', $guia->numero_carteira);
        $dadosBeneficiario->addChild('ans:atendimentoRN', $guia->atendimento_rn);

        // Dados do Solicitante
        $dadosSolicitante = $guiaSadt->addChild('ans:dadosSolicitante');
        $contratadoSolicitante = $dadosSolicitante->addChild('ans:contratadoSolicitante');
        $contratadoSolicitante->addChild('ans:cnpjContratado', $guia->codigo_operadora ?? '');
        $dadosSolicitante->addChild('ans:nomeContratadoSolicitante', $guia->nome_contratado_executante);
        $profissionalSolicitante = $dadosSolicitante->addChild('ans:profissionalSolicitante');
        $profissionalSolicitante->addChild('ans:nomeProfissional', $guia->nome_profissional_solicitante);
        $profissionalSolicitante->addChild('ans:conselhoProfissional', $guia->conselho_profissional);
        $profissionalSolicitante->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho);
        $profissionalSolicitante->addChild('ans:UF', $guia->uf_conselho);
        $profissionalSolicitante->addChild('ans:CBOS', $guia->codigo_cbo);

        // Dados Solicitação
        $dadosSolicitacao = $guiaSadt->addChild('ans:dadosSolicitacao');
        $dadosSolicitacao->addChild('ans:dataSolicitacao', $guia->data_autorizacao);
        $dadosSolicitacao->addChild('ans:caraterAtendimento', $guia->carater_atendimento);
        $dadosSolicitacao->addChild('ans:indicacaoClinica', $guia->indicacao_clinica);

        // Dados do Executante
        $dadosExecutante = $guiaSadt->addChild('ans:dadosExecutante');
        $contratadoExecutante = $dadosExecutante->addChild('ans:contratadoExecutante');
        $contratadoExecutante->addChild('ans:cpfContratado', $guia->profissional->cpf ?? '');
        $dadosExecutante->addChild('ans:CNES', $guia->codigo_cnes);

        // Dados do Atendimento
        $dadosAtendimento = $guiaSadt->addChild('ans:dadosAtendimento');
        $dadosAtendimento->addChild('ans:tipoAtendimento', $guia->tipo_atendimento);
        $dadosAtendimento->addChild('ans:indicacaoAcidente', $guia->indicacao_acidente);
        $dadosAtendimento->addChild('ans:tipoConsulta', $guia->tipo_consulta);
        $dadosAtendimento->addChild('ans:regimeAtendimento', $guia->regime_atendimento ?? '01');

        // Procedimentos Executados
        $procedimentosExecutados = $guiaSadt->addChild('ans:procedimentosExecutados');
        foreach ($procedimentos as $index => $procedimento) {
            $procedimentoExecutado = $procedimentosExecutados->addChild('ans:procedimentoExecutado');
            $procedimentoExecutado->addChild('ans:sequencialItem', $index + 1);
            $procedimentoExecutado->addChild('ans:dataExecucao', $procedimento->data_real ?? $guia->data_autorizacao);
            $procedimentoExecutado->addChild('ans:horaInicial', $procedimento->hora_inicio_atendimento ?? $guia->hora_inicio_atendimento);
            $procedimentoExecutado->addChild('ans:horaFinal', $procedimento->hora_fim_atendimento ?? $guia->hora_fim_atendimento);

            $dadosProcedimento = $procedimentoExecutado->addChild('ans:procedimento');
            $dadosProcedimento->addChild('ans:codigoTabela', $procedimento->tabela);
            $dadosProcedimento->addChild('ans:codigoProcedimento', $procedimento->codigo_procedimento_realizado);
            $dadosProcedimento->addChild('ans:descricaoProcedimento', $procedimento->descricao_procedimento_realizado);
            $procedimentoExecutado->addChild('ans:quantidadeExecutada', $procedimento->quantidade_autorizada);
            if (!empty($procedimento->via)) {
                $procedimentoExecutado->addChild('ans:viaAcesso', $procedimento->via);
            }
            $procedimentoExecutado->addChild('ans:reducaoAcrescimo', '1.00');
            $procedimentoExecutado->addChild('ans:valorUnitario', $procedimento->valor_unitario);
            $procedimentoExecutado->addChild('ans:valorTotal', $procedimento->valor_total);

            // Adicionando a equipe da guia diretamente da $guia
            $equipeSadt = $procedimentoExecutado->addChild('ans:equipeSadt');
            // Profissional 1 (sempre presente)
            if (!empty($guia->grua) && !empty($guia->codigo_operadora_profissional)) {
                $codProfissional = $equipeSadt->addChild('ans:grauPart', $guia->grua);
                $codProfissional = $equipeSadt->addChild('ans:codProfissional');
                $codProfissional->addChild('ans:cpfContratado', $guia->codigo_operadora_profissional);

                $equipeSadt->addChild('ans:nomeProf', $guia->nome_profissional);
                $equipeSadt->addChild('ans:conselho', $guia->sigla_conselho);
                $equipeSadt->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho_profissional);
                $equipeSadt->addChild('ans:UF', $guia->uf_profissional);
                $equipeSadt->addChild('ans:CBOS', $guia->codigo_cbo_profissional);
            }

            // Profissional 2 (só adiciona se houver dados)
            if (!empty($guia->grau1) && !empty($guia->codigo_operadora_profissional1)) {
                $codProfissional = $equipeSadt->addChild('ans:grauPart', $guia->grau1);
                $codProfissional = $equipeSadt->addChild('ans:codProfissional');
                $codProfissional->addChild('ans:cpfContratado', $guia->codigo_operadora_profissional1);

                $equipeSadt->addChild('ans:nomeProf', $guia->nome_profissional1);
                $equipeSadt->addChild('ans:conselho', $guia->sigla_conselho1);
                $equipeSadt->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho_profissional1);
                $equipeSadt->addChild('ans:UF', $guia->uf_profissional1);
                $equipeSadt->addChild('ans:CBOS', $guia->codigo_cbo_profissional1);
            }

            // Profissional 3 (só adiciona se houver dados)
            if (!empty($guia->grau2) && !empty($guia->codigo_operadora_profissional2)) {
                $codProfissional = $equipeSadt->addChild('ans:grauPart', $guia->grau2);
                $codProfissional = $equipeSadt->addChild('ans:codProfissional');
                $codProfissional->addChild('ans:cpfContratado', $guia->codigo_operadora_profissional2);

                $equipeSadt->addChild('ans:nomeProf', $guia->nome_profissional2);
                $equipeSadt->addChild('ans:conselho', $guia->sigla_conselho2);
                $equipeSadt->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho_profissional2);
                $equipeSadt->addChild('ans:UF', $guia->uf_profissional2);
                $equipeSadt->addChild('ans:CBOS', $guia->codigo_cbo_profissional2);
            }
        }
        if (is_array($outrasDespesasItems) && count($outrasDespesasItems) > 0) {
            $outrasDespesas = $guiaSadt->addChild('ans:outrasDespesas');
            foreach ($outrasDespesasItems as $index => $item) {
                $despesa = $outrasDespesas->addChild('ans:despesa');
                $despesa->addChild('ans:sequencialItem', $index + 1);
                $despesa->addChild('ans:codigoDespesa');

                $servicosExecutados = $despesa->addChild('ans:servicosExecutados');
                $servicosExecutados->addChild('ans:dataExecucao', $guia->data_autorizacao);
                $servicosExecutados->addChild('ans:horaInicial', $guia->hora_inicio_atendimento);
                $servicosExecutados->addChild('ans:horaFinal', $guia->hora_fim_atendimento);

                $codigoTabela = strtoupper(trim($item->tipo_produto)) === 'MEDICAMENTO' ? '20' : '19';
                $servicosExecutados->addChild('ans:codigoTabela', $codigoTabela);

                $servicosExecutados->addChild('ans:codigoProcedimento', $item->material_id);
                $servicosExecutados->addChild('ans:quantidadeExecutada', $item->quantidade);
                $servicosExecutados->addChild('ans:unidadeMedida', $item->unidade_medida);
                $servicosExecutados->addChild('ans:reducaoAcrescimo', '1.00');
                $servicosExecutados->addChild('ans:valorUnitario', $item->valor_unitario_produto);
                $servicosExecutados->addChild('ans:valorTotal', $item->quantidade * $item->valor_unitario_produto);
                $servicosExecutados->addChild('ans:descricaoProcedimento', $item->nome_produto);
            }
        }

        // Adicionar valores totais conforme o padrão TISS
        $valorTotal = $guiaSadt->addChild('ans:valorTotal');
        $valorTotal->addChild('ans:valorProcedimentos', number_format($valorProcedimentos, 2, '.', ''));
        $valorTotal->addChild('ans:valorMateriais', number_format($valorMateriais, 2, '.', ''));
        $valorTotal->addChild('ans:valorMedicamentos', number_format($valorMedicamentos, 2, '.', ''));
        $valorTotal->addChild('ans:valorOPME', number_format($valorOPME, 2, '.', ''));
        $valorTotal->addChild('ans:valorTotalGeral', number_format($valorTotalGeral, 2, '.', ''));

        // Epílogo
        $epilogo = $xml->addChild('ans:epilogo');
        $epilogo->addChild('ans:hash', md5($xml->asXML()));

        $guia->identificador = 'GERADO';
        $guia->save();

        // Verifica se já existe uma conta financeira para esse lote
        $contaExistente = ContaGuia::where('lote', $guia->numeracao)->first();

        if (!$contaExistente) {
            // Atualiza as guias com a numeração correta
            foreach ($guia as $g) {
                $g->identificador = 'GERADO';
                $g->save();
            }

            // Calcula o valor total do lote
            $valorTotal = $exameSadtAut->sum('valor_total');

            $referencia = $guia->numeracao;

            // Cria a conta financeira
            $conta = ContasFinanceiras::create([
                'user_id' => auth()->id(),
                'status' => 'Aberto',
                'tipo_conta' => 'Receber',
                'convenio_id' => $guia->first()->convenio_id,
                'tipo_guia' => 'SADT',
                'parcelas' => '1/1',
                'data_emissao' => Carbon::parse($guia->data_autorizacao)->format('Y-m-d'),
                'competencia' => Carbon::parse($guia->data_autorizacao)->format('Y-m-d'),
                'data_vencimento' => now()->addDays(30)->format('Y-m-d'),
                'referencia' => $referencia,
                'tipo_doc' => 'XML',
                'centro_custos' => $guia->first()->nome_contratado ?? 'Desconhecido',
                'documento' => 'lote_guias_sadt_' . $guia->numeracao . '.xml',
                'valor' => $valorTotal,
                'historico' => 'Guia SADT - ' . $guia->data_autorizacao,
            ]);
            Log::info("message");
            // Salva o relacionamento na tabela `conta_guias`
            foreach ($guia as $g) {
                ContaGuia::create([
                    'conta_financeira_id' => $conta->id,
                    'guia_id' => $g->id,
                    'tipo_guia' => 'SADT',
                    'lote' => $guia->numeracao,
                ]);
            }
        } else {
            // Apenas atualiza as guias e registra o relacionamento se não existirem
            foreach ($guia as $g) {
                $existeRelacionamento = ContaGuia::where('guia_id', $g->id)
                    ->where('tipo_guia', 'SADT')
                    ->exists();

                if (!$existeRelacionamento) {
                    $g->numeracao = $guia->numeracao;
                    $g->identificador = 'GERADO';
                    $g->save();

                    ContaGuia::create([
                        'conta_financeira_id' => $contaExistente->conta_financeira_id,
                        'guia_id' => $g->id,
                        'tipo_guia' => 'SADT',
                        'lote' => $g->numeracao,
                    ]);
                }
            }
        }


        // Retornar o XML como download
        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="guia_sp_sadt_' . $guia->id . '.xml"');
    }

    public function gerarZipGuiasadt($id, Request $request)
    {

        // Buscar a guia com todos os relacionamentos necessários
        $guia = GuiaSp::with('profissional')->findOrFail($id);

        // Verificar ou gerar a numeração da guia
        if (!$guia->numeracao) {
            $ultimaNumeracao = GuiaSp::whereNotNull('numeracao')->max('numeracao') ?? 0;
            $guia->numeracao = $ultimaNumeracao + 1;
            $guia->save();
        }

        // Puxar os procedimentos das tabelas relacionadas
        $procedimentos = DB::table('exames_aut_sadt')
            ->where('guia_sps_id', $id)
            ->get();

        $materiais = collect();
        if ($guia->paciente->convenio) {
            $tabelaMateriais = $guia->paciente->convenio->tab_mat_id;

            if ($tabelaMateriais && Schema::hasTable($tabelaMateriais)) {
                $materiais = DB::table('mat_agendas')
                    ->join($tabelaMateriais, 'mat_agendas.material_id', '=', "{$tabelaMateriais}.id")
                    ->where('mat_agendas.agenda_id', $guia->agenda_id)
                    ->select(
                        'mat_agendas.id as id',
                        'mat_agendas.quantidade as quantidade',
                        'mat_agendas.unidade_medida',
                        "{$tabelaMateriais}.medicamento as nome_produto",
                        "{$tabelaMateriais}.medicamento as descricao_produto",
                        DB::raw("'MEDICAMENTO' as tipo_produto"),
                        "{$tabelaMateriais}.preco as valor_unitario_produto",
                        "{$tabelaMateriais}.id as material_id"
                    )
                    ->get();
            }
        }

        // Verificar se o convênio tem medicamentos dinâmicos
        $medicamentos = collect();
        if ($guia->paciente->convenio) {
            $tabelaMedicamentos = $guia->paciente->convenio->tab_med_id;

            if ($tabelaMedicamentos && Schema::hasTable($tabelaMedicamentos)) {
                $medicamentos = DB::table('med_agendas')
                    ->join($tabelaMedicamentos, 'med_agendas.medicamento_id', '=', "{$tabelaMedicamentos}.id")
                    ->where('med_agendas.agenda_id', $guia->agenda_id)
                    ->select(
                        'med_agendas.id as id',
                        'med_agendas.quantidade as quantidade',
                        'med_agendas.unidade_medida',
                        "{$tabelaMedicamentos}.medicamento as nome_produto",
                        "{$tabelaMedicamentos}.medicamento as descricao_produto",
                        DB::raw("'MEDICAMENTO' as tipo_produto"),
                        "{$tabelaMedicamentos}.preco as valor_unitario_produto",
                        "{$tabelaMedicamentos}.id as material_id"
                    )
                    ->get();
            }
        }

        // Combinar materiais e medicamentos
        $outrasDespesasItems = $materiais->concat($medicamentos);

        // Calcular valores totais
        $valorProcedimentos = $procedimentos->sum('valor_total');
        $valorMateriais = $materiais->sum(fn($item) => $item->quantidade * $item->valor_unitario_produto);
        $valorMedicamentos = $medicamentos->sum(fn($item) => $item->quantidade * $item->valor_unitario_produto);
        $valorOPME = 0.00; // Adicionar lógica para OPME se necessário
        $valorTotalGeral = $valorProcedimentos + $valorMateriais + $valorMedicamentos + $valorOPME;


        // Criar o XML utilizando SimpleXMLElement
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><ans:mensagemTISS xmlns:ans="http://www.ans.gov.br/padroes/tiss/schemas" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.ans.gov.br/padroes/tiss/schemas http://www.ans.gov.br/padroes/tiss/schemas/tissV4_01_00.xsd"></ans:mensagemTISS>');

        // Cabeçalho
        $cabecalho = $xml->addChild('ans:cabecalho');
        $identificacaoTransacao = $cabecalho->addChild('ans:identificacaoTransacao');
        $identificacaoTransacao->addChild('ans:tipoTransacao', 'ENVIO_LOTE_GUIAS');
        $identificacaoTransacao->addChild('ans:sequencialTransacao', $guia->numeracao);
        $identificacaoTransacao->addChild('ans:dataRegistroTransacao', date('Y-m-d'));
        $identificacaoTransacao->addChild('ans:horaRegistroTransacao', date('H:i:s'));

        $origem = $cabecalho->addChild('ans:origem');
        $identificacaoPrestador = $origem->addChild('ans:identificacaoPrestador');
        $identificacaoPrestador->addChild('ans:CNPJ', $guia->codigo_operadora ?? '');

        $destino = $cabecalho->addChild('ans:destino');
        $destino->addChild('ans:registroANS', $guia->registro_ans);

        $cabecalho->addChild('ans:Padrao', '4.01.00');

        // Lote de Guias
        $prestadorParaOperadora = $xml->addChild('ans:prestadorParaOperadora');
        $loteGuias = $prestadorParaOperadora->addChild('ans:loteGuias');
        $loteGuias->addChild('ans:numeroLote', $guia->numeracao);
        $guiasTISS = $loteGuias->addChild('ans:guiasTISS');

        // Guia SP-SADT
        $guiaSadt = $guiasTISS->addChild('ans:guiaSP-SADT');

        // Cabeçalho da Guia
        $cabecalhoGuia = $guiaSadt->addChild('ans:cabecalhoGuia');
        $cabecalhoGuia->addChild('ans:registroANS', $guia->registro_ans);
        $cabecalhoGuia->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_op);

        // Dados de Autorização
        $dadosAutorizacao = $guiaSadt->addChild('ans:dadosAutorizacao');
        $dadosAutorizacao->addChild('ans:numeroGuiaOperadora', $guia->numero_guia_op);
        $dadosAutorizacao->addChild('ans:dataAutorizacao', $guia->data_autorizacao);
        $dadosAutorizacao->addChild('ans:senha', $guia->senha);
        $dadosAutorizacao->addChild('ans:dataValidadeSenha', $guia->validade_senha);

        // Dados do Beneficiário
        $dadosBeneficiario = $guiaSadt->addChild('ans:dadosBeneficiario');
        $dadosBeneficiario->addChild('ans:numeroCarteira', $guia->numero_carteira);
        $dadosBeneficiario->addChild('ans:atendimentoRN', $guia->atendimento_rn);

        // Dados do Solicitante
        $dadosSolicitante = $guiaSadt->addChild('ans:dadosSolicitante');
        $contratadoSolicitante = $dadosSolicitante->addChild('ans:contratadoSolicitante');
        $contratadoSolicitante->addChild('ans:cnpjContratado', $guia->codigo_operadora ?? '');
        $dadosSolicitante->addChild('ans:nomeContratadoSolicitante', $guia->nome_contratado_executante);
        $profissionalSolicitante = $dadosSolicitante->addChild('ans:profissionalSolicitante');
        $profissionalSolicitante->addChild('ans:nomeProfissional', $guia->nome_profissional_solicitante);
        $profissionalSolicitante->addChild('ans:conselhoProfissional', $guia->conselho_profissional);
        $profissionalSolicitante->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho);
        $profissionalSolicitante->addChild('ans:UF', $guia->uf_conselho);
        $profissionalSolicitante->addChild('ans:CBOS', $guia->codigo_cbo);

        // Dados Solicitação
        $dadosSolicitacao = $guiaSadt->addChild('ans:dadosSolicitacao');
        $dadosSolicitacao->addChild('ans:dataSolicitacao', $guia->data_autorizacao);
        $dadosSolicitacao->addChild('ans:caraterAtendimento', $guia->carater_atendimento);
        $dadosSolicitacao->addChild('ans:indicacaoClinica', $guia->indicacao_clinica);

        // Dados do Executante
        $dadosExecutante = $guiaSadt->addChild('ans:dadosExecutante');
        $contratadoExecutante = $dadosExecutante->addChild('ans:contratadoExecutante');
        $contratadoExecutante->addChild('ans:cpfContratado', $guia->profissional->cpf ?? '');
        $dadosExecutante->addChild('ans:CNES', $guia->codigo_cnes);

        // Dados do Atendimento
        $dadosAtendimento = $guiaSadt->addChild('ans:dadosAtendimento');
        $dadosAtendimento->addChild('ans:tipoAtendimento', $guia->tipo_atendimento);
        $dadosAtendimento->addChild('ans:indicacaoAcidente', $guia->indicacao_acidente);
        $dadosAtendimento->addChild('ans:tipoConsulta', $guia->tipo_consulta);
        $dadosAtendimento->addChild('ans:regimeAtendimento', $guia->regime_atendimento ?? '01');

        // Procedimentos Executados
        $procedimentosExecutados = $guiaSadt->addChild('ans:procedimentosExecutados');
        foreach ($procedimentos as $index => $procedimento) {
            $procedimentoExecutado = $procedimentosExecutados->addChild('ans:procedimentoExecutado');
            $procedimentoExecutado->addChild('ans:sequencialItem', $index + 1);
            $procedimentoExecutado->addChild('ans:dataExecucao', $procedimento->data_real ?? $guia->data_autorizacao);
            $procedimentoExecutado->addChild('ans:horaInicial', $procedimento->hora_inicio_atendimento ?? $guia->hora_inicio_atendimento);
            $procedimentoExecutado->addChild('ans:horaFinal', $procedimento->hora_fim_atendimento ?? $guia->hora_fim_atendimento);

            $dadosProcedimento = $procedimentoExecutado->addChild('ans:procedimento');
            $dadosProcedimento->addChild('ans:codigoTabela', $procedimento->tabela);
            $dadosProcedimento->addChild('ans:codigoProcedimento', $procedimento->codigo_procedimento_realizado);
            $dadosProcedimento->addChild('ans:descricaoProcedimento', $procedimento->descricao_procedimento_realizado);
            $procedimentoExecutado->addChild('ans:quantidadeExecutada', $procedimento->quantidade_autorizada);
            if (!empty($procedimento->via)) {
                $procedimentoExecutado->addChild('ans:viaAcesso', $procedimento->via);
            }
            $procedimentoExecutado->addChild('ans:reducaoAcrescimo', '1.00');
            $procedimentoExecutado->addChild('ans:valorUnitario', $procedimento->valor_unitario);
            $procedimentoExecutado->addChild('ans:valorTotal', $procedimento->valor_total);

            // Adicionando a equipe da guia diretamente da $guia
            $equipeSadt = $procedimentoExecutado->addChild('ans:equipeSadt');
            // Profissional 1 (sempre presente)
            if (!empty($guia->grua) && !empty($guia->codigo_operadora_profissional)) {
                $codProfissional = $equipeSadt->addChild('ans:grauPart', $guia->grua);
                $codProfissional = $equipeSadt->addChild('ans:codProfissional');
                $codProfissional->addChild('ans:cpfContratado', $guia->codigo_operadora_profissional);

                $equipeSadt->addChild('ans:nomeProf', $guia->nome_profissional);
                $equipeSadt->addChild('ans:conselho', $guia->sigla_conselho);
                $equipeSadt->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho_profissional);
                $equipeSadt->addChild('ans:UF', $guia->uf_profissional);
                $equipeSadt->addChild('ans:CBOS', $guia->codigo_cbo_profissional);
            }

            // Profissional 2 (só adiciona se houver dados)
            if (!empty($guia->grau1) && !empty($guia->codigo_operadora_profissional1)) {
                $codProfissional = $equipeSadt->addChild('ans:grauPart', $guia->grau1);
                $codProfissional = $equipeSadt->addChild('ans:codProfissional');
                $codProfissional->addChild('ans:cpfContratado', $guia->codigo_operadora_profissional1);

                $equipeSadt->addChild('ans:nomeProf', $guia->nome_profissional1);
                $equipeSadt->addChild('ans:conselho', $guia->sigla_conselho1);
                $equipeSadt->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho_profissional1);
                $equipeSadt->addChild('ans:UF', $guia->uf_profissional1);
                $equipeSadt->addChild('ans:CBOS', $guia->codigo_cbo_profissional1);
            }

            // Profissional 3 (só adiciona se houver dados)
            if (!empty($guia->grau2) && !empty($guia->codigo_operadora_profissional2)) {
                $codProfissional = $equipeSadt->addChild('ans:grauPart', $guia->grau2);
                $codProfissional = $equipeSadt->addChild('ans:codProfissional');
                $codProfissional->addChild('ans:cpfContratado', $guia->codigo_operadora_profissional2);

                $equipeSadt->addChild('ans:nomeProf', $guia->nome_profissional2);
                $equipeSadt->addChild('ans:conselho', $guia->sigla_conselho2);
                $equipeSadt->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho_profissional2);
                $equipeSadt->addChild('ans:UF', $guia->uf_profissional2);
                $equipeSadt->addChild('ans:CBOS', $guia->codigo_cbo_profissional2);
            }
        }
        // Outras Despesas
        if (is_array($outrasDespesasItems) && count($outrasDespesasItems) > 0) {
            $outrasDespesas = $guiaSadt->addChild('ans:outrasDespesas');
            foreach ($outrasDespesasItems as $index => $item) {
                $despesa = $outrasDespesas->addChild('ans:despesa');
                $despesa->addChild('ans:sequencialItem', $index + 1);
                $despesa->addChild('ans:codigoDespesa');

                $servicosExecutados = $despesa->addChild('ans:servicosExecutados');
                $servicosExecutados->addChild('ans:dataExecucao', $guia->data_autorizacao);
                $servicosExecutados->addChild('ans:horaInicial', $guia->hora_inicio_atendimento);
                $servicosExecutados->addChild('ans:horaFinal', $guia->hora_fim_atendimento);

                $codigoTabela = strtoupper(trim($item->tipo_produto)) === 'MEDICAMENTO' ? '20' : '19';
                $servicosExecutados->addChild('ans:codigoTabela', $codigoTabela);

                $servicosExecutados->addChild('ans:codigoProcedimento', $item->material_id);
                $servicosExecutados->addChild('ans:quantidadeExecutada', $item->quantidade);
                $servicosExecutados->addChild('ans:unidadeMedida', $item->unidade_medida);
                $servicosExecutados->addChild('ans:reducaoAcrescimo', '1.00');
                $servicosExecutados->addChild('ans:valorUnitario', $item->valor_unitario_produto);
                $servicosExecutados->addChild('ans:valorTotal', $item->quantidade * $item->valor_unitario_produto);
                $servicosExecutados->addChild('ans:descricaoProcedimento', $item->nome_produto);
            }
        }

        // Adicionar valores totais conforme o padrão TISS
        $valorTotal = $guiaSadt->addChild('ans:valorTotal');
        $valorTotal->addChild('ans:valorProcedimentos', number_format($valorProcedimentos, 2, '.', ''));
        $valorTotal->addChild('ans:valorMateriais', number_format($valorMateriais, 2, '.', ''));
        $valorTotal->addChild('ans:valorMedicamentos', number_format($valorMedicamentos, 2, '.', ''));
        $valorTotal->addChild('ans:valorOPME', number_format($valorOPME, 2, '.', ''));
        $valorTotal->addChild('ans:valorTotalGeral', number_format($valorTotalGeral, 2, '.', ''));


        // Epílogo
        $epilogo = $xml->addChild('ans:epilogo');
        $epilogo->addChild('ans:hash', md5($xml->asXML()));

        $guia->identificador = 'GERADO';
        $guia->save();

        // Salvar o XML em um arquivo
        $fileName = 'guia_sadt_' . $guia->id . '.xml';
        $filePath = storage_path('app/public/' . $fileName);
        $xml->asXML($filePath);

        // Criar o arquivo ZIP
        $zipFileName = 'guia_sadt_' . $guia->id . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        $zip = new \ZipArchive;
        if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
            $zip->addFile($filePath, $fileName);
            $zip->close();
        }

        // Retornar o arquivo ZIP como download
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }


    public function verificarNumeracao(Request $request)
    {
        $guiaIds = $request->input('guia_ids');

        // Busca a primeira guia com numeração entre as IDs fornecidas
        $guiaComNumeracao = GuiaSp::whereIn('id', $guiaIds)
            ->whereNotNull('numeracao')
            ->first();

        if ($guiaComNumeracao) {
            // Retorna a numeração encontrada
            return response()->json(['numeracao' => $guiaComNumeracao->numeracao]);
        } else {
            // Indica ao frontend que deve solicitar uma numeração
            return response()->json(['numeracao' => null]);
        }
    }

    // GuiaSpController.php
    public function gerarGuiaSadt($id)
    {
        // Buscar a agenda pelo ID
        $agenda = Agenda::findOrFail($id);

        // Buscar a guia SADT relacionada
        $guia = GuiaSp::where('agenda_id', $agenda->id)->first();
        // $user = User::where('id', $guia->user_id)->get();
        $ExameSolis = ExamesSadt::where('guia_sps_id', $guia->id)
            ->whereNotNull('codigo_procedimento_solicitado')
            ->get();

        $ExameAuts = ExamesAutSadt::where('guia_sps_id', $guia->id)->get();

        $tabelaMed = $agenda->convenio->tab_med_id; // Nome da tabela de medicamentos do convênio

        if (Schema::hasTable($tabelaMed)) { // Verifica se a tabela existe no banco
            $medicamentos = MedAgenda::where('agenda_id', $agenda->id)
                ->join($tabelaMed, "$tabelaMed.id", '=', 'med_agendas.medicamento_id') // Realiza o INNER JOIN
                ->select('med_agendas.*', "$tabelaMed.medicamento as nome_medicamento") // Seleciona as colunas desejadas
                ->get();
        } else {
            $medicamentos = MedAgenda::where('agenda_id', $agenda->id)
                ->join('medicamentos', 'medicamentos.id', '=', 'med_agendas.medicamento_id')
                ->select('med_agendas.*', 'medicamentos.nome as nome_medicamento') // Seleciona as colunas desejadas
                ->get();// Retorna uma coleção vazia se a tabela não existir
        }

        $tabelaMat = $agenda->convenio->tab_mat_id; // Nome da tabela de medicamentos do convênio

        if (Schema::hasTable($tabelaMat)) { // Verifica se a tabela existe no banco
            $materiais = MatAgenda::where('agenda_id', $agenda->id)
                ->join($tabelaMat, "$tabelaMat.id", '=', 'mat_agendas.material_id') // Realiza o INNER JOIN
                ->select('mat_agendas.*', "$tabelaMat.medicamento as nome_material") // Seleciona as colunas desejadas
                ->get();
        } else {
            $materiais = MatAgenda::where('agenda_id', $agenda->id) 
            ->join('produtos', 'produtos.id', '=', 'mat_agendas.material_id') // Realiza o INNER JOIN
            ->select('mat_agendas.*', 'produtos.nome as nome_material') // Seleciona as colunas desejadas
            ->get();
        }
        // Buscar a empresa associada
        $empresa = Empresas::first();

        // Retornar a view de impressão da Guia SADT
        return view('formulario.guiasp', [
            'agenda' => $agenda,
            'guia' => $guia,
            'empresa' => $empresa,
            'ExameSolis' => $ExameSolis,
            'ExameAuts' => $ExameAuts,
            'medicamentos' => $medicamentos,
            'materiais' => $materiais,
            // 'user' => $user,
        ]);
    }

    public function salvarGuiaSADT(Request $request)
    {
        Log::info('Dados recebidos no request:', $request->all());
        try {
            DB::beginTransaction();

            $horaInicioAtendimento = $request->input('hora_inicio_atendimento');
            $horaFimAtendimento = $request->input('hora_fim_atendimento');

            if (is_array($horaInicioAtendimento)) {
                $horaInicioAtendimento = reset($horaInicioAtendimento); // Pega o primeiro valor do array
            }

            if (is_array($horaFimAtendimento)) {
                $horaFimAtendimento = reset($horaFimAtendimento); // Pega o primeiro valor do array
            }

            // Arrays de referência
            $conselhos = [
                'CRAS' => '01',
                'COREN' => '02',
                'CRF' => '03',
                'CRFA' => '04',
                'CREFITO' => '05',
                'CRM' => '06',
                'CRN' => '07',
                'CRO' => '08',
                'CRP' => '09',
                'OUTROS' => '10'
            ];

            $ufs = [
                'AC' => '12',
                'AL' => '27',
                'AP' => '16',
                'AM' => '13',
                'BA' => '29',
                'CE' => '23',
                'DF' => '53',
                'ES' => '32',
                'GO' => '52',
                'MA' => '21',
                'MT' => '51',
                'MS' => '50',
                'MG' => '31',
                'PA' => '15',
                'PB' => '25',
                'PR' => '41',
                'PE' => '26',
                'PI' => '22',
                'RJ' => '33',
                'RN' => '24',
                'RS' => '43',
                'RO' => '11',
                'RR' => '14',
                'SC' => '42',
                'SP' => '35',
                'SE' => '28',
                'TO' => '17'
            ];

            // Salvar os dados gerais na tabela guia_sps
            $guiaSps = GuiaSp::create([
                'agenda_id' => $request->input('agenda_id'),
                'profissional_id' => $request->input('profissional_id'),
                'convenio_id' => $request->input('convenio_id'),
                'paciente_id' => $request->input('paciente_id'),
                'cns' => $request->input('cns'),
                'atendimento_rn' => $request->input('atendimento_rn'),
                'user_id' => $request->input('user_id'),
                'nome_profissional_solicitante' => $request->input('nome_profissional_solicitante'),
                'conselho_profissional' => $request->input('conselho_profissional'),
                'codigo_cbo' => $request->input('codigo_cbo'),
                'nome_contratado' => $request->input('nome_contratado'),
                'codigo_cnes' => $request->input('codigo_cnes'),
                'data_atendimento' => $request->input('data_solicitacao'),
                'codigo_procedimento' => $request->input('codigo_procedimento'),
                'validade_carteira' => $request->input('validade_carteira'),
                'codigo_operadora' => $request->input('codigo_operadora'),
                'codigo_operadora_executante' => $request->input('codigo_operadora_executante'),
                'nome_social' => $request->input('nome_social'),
                'uf_conselho' => $request->input('uf_conselho'),
                'numero_conselho' => $request->input('numero_conselho'),
                'registro_ans' => $request->input('registro_ans'),
                'numero_carteira' => $request->input('numero_carteira'),
                'nome_beneficiario' => $request->input('nome_beneficiario'),
                'numero_guia_prestador' => $request->input('numero_guia_prestador'),
                'hora_inicio_atendimento' => $horaInicioAtendimento,
                'hora_fim_atendimento' => $horaFimAtendimento,
                'data_autorizacao' => $request->input('data_solicitacao'),
                'senha' => $request->input('senha'),
                'validade_senha' => $request->input('validade_senha'),
                'numero_guia_op' => $request->input('numero_guia_op'),
                'carater_atendimento' => $request->input('carater_atendimento'),
                'data_solicitacao' => $request->input('data_solicitacao'),
                'indicacao_clinica' => $request->input('indicacao_clinica'),
                'indicacao_cob_especial' => $request->input('indicacao_cob_especial'),
                'nome_contratado_executante' => $request->input('nome_contratado_executante'),
                'tipo_atendimento' => $request->input('tipo_atendimento'),
                'indicacao_acidente' => $request->input('indicacao_acidente'),
                'tipo_consulta' => $request->input('tipo_consulta'),
                'motivo_encerramento' => $request->input('motivo_encerramento'),
                'regime_atendimento' => $request->input('regime_atendimento'),
                'saude_ocupacional' => $request->input('saude_ocupacional'),
                'sequencia' => $request->input('sequencia'),
                'grua' => $request->input('grau'),
                'codigo_operadora_profissional' => $request->input('codigo_operadora_profissional'),
                'nome_profissional' => $request->input('nome_profissional'),
                'sigla_conselho' => $request->input('sigla_conselho'),
                'numero_conselho_profissional' => $request->input('numero_conselho_profissional'),
                'uf_profissional' => $request->input('uf_profissional'),
                'codigo_cbo_profissional' => $request->input('codigo_cbo_profissional'),
                'sequencia1' => $request->input('sequencia1'),
                'grau1' => $request->input('grau1'),
                'codigo_operadora_profissional1' => $request->input('codigo_operadora_profissional1'),
                'nome_profissional1' => $request->input('nome_profissional1'),
                'sigla_conselho1' => $request->input('sigla_conselho1'),
                'numero_conselho_profissional1' => $request->input('numero_conselho_profissional1'),
                'uf_profissional1' => $request->input('uf_profissional1'),
                'codigo_cbo_profissional1' => $request->input('codigo_cbo_profissional1'),
                'sequencia2' => $request->input('sequencia2'),
                'grau2' => $request->input('grau2'),
                'codigo_operadora_profissional2' => $request->input('codigo_operadora_profissional2'),
                'nome_profissional2' => $request->input('nome_profissional2'),
                'sigla_conselho2' => $request->input('sigla_conselho2'),
                'numero_conselho_profissional2' => $request->input('numero_conselho_profissional2'),
                'uf_profissional2' => $request->input('uf_profissional2'),
                'codigo_cbo_profissional2' => $request->input('codigo_cbo_profissional2'),
                'observacao' => $request->input('observacao') ?? 'N/A',
                'identificador' => 'PENDENTE'
            ]);

            // Verifica se o conselho_profissional está no mapeamento e substitui pelo código numérico
            $conselhoProfissional = $request->input('sigla_conselho');
            if (array_key_exists($conselhoProfissional, $conselhos)) {
                $guiaSps->sigla_conselho = $conselhos[$conselhoProfissional];
            }

            // Verifica se o uf_conselho está no mapeamento e substitui pelo código numérico
            $ufConselho = $request->input('uf_profissional');
            if (array_key_exists($ufConselho, $ufs)) {
                $guiaSps->uf_profissional = $ufs[$ufConselho];
            }

            $conselho_profissional = $request->input('conselho_profissional');
            if (array_key_exists($conselho_profissional, $conselhos)) {
                $guiaSps->conselho_profissional = $conselhos[$conselho_profissional];
            }

            $uf_conselho = $request->input('uf_conselho');
            if (array_key_exists($uf_conselho, $ufs)) {
                $guiaSps->uf_conselho = $ufs[$uf_conselho];
            }

            // Salva as mudanças no banco de dados
            $guiaSps->save();
            $agendaId = $request->input('agenda_id2.0');
            $profId = $request->input('profissional_id2.0');
            $pacId = $request->input('paciente_id2.0');
            if ($request->has('tabela') && $request->has('descricao_procedimento')) {
                foreach ($request->input('tabela') as $index => $tabela) {
                    $codigoProcedimentoSolicitado = $request->input("codigo_procedimento_solicitado.$index");
                    $descricaoProcedimento = $request->input("descricao_procedimento.$index");
                    $qtdSol = $request->input("qtd_sol.$index");
                    $qtdAut = $request->input("qtd_aut.$index");

                    // Verifique se os valores existem antes de salvar
                    if ($tabela && $descricaoProcedimento && $qtdSol && $qtdAut) {
                        ExamesSadt::create([
                            'guia_sps_id' => $guiaSps->id,
                            'tabela' => $tabela,
                            'codigo_procedimento_solicitado' => $codigoProcedimentoSolicitado,
                            'descricao_procedimento' => $descricaoProcedimento,
                            'qtd_sol' => $qtdSol,
                            'qtd_aut' => $qtdAut,
                            'agenda_id' => $agendaId,
                        ]);
                    } else {
                        Log::warning("Exame $index não foi salvo devido a dados incompletos", [
                            'tabela' => $tabela,
                            'codigo_procedimento_solicitado' => $codigoProcedimentoSolicitado,
                            'descricao_procedimento' => $descricaoProcedimento,
                            'qtd_sol' => $qtdSol,
                            'qtd_aut' => $qtdAut,
                        ]);
                    }
                }
            }

            Log::info($request->input("codigo_procedimento_solicitado.$index"));
            // Salvar na tabela exames
            // Captura o valor do primeiro índice de agenda_id2

            log::info($agendaId);

            // Itera sobre as tabelas e utiliza o mesmo agenda_id
            foreach ($request->input('tabela') as $index => $tabela) {
                // Verifica se o procedimento_id está preenchido
                if ($request->filled("proce_id.$index")) {
                    Exames::create([
                        'profissional_id' => $profId,
                        'tabela' => $tabela,
                        'paciente_id' => $pacId,
                        'procedimento_id' => $request->input("proce_id.$index"),
                        'qtd_sol' => $request->input("qtd_sol.$index"),
                        'agenda_id' => $agendaId, // Usa o valor do primeiro índice
                    ]);
                }
            }



            // Salvar os procedimentos na tabela exames_aut_sadt
            if ($request->has('descricao_procedimento_realizado')) {
                $valorTotal = 0; // Inicializa a variável para soma

                foreach ($request->input('data_real') as $index => $dataReal) {
                    $valorTotalItem = $request->input("valor_total.$index");
                    $valorTotal += $valorTotalItem; // Acumula os valores

                    ExamesAutSadt::create([
                        'guia_sps_id' => $guiaSps->id,
                        'data_real' => $dataReal,
                        'hora_inicio_atendimento' => $request->input("hora_inicio_atendimento.$index"),
                        'hora_fim_atendimento' => $request->input("hora_fim_atendimento.$index"),
                        'tabela' => $request->input("tabela.$index"),
                        'codigo_procedimento_realizado' => $request->input("codigo_procedimento_realizado.$index"),
                        'descricao_procedimento_realizado' => $request->input("descricao_procedimento_realizado.$index"),
                        'quantidade_autorizada' => $request->input("quantidade_autorizada.$index"),
                        'via' => $request->input("via.$index"),
                        'tecnica' => $request->input("tecnica.$index"),
                        'fator_red_acres' => $request->input("fator_red_acres.$index"),
                        'valor_unitario' => $request->input("valor_unitario.$index"),
                        'valor_total' => $valorTotalItem,
                    ]);
                }

                // Atualiza a tabela guia_sps com a soma total dos valores
                GuiaSp::where('id', $guiaSps->id)->update([
                    'valor_total' => $valorTotal
                ]);
            }


            Log::info($request->input("descricao_procedimento_realizado.$index"));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Guia SADT salva com sucesso!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erro ao salvar a Guia SADT.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function excluirExame(Request $request)
    {
        try {
            // Valida os dados recebidos
            $request->validate([
                'codigo' => 'required|string',
                'procedimento' => 'required|string',
                'qtd_sol' => 'required|integer',
                'agenda_id' => 'required|integer',
                'id' => 'required|integer',
            ]);

            // Excluir o primeiro registro correspondente na tabela exames
            DB::transaction(function () use ($request) {
                // Excluir o primeiro registro em `exames`
                $exame = DB::table('exames')
                    ->where([
                        ['qtd_sol', '=', $request->qtd_sol],
                        ['agenda_id', '=', $request->agenda_id],
                        ['id', '=', $request->id],
                    ])
                    ->first();

                if ($exame) {
                    DB::table('exames')->where('id', $exame->id)->delete();
                }

                // Excluir o primeiro registro em `exames_sadt`
                $exameSadt = DB::table('exames_sadt')
                    ->where([
                        ['codigo_procedimento_solicitado', '=', $request->codigo],
                        ['descricao_procedimento', '=', $request->procedimento],
                        ['qtd_sol', '=', $request->qtd_sol],
                        ['agenda_id', '=', $request->agenda_id],
                    ])
                    ->first();

                if ($exameSadt) {
                    DB::table('exames_sadt')->where('id', $exameSadt->id)->delete();
                }
            });

            return response()->json(['success' => true, 'message' => 'Registro excluído com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao excluir o registro.', 'error' => $e->getMessage()], 500);
        }
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

    public function editarGuia($id)
    {
        // Busca a guia com o relacionamento do profissional
        $guia = GuiaSp::with('profissional')->find($id);

        // Verifica se a guia foi encontrada
        if (!$guia) {
            return response()->json(['error' => 'Guia não encontrada.'], 404);
        }

        // Retorna os dados da guia e do profissional
        return response()->json([
            'success' => true,
            'guia' => $guia,
            'profissional' => $guia->profissional, // Inclui dados do profissional
        ]);
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
    public function edit(Guiasp $guiaSadt)
    {
        $profissionals = Profissional::join('especialidade_profissional', 'profissionals.id', '=', 'especialidade_profissional.profissional_id')
            ->leftJoin('especialidades', 'especialidade_profissional.especialidade_id', '=', 'especialidades.id')
            ->select(
                'profissionals.*',
                'especialidades.conselho as conselho_profissional'
            )
            ->distinct('profissionals.id') // Retorna registros únicos por profissional
            ->get();

        // Obtém um único registro usando first()
        $guia = GuiaSp::where('id', $guiaSadt->id)->first();

        // Verifica se o guia foi encontrado antes de acessar a propriedade id
        if (!$guia) {
            return redirect()->back()->with('error', 'Guia não encontrada.');
        }

        $exameSoli = ExamesSadt::where('guia_sps_id', $guia->id)->get();
        $exameAut = ExamesAutSadt::where('guia_sps_id', $guia->id)->get();

        $conselhos = [
            'CRAS' => '01',
            'COREN' => '02',
            'CRF' => '03',
            'CRFA' => '04',
            'CREFITO' => '05',
            'CRM' => '06',
            'CRN' => '07',
            'CRO' => '08',
            'CRP' => '09',
            'OUTROS' => '10'
        ];

        $ufs = [
            'AC' => '12',
            'AL' => '27',
            'AP' => '16',
            'AM' => '13',
            'BA' => '29',
            'CE' => '23',
            'DF' => '53',
            'ES' => '32',
            'GO' => '52',
            'MA' => '21',
            'MT' => '51',
            'MS' => '50',
            'MG' => '31',
            'PA' => '15',
            'PB' => '25',
            'PR' => '41',
            'PE' => '26',
            'PI' => '22',
            'RJ' => '33',
            'RN' => '24',
            'RS' => '43',
            'RO' => '11',
            'RR' => '14',
            'SC' => '42',
            'SP' => '35',
            'SE' => '28',
            'TO' => '17'
        ];

        return view('guias.sadtEditar', compact('guiaSadt', 'conselhos', 'ufs', 'exameSoli', 'exameAut', 'profissionals'));
    }

    public function updateGuiaSadt(Request $request, GuiaSp $guiaSadt)
    {
        // Dados de apoio
        $conselhos = [
            'CRAS' => '01',
            'COREN' => '02',
            'CRF' => '03',
            'CRFA' => '04',
            'CREFITO' => '05',
            'CRM' => '06',
            'CRN' => '07',
            'CRO' => '08',
            'CRP' => '09',
            'OUTROS' => '10'
        ];

        $ufs = [
            'AC' => '12',
            'AL' => '27',
            'AP' => '16',
            'AM' => '13',
            'BA' => '29',
            'CE' => '23',
            'DF' => '53',
            'ES' => '32',
            'GO' => '52',
            'MA' => '21',
            'MT' => '51',
            'MS' => '50',
            'MG' => '31',
            'PA' => '15',
            'PB' => '25',
            'PR' => '41',
            'PE' => '26',
            'PI' => '22',
            'RJ' => '33',
            'RN' => '24',
            'RS' => '43',
            'RO' => '11',
            'RR' => '14',
            'SC' => '42',
            'SP' => '35',
            'SE' => '28',
            'TO' => '17'
        ];

        // Atualizar a guia existente
        $guiaSadt->update($request->only([
            'agenda_id',
            'profissional_id',
            'convenio_id',
            'paciente_id',
            'cns',
            'atendimento_rn',
            'user_id',
            'nome_profissional_solicitante',
            'conselho_profissional',
            'codigo_cbo',
            'nome_contratado',
            'codigo_cnes',
            'data_atendimento',
            'codigo_procedimento',
            'validade_carteira',
            'codigo_operadora',
            'codigo_operadora_executante',
            'nome_social',
            'uf_conselho',
            'numero_conselho',
            'registro_ans',
            'numero_carteira',
            'nome_beneficiario',
            'numero_guia_prestador',
            'hora_inicio_atendimento',
            'hora_fim_atendimento',
            'data_autorizacao',
            'senha',
            'validade_senha',
            'numero_guia_op',
            'carater_atendimento',
            'data_solicitacao',
            'indicacao_clinica',
            'indicacao_cob_especial',
            'nome_contratado_executante',
            'tipo_atendimento',
            'indicacao_acidente',
            'tipo_consulta',
            'motivo_encerramento',
            'regime_atendimento',
            'saude_ocupacional',
            'sequencia',
            'grua',
            'codigo_operadora_profissional',
            'nome_profissional',
            'sigla_conselho',
            'numero_conselho_profissional',
            'uf_profissional',
            'codigo_cbo_profissional',
            'observacao'
        ]) + [
            'identificador' => 'GERADO',
            'conselho_profissional' => array_key_exists($request->input('conselho_profissional'), $conselhos)
                ? $conselhos[$request->input('conselho_profissional')]
                : $request->input('conselho_profissional'),
            'uf_conselho' => array_key_exists($request->input('uf_conselho'), $ufs)
                ? $ufs[$request->input('uf_conselho')]
                : $request->input('uf_conselho'),
        ]);

        // Obter o lote atual
        $loteAtual = $guiaSadt->numeracao;

        // Criar uma nova guia com o lote incrementado
        $novaGuia = $guiaSadt->replicate();
        $novaGuia->numeracao = $loteAtual + 1;
        $novaGuia->identificador = 'GLOSADA';
        $novaGuia->save();

        return redirect()->route('faturamentoGlosa.index')->with('success', 'Guia SADT atualizada e nova guia criada com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */



    public function glosaSadt(Request $request)
    {
        try {
            DB::beginTransaction();

            // Arrays de referência
            $conselhos = [
                'CRAS' => '01',
                'COREN' => '02',
                'CRF' => '03',
                'CRFA' => '04',
                'CREFITO' => '05',
                'CRM' => '06',
                'CRN' => '07',
                'CRO' => '08',
                'CRP' => '09',
                'OUTROS' => '10'
            ];

            $ufs = [
                'AC' => '12',
                'AL' => '27',
                'AP' => '16',
                'AM' => '13',
                'BA' => '29',
                'CE' => '23',
                'DF' => '53',
                'ES' => '32',
                'GO' => '52',
                'MA' => '21',
                'MT' => '51',
                'MS' => '50',
                'MG' => '31',
                'PA' => '15',
                'PB' => '25',
                'PR' => '41',
                'PE' => '26',
                'PI' => '22',
                'RJ' => '33',
                'RN' => '24',
                'RS' => '43',
                'RO' => '11',
                'RR' => '14',
                'SC' => '42',
                'SP' => '35',
                'SE' => '28',
                'TO' => '17'
            ];

            $horaInicioAtendimento = is_array($request->input('hora_inicio_atendimento'))
                ? reset($request->input('hora_inicio_atendimento'))
                : $request->input('hora_inicio_atendimento');

            $horaFimAtendimento = is_array($request->input('hora_fim_atendimento'))
                ? reset($request->input('hora_fim_atendimento'))
                : $request->input('hora_fim_atendimento');

            // Criar a guia
            $guia = GuiaSp::create([
                'user_id' => auth()->id(),
                'agenda_id' => $request->input('agenda_id'),
                'convenio_id' => $request->input('convenio_id'),
                'profissional_id' => $request->input('profissional_id'),
                'paciente_id' => $request->input('paciente_id'),
                'cns' => $request->input('cns'),
                'atendimento_rn' => $request->input('atendimento_rn'),
                'nome_profissional_solicitante' => $request->input('nome_profissional_solicitante'),
                'conselho_profissional' => $request->input('conselho_profissional'),
                'codigo_cbo' => $request->input('codigo_cbo'),
                'nome_contratado' => $request->input('nome_contratado'),
                'codigo_cnes' => $request->input('codigo_cnes'),
                'data_atendimento' => $request->input('data_solicitacao'),
                'codigo_procedimento' => $request->input('codigo_procedimento'),
                'validade_carteira' => $request->input('validade_carteira'),
                'codigo_operadora' => $request->input('codigo_operadora'),
                'codigo_operadora_executante' => $request->input('codigo_operadora_executante'),
                'nome_social' => $request->input('nome_social'),
                'uf_conselho' => $request->input('uf_conselho'),
                'numero_conselho' => $request->input('numero_conselho'),
                'registro_ans' => $request->input('registro_ans'),
                'numero_carteira' => $request->input('numero_carteira'),
                'nome_beneficiario' => $request->input('nome_beneficiario'),
                'numero_guia_prestador' => $request->input('numero_guia_prestador'),
                'hora_inicio_atendimento' => $horaInicioAtendimento,
                'hora_fim_atendimento' => $horaFimAtendimento,
                'data_autorizacao' => $request->input('data_solicitacao'),
                'senha' => $request->input('senha'),
                'validade_senha' => $request->input('validade_senha'),
                'numero_guia_op' => $request->input('numero_guia_op'),
                'carater_atendimento' => $request->input('carater_atendimento'),
                'data_solicitacao' => $request->input('data_solicitacao'),
                'indicacao_clinica' => $request->input('indicacao_clinica'),
                'indicacao_cob_especial' => $request->input('indicacao_cob_especial'),
                'nome_contratado_executante' => $request->input('nome_contratado_executante'),
                'tipo_atendimento' => $request->input('tipo_atendimento'),
                'indicacao_acidente' => $request->input('indicacao_acidente'),
                'tipo_consulta' => $request->input('tipo_consulta'),
                'motivo_encerramento' => $request->input('motivo_encerramento'),
                'regime_atendimento' => $request->input('regime_atendimento'),
                'saude_ocupacional' => $request->input('saude_ocupacional'),
                'sequencia' => $request->input('sequencia'),
                'grua' => $request->input('grau'),
                'codigo_operadora_profissional' => $request->input('codigo_operadora_profissional'),
                'nome_profissional' => $request->input('nome_profissional'),
                'sigla_conselho' => $request->input('sigla_conselho'),
                'numero_conselho_profissional' => $request->input('numero_conselho_profissional'),
                'uf_profissional' => $request->input('uf_profissional'),
                'codigo_cbo_profissional' => $request->input('codigo_cbo_profissional'),
                'sequencia1' => $request->input('sequencia1'),
                'grau1' => $request->input('grau1'),
                'codigo_operadora_profissional1' => $request->input('codigo_operadora_profissional1'),
                'nome_profissional1' => $request->input('nome_profissional1'),
                'sigla_conselho1' => $request->input('sigla_conselho1'),
                'numero_conselho_profissional1' => $request->input('numero_conselho_profissional1'),
                'uf_profissional1' => $request->input('uf_profissional1'),
                'codigo_cbo_profissional1' => $request->input('codigo_cbo_profissional1'),
                'sequencia2' => $request->input('sequencia2'),
                'grau2' => $request->input('grau2'),
                'codigo_operadora_profissional2' => $request->input('codigo_operadora_profissional2'),
                'nome_profissional2' => $request->input('nome_profissional2'),
                'sigla_conselho2' => $request->input('sigla_conselho2'),
                'numero_conselho_profissional2' => $request->input('numero_conselho_profissional2'),
                'uf_profissional2' => $request->input('uf_profissional2'),
                'codigo_cbo_profissional2' => $request->input('codigo_cbo_profissional2'),
                'observacao' => $request->input('observacao') ?? 'N/A',
                'identificador' => 'GERADO'
            ]);

            // Substituir valores de conselhos e UF por códigos
            if (array_key_exists($request->input('sigla_conselho'), $conselhos)) {
                $guia->update(['sigla_conselho' => $conselhos[$request->input('sigla_conselho')]]);
            }

            if (array_key_exists($request->input('uf_profissional'), $ufs)) {
                $guia->update(['uf_profissional' => $ufs[$request->input('uf_profissional')]]);
            }

            // Atualizar exames na tabela exames_sadt
            if ($request->has('descricao_procedimento')) {
                foreach ($request->input('tabela') as $index => $tabela) {
                    ExamesSadt::create([
                        'guia_sps_id' => $guia->id,
                        'tabela' => $tabela,
                        'codigo_procedimento_solicitado' => $request->input("codigo_procedimento_solicitado.$index"),
                        'descricao_procedimento' => $request->input("descricao_procedimento.$index"),
                        'qtd_sol' => $request->input("qtd_sol.$index"),
                        'qtd_aut' => $request->input("qtd_aut.$index"),
                    ]);
                }
            }

            // Atualizar procedimentos na tabela exames_aut_sadt
            if ($request->has('descricao_procedimento_realizado')) {
                foreach ($request->input('data_real') as $index => $dataReal) {
                    ExamesAutSadt::create([
                        'guia_sps_id' => $guia->id,
                        'data_real' => $dataReal,
                        'hora_inicio_atendimento' => $request->input("hora_inicio_atendimento.$index"),
                        'hora_fim_atendimento' => $request->input("hora_fim_atendimento.$index"),
                        'tabela' => $request->input("tabela.$index"),
                        'codigo_procedimento_realizado' => $request->input("codigo_procedimento_realizado.$index"),
                        'descricao_procedimento_realizado' => $request->input("descricao_procedimento_realizado.$index"),
                        'quantidade_autorizada' => $request->input("quantidade_autorizada.$index"),
                        'via' => $request->input("via.$index"),
                        'tecnica' => $request->input("tecnica.$index"),
                        'fator_red_acres' => $request->input("fator_red_acres.$index"),
                        'valor_unitario' => $request->input("valor_unitario.$index"),
                        'valor_total' => $request->input("valor_total.$index"),
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Guia criada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao criar guia: ' . $e->getMessage());
        }
    }

    public function destroy(GuiaSp $guiasp)
    {
        //
    }
}
