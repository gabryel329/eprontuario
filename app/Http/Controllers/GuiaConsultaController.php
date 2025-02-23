<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\ContaGuia;
use App\Models\ContasFinanceiras;
use App\Models\Convenio;
use App\Models\Empresas;
use App\Models\GuiaConsulta;
use App\Models\GuiaTiss;
use App\Models\Pacientes;
use App\Models\Profissional;
use App\Models\TipoAtendimento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GuiaConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guiaConsulta = GuiaConsulta::all();
        $convenios = Convenio::all();
        $tiposConsultas = TipoAtendimento::all();
        return view('guias.guia_consulta', compact('guiaConsulta', 'convenios', 'tiposConsultas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function listarGuiasConsulta(Request $request)
    {
        $convenio_id = $request->get('convenio_id');
        $identificador = $request->get('identificador');

        // Verifica se o convênio foi fornecido
        if (!$convenio_id) {
            return response()->json(['error' => 'Convênio não encontrado.'], 404);
        }

        // Consulta com base no convênio e identificador (se fornecido)
        $query = GuiaConsulta::where('convenio_id', $convenio_id);

        if ($identificador) {
            $query->where('identificador', $identificador);
        }

        $guiasp = $query->get();

        return response()->json(['guias' => $guiasp]);
    }
    public function gerarGuiaConsulta($id)
    {
        // Buscar a agenda pelo ID
        $agenda = Agenda::findOrFail($id);

        $guia = GuiaConsulta::join('agendas', 'guia_consulta.agenda_id', '=', 'agendas.id')
            ->select('guia_consulta.*')
            ->where('guia_consulta.agenda_id', $agenda->id)
            ->first();

        $empresa = Empresas::first();

        return view('formulario.guiaconsulta', [
            'agenda' => $agenda,
            'guia' => $guia,
            'empresa' => $empresa,
        ]);

    }

    public function gerarGuiaConsultaMODAL($id)
    {
        // Buscar a agenda pelo ID
        $agenda = Agenda::findOrFail($id);

        $paciente = Pacientes::find($agenda->paciente_id);

        $profissional = Profissional::join('especialidade_profissional', 'profissionals.id', '=', 'especialidade_profissional.profissional_id')
            ->leftJoin('especialidades', 'especialidade_profissional.especialidade_id', '=', 'especialidades.id') // Fazendo o left join com especialidades
            ->select(
                'profissionals.*',
                'especialidades.conselho as conselho_profissional' // Selecionando o nome da especialidade
            )
            ->where('profissionals.id', $agenda->profissional_id)
            ->first();

        $guia = GuiaConsulta::where('agenda_id', $agenda->id)->first();

        $convenio = Convenio::find($agenda->convenio_id);

        $empresa = Empresas::first();

        // Retornar os dados em formato JSON para o AJAX preencher o modal
        return response()->json([
            'agenda' => $agenda,
            'paciente' => $paciente,
            'profissional' => $profissional,
            'convenio' => $convenio,
            'empresa' => $empresa,
            'guia' => $guia
        ]);
    }

    public function salvarGuiaConsulta(Request $request)
    {
        $guiaExistente = GuiaConsulta::where('agenda_id', $request->input('agenda_id'))->exists();

        if ($guiaExistente) {
            return response()->json([
                'success' => true,
                'message' => 'Guia Consulta já existente.'
            ]);
        }

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

        // Se não existe, cria uma nova guia
        $guia = new GuiaConsulta();
        $guia->user_id = auth()->user()->id;
        $guia->convenio_id = $request->input('convenio_id');
        $guia->paciente_id = $request->input('paciente_id');
        $guia->profissional_id = $request->input('profissional_id');
        $guia->agenda_id = $request->input('agenda_id');
        $guia->numero_guia_operadora = $request->input('numero_guia_operadora');
        $guia->registro_ans = $request->input('registro_ans');
        $guia->numero_carteira = $request->input('numero_carteira');
        $guia->validade_carteira = $request->input('validade_carteira');
        $guia->atendimento_rn = $request->input('atendimento_rn');
        $guia->nome_social = $request->input('nome_social');
        $guia->nome_beneficiario = $request->input('nome_beneficiario');
        $guia->codigo_operadora = $request->input('codigo_operadora');
        $guia->nome_contratado = $request->input('nome_contratado');
        $guia->codigo_cnes = $request->input('cnes');
        $guia->nome_profissional_executante = $request->input('nome_profissional_executante');
        $guia->numero_conselho = $request->input('conselho_1');
        $guia->codigo_cbo = $request->input('codigo_cbo');
        $guia->indicacao_acidente = $request->input('indicacao_acidente');
        $guia->indicacao_cobertura_especial = $request->input('indicacao_cobertura_especial');
        $guia->regime_atendimento = $request->input('regime_atendimento') ?? '01';
        $guia->saude_ocupacional = $request->input('saude_ocupacional');
        $guia->data_atendimento = $request->input('data_atendimento');
        $guia->tipo_consulta = $request->input('tipo_consulta');
        $guia->codigo_tabela = '22';
        $guia->codigo_procedimento = $request->input('codigo_procedimento');
        $guia->valor_procedimento = $request->input('valor_procedimento');
        $guia->observacao = $request->input('observacao');
        $guia->identificador = 'PENDENTE';

        // Verifica se o conselho_profissional está no mapeamento e substitui pelo código numérico
        $conselhoProfissional = $request->input('conselho_profissional');
        if (array_key_exists($conselhoProfissional, $conselhos)) {
            $guia->conselho_profissional = $conselhos[$conselhoProfissional];
        } else {
            $guia->conselho_profissional = $conselhoProfissional; // Mantém o valor original se não estiver no mapeamento
        }

        // Verifica se o uf_conselho está no mapeamento e substitui pelo código numérico
        $ufConselho = $request->input('uf_conselho');
        if (array_key_exists($ufConselho, $ufs)) {
            $guia->uf_conselho = $ufs[$ufConselho];
        } else {
            $guia->uf_conselho = $ufConselho; // Mantém o valor original se não estiver no mapeamento
        }

        // Salva a nova guia no banco de dados
        $guia->save();

        // Retorna uma resposta de sucesso após salvar
        return response()->json([
            'success' => true,
            'message' => 'Guia Consulta criada com sucesso!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function impressaoGuia($id)
    {
        $guia = GuiaConsulta::findOrFail($id);

        $empresa = Empresas::first();

        if (!$guia) {
            return redirect()->back()->with('error', 'Guia não encontrada.');
        }


        return view('formulario.guiaconsulta', compact('guia', 'empresa'));
    }

    public function visualizarConsulta($id)
    {
        $guia = GuiaConsulta::find($id);
        if ($guia) {
            return response()->json($guia);
        } else {
            return response()->json(['error' => 'Guia não encontrada.'], 404);
        }
    }

    public function gerarXmlGuiaConsultaEmLote(Request $request)
    {
        $guiaIds = $request->input('guia_ids');
        $numeracao = $request->input('numeracao'); // Recebe a numeracao do frontend, se fornecida

        $guias = GuiaConsulta::with('profissional')->whereIn('id', $guiaIds)->get();

        // Verificar a presença de `numeracao`
        $sequencialTransacao = $guias->first()->numeracao ?? $guias->skip(1)->first()->numeracao ?? $numeracao;

        // Se nenhuma `numeracao` estiver disponível, retorne um erro
        if (is_null($sequencialTransacao)) {
            return response()->json([
                'error' => 'Numeração não encontrada para o lote. Por favor, insira a numeração para o lote.'
            ], 422);
        }

        // Salvar a numeracao nas guias selecionadas, caso tenha sido inserida via prompt
        if ($numeracao) {
            foreach ($guias as $guia) {
                $guia->numeracao = $numeracao;
                $guia->save();
            }
        }

        // Aplica a `numeracao` para todas as guias no lote
        foreach ($guias as $guia) {
            if (is_null($guia->numeracao)) {
                $guia->numeracao = $sequencialTransacao;
                $guia->save();
            }
        }

        // Inicia a criação do XML com a estrutura de cabeçalho
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><ans:mensagemTISS xmlns:ans="http://www.ans.gov.br/padroes/tiss/schemas" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.ans.gov.br/padroes/tiss/schemas http://www.ans.gov.br/padroes/tiss/schemas/tissV4_01_00.xsd"></ans:mensagemTISS>');

        // Cabeçalho
        $cabecalho = $xml->addChild('ans:cabecalho');
        $identificacaoTransacao = $cabecalho->addChild('ans:identificacaoTransacao');
        $identificacaoTransacao->addChild('ans:tipoTransacao', 'ENVIO_LOTE_GUIAS');
        $identificacaoTransacao->addChild('ans:sequencialTransacao', $sequencialTransacao); // Usa a numeracao determinada
        $identificacaoTransacao->addChild('ans:dataRegistroTransacao', date('Y-m-d'));
        $identificacaoTransacao->addChild('ans:horaRegistroTransacao', date('H:i:s'));

        $origem = $cabecalho->addChild('ans:origem');
        $identificacaoPrestador = $origem->addChild('ans:identificacaoPrestador');
        $identificacaoPrestador->addChild('ans:codigoPrestadorNaOperadora', $guias->first()->codigo_operadora);

        $destino = $cabecalho->addChild('ans:destino');
        $destino->addChild('ans:registroANS', $guias->first()->registro_ans);

        $cabecalho->addChild('ans:Padrao', '4.01.00');

        // Lote de Guias
        $prestadorParaOperadora = $xml->addChild('ans:prestadorParaOperadora');
        $loteGuias = $prestadorParaOperadora->addChild('ans:loteGuias');
        $loteGuias->addChild('ans:numeroLote', $sequencialTransacao); // Usa a mesma numeracao para o número do lote
        $guiasTISS = $loteGuias->addChild('ans:guiasTISS');

        // Adiciona cada guia selecionada ao lote
        foreach ($guias as $guia) {
            $guiaConsulta = $guiasTISS->addChild('ans:guiaConsulta');

            // Cabeçalho da Guia
            $cabecalhoConsulta = $guiaConsulta->addChild('ans:cabecalhoConsulta');
            $cabecalhoConsulta->addChild('ans:registroANS', $guia->registro_ans);
            $cabecalhoConsulta->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_operadora);

            // Dados do Beneficiário
            $dadosBeneficiario = $guiaConsulta->addChild('ans:dadosBeneficiario');
            $dadosBeneficiario->addChild('ans:numeroCarteira', $guia->numero_carteira);
            $dadosBeneficiario->addChild('ans:atendimentoRN', $guia->atendimento_rn);

            // Dados do Contratado Executante
            $dadosContratadoExecutante = $guiaConsulta->addChild('ans:contratadoExecutante');
            $dadosContratadoExecutante->addChild('ans:codigoPrestadorNaOperadora', $guia->codigo_operadora);
            $dadosContratadoExecutante->addChild('ans:CNES', $guia->codigo_cnes);

            // Profissional Executante
            $profissionalExecutante = $guiaConsulta->addChild('ans:profissionalExecutante');
            $profissionalExecutante->addChild('ans:nomeProfissional', $guia->profissional->name);
            $profissionalExecutante->addChild('ans:conselhoProfissional', $guia->conselho_profissional);
            $profissionalExecutante->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho);
            $profissionalExecutante->addChild('ans:UF', $guia->uf_conselho);
            $profissionalExecutante->addChild('ans:CBOS', $guia->codigo_cbo);

            // Indicacao Acidente
            $guiaConsulta->addChild('ans:indicacaoAcidente', $guia->indicacao_acidente);

            // Dados do Atendimento
            $dadosAtendimento = $guiaConsulta->addChild('ans:dadosAtendimento');
            $dadosAtendimento->addChild('ans:regimeAtendimento', $guia->regime_atendimento);
            $dadosAtendimento->addChild('ans:dataAtendimento', $guia->data_atendimento);
            $dadosAtendimento->addChild('ans:tipoConsulta', $guia->tipo_consulta);

            // Procedimento
            $procedimento = $dadosAtendimento->addChild('ans:procedimento');
            $procedimento->addChild('ans:codigoTabela', $guia->codigo_tabela);
            $procedimento->addChild('ans:codigoProcedimento', $guia->codigo_procedimento);
            $procedimento->addChild('ans:valorProcedimento', $guia->valor_procedimento);

            // Observação
            // $guiaConsulta->addChild('ans:observacao', $guia->observacao);
            $guiaConsulta->addChild('ans:observacao', !empty($guia->observacao) ? $guia->observacao : 'N/A');
        }

        // Epílogo
        $epilogo = $xml->addChild('ans:epilogo');
        $epilogo->addChild('ans:hash', md5($xml->asXML())); // Gera um hash MD5 do XML para verificar integridade

        $guia->identificador = 'GERADO';
        $guia->save();

        // Retorna o XML como download
        $fileName = 'lote_guias_consulta.xml';
        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function gerarZipGuiaConsultaEmLote(Request $request)
    {
        $guiaIds = $request->input('guia_ids');
        $numeracao = $request->input('numeracao');

        $guias = GuiaConsulta::with('profissional')->whereIn('id', $guiaIds)->get();

        $sequencialTransacao = $guias->first()->numeracao ?? $guias->skip(1)->first()->numeracao ?? $numeracao;

        if (is_null($sequencialTransacao)) {
            return response()->json([
                'error' => 'Numeração não encontrada para o lote. Por favor, insira a numeração para o lote.'
            ], 422);
        }

        // Verifica se já existe uma conta financeira para esse lote
        $contaExistente = ContaGuia::where('lote', $sequencialTransacao)->first();

        if (!$contaExistente) {
            // Atualiza as guias com a numeração correta
            foreach ($guias as $guia) {
                $guia->identificador = 'GERADO';
                $guia->save();
            }

            // Calcula o valor total do lote
            $valorTotal = $guias->sum('valor_procedimento');
            $referencia = $sequencialTransacao;

            // Cria a conta financeira
            $conta = ContasFinanceiras::create([
                'user_id' => auth()->id(),
                'status' => 'Aberto',
                'tipo_conta' => 'Receber',
                'convenio_id' => $guias->first()->convenio_id,
                'tipo_guia' => 'Consulta',
                'parcelas' => '1/1',
                'data_emissao' => Carbon::parse($guia->data_atendimento)->format('Y-m-d'),
                'competencia' => Carbon::parse($guia->data_atendimento)->format('Y-m-d'),
                'data_vencimento' => now()->addDays(30)->format('Y-m-d'),
                'referencia' => $referencia,
                'tipo_doc' => 'XML',
                'centro_custos' => $guias->first()->nome_contratado ?? 'Desconhecido',
                'documento' => 'lote_guias_consulta_' . $sequencialTransacao . '.xml',
                'valor' => $valorTotal,
                'historico' => 'Guia de Consulta - ' . $guia->data_atendimento,
            ]);

            // Salva o relacionamento na tabela `conta_guias`
            foreach ($guias as $guia) {
                ContaGuia::create([
                    'conta_financeira_id' => $conta->id,
                    'guia_id' => $guia->id,
                    'tipo_guia' => 'Consulta',
                    'lote' => $sequencialTransacao,
                ]);
            }
        } else {
            // Apenas atualiza as guias e registra o relacionamento se não existirem
            foreach ($guias as $guia) {
                $existeRelacionamento = ContaGuia::where('guia_id', $guia->id)
                    ->where('tipo_guia', 'Consulta')
                    ->exists();

                if (!$existeRelacionamento) {
                    $guia->numeracao = $sequencialTransacao;
                    $guia->identificador = 'GERADO';
                    $guia->save();

                    ContaGuia::create([
                        'conta_financeira_id' => $contaExistente->conta_financeira_id,
                        'guia_id' => $guia->id,
                        'tipo_guia' => 'Consulta',
                        'lote' => $sequencialTransacao,
                    ]);
                }
            }
        }

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><ans:mensagemTISS xmlns:ans="http://www.ans.gov.br/padroes/tiss/schemas" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.ans.gov.br/padroes/tiss/schemas http://www.ans.gov.br/padroes/tiss/schemas/tissV4_01_00.xsd"></ans:mensagemTISS>');

        $cabecalho = $xml->addChild('ans:cabecalho');
        $identificacaoTransacao = $cabecalho->addChild('ans:identificacaoTransacao');
        $identificacaoTransacao->addChild('ans:tipoTransacao', 'ENVIO_LOTE_GUIAS');
        $identificacaoTransacao->addChild('ans:sequencialTransacao', $sequencialTransacao);
        $identificacaoTransacao->addChild('ans:dataRegistroTransacao', date('Y-m-d'));
        $identificacaoTransacao->addChild('ans:horaRegistroTransacao', date('H:i:s'));

        $origem = $cabecalho->addChild('ans:origem');
        $identificacaoPrestador = $origem->addChild('ans:identificacaoPrestador');
        $identificacaoPrestador->addChild('ans:codigoPrestadorNaOperadora', $guias->first()->codigo_operadora);

        $destino = $cabecalho->addChild('ans:destino');
        $destino->addChild('ans:registroANS', $guias->first()->registro_ans);

        $cabecalho->addChild('ans:Padrao', '4.01.00');

        $prestadorParaOperadora = $xml->addChild('ans:prestadorParaOperadora');
        $loteGuias = $prestadorParaOperadora->addChild('ans:loteGuias');
        $loteGuias->addChild('ans:numeroLote', $sequencialTransacao);
        $guiasTISS = $loteGuias->addChild('ans:guiasTISS');

        foreach ($guias as $guia) {
            $guiaConsulta = $guiasTISS->addChild('ans:guiaConsulta');

            $cabecalhoConsulta = $guiaConsulta->addChild('ans:cabecalhoConsulta');
            $cabecalhoConsulta->addChild('ans:registroANS', $guia->registro_ans);
            $cabecalhoConsulta->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_operadora);

            $dadosBeneficiario = $guiaConsulta->addChild('ans:dadosBeneficiario');
            $dadosBeneficiario->addChild('ans:numeroCarteira', $guia->numero_carteira);
            $dadosBeneficiario->addChild('ans:atendimentoRN', $guia->atendimento_rn);

            $dadosContratadoExecutante = $guiaConsulta->addChild('ans:contratadoExecutante');
            $dadosContratadoExecutante->addChild('ans:codigoPrestadorNaOperadora', $guia->codigo_operadora);
            $dadosContratadoExecutante->addChild('ans:CNES', $guia->codigo_cnes);

            $profissionalExecutante = $guiaConsulta->addChild('ans:profissionalExecutante');
            $profissionalExecutante->addChild('ans:nomeProfissional', $guia->profissional->name);
            $profissionalExecutante->addChild('ans:conselhoProfissional', $guia->conselho_profissional);
            $profissionalExecutante->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho);
            $profissionalExecutante->addChild('ans:UF', $guia->uf_conselho);
            $profissionalExecutante->addChild('ans:CBOS', $guia->codigo_cbo);

            $guiaConsulta->addChild('ans:indicacaoAcidente', $guia->indicacao_acidente);

            $dadosAtendimento = $guiaConsulta->addChild('ans:dadosAtendimento');
            $dadosAtendimento->addChild('ans:regimeAtendimento', $guia->regime_atendimento);
            $dadosAtendimento->addChild('ans:dataAtendimento', $guia->data_atendimento);
            $dadosAtendimento->addChild('ans:tipoConsulta', $guia->tipo_consulta);

            $procedimento = $dadosAtendimento->addChild('ans:procedimento');
            $procedimento->addChild('ans:codigoTabela', $guia->codigo_tabela);
            $procedimento->addChild('ans:codigoProcedimento', $guia->codigo_procedimento);
            $procedimento->addChild('ans:valorProcedimento', $guia->valor_procedimento);

            // $guiaConsulta->addChild('ans:observacao', $guia->observacao);
            $guiaConsulta->addChild('ans:observacao', !empty($guia->observacao) ? $guia->observacao : 'N/A');
        }

        $epilogo = $xml->addChild('ans:epilogo');
        $hash = md5($xml->asXML());
        $epilogo->addChild('ans:hash', $hash);

        $guia->identificador = 'GERADO';
        $guia->save();

        $fileName = 'lote_guias_consulta.xml';
        $filePath = storage_path('app/public/' . $fileName);
        $xml->asXML($filePath);

        $zipFileName = 'lote_guias_consulta.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        $zip = new \ZipArchive;
        if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
            $zip->addFile($filePath, $fileName);
            $zip->close();
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }


    public function gerarXmlGuiaConsulta($id, Request $request)
    {
        // Verificar se a guia existe
        $guia = GuiaConsulta::findOrFail($id);

        // Verificar se a numeração é fornecida na requisição ou já existe na guia
        if ($request->has('numeracao')) {
            $guia->numeracao = $request->input('numeracao');
        } elseif (is_null($guia->numeracao)) {
            // Verificar se existe alguma numeração em outra guia
            $ultimaNumeracao = GuiaConsulta::whereNotNull('numeracao')->max('numeracao');

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
        // Salvar a numeração no guia
        $guia->identificador = 'GERADO';
        $guia->save();
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
        $identificacaoPrestador->addChild('ans:codigoPrestadorNaOperadora', $guia->codigo_operadora);

        $destino = $cabecalho->addChild('ans:destino');
        $destino->addChild('ans:registroANS', $guia->registro_ans);

        $cabecalho->addChild('ans:Padrao', '4.01.00'); // Alterado de 'versaoPadrao' para 'Padrao'

        // Lote de Guias
        $prestadorParaOperadora = $xml->addChild('ans:prestadorParaOperadora');
        $loteGuias = $prestadorParaOperadora->addChild('ans:loteGuias');
        $loteGuias->addChild('ans:numeroLote', $guia->numeracao);
        $guiasTISS = $loteGuias->addChild('ans:guiasTISS');

        // Guia de Consulta
        $guiaConsulta = $guiasTISS->addChild('ans:guiaConsulta');
        $cabecalhoConsulta = $guiaConsulta->addChild('ans:cabecalhoConsulta');
        $cabecalhoConsulta->addChild('ans:registroANS', $guia->registro_ans); // Mover 'registroANS' para o lugar correto no cabecalhoConsulta

        $identificacaoGuia = $cabecalhoConsulta->addChild('ans:identificacaoGuia');
        $identificacaoGuia->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_operadora);
        $cabecalhoConsulta->addChild('ans:numeroGuiaPrincipal', $guia->numero_guia_operadora);

        // Dados do Beneficiário
        $dadosBeneficiario = $guiaConsulta->addChild('ans:dadosBeneficiario');
        $dadosBeneficiario->addChild('ans:numeroCarteira', $guia->numero_carteira);
        $dadosBeneficiario->addChild('ans:validadeCarteira', $guia->validade_carteira);
        $dadosBeneficiario->addChild('ans:atendimentoRN', $guia->atendimento_rn);
        $dadosBeneficiario->addChild('ans:nomeBeneficiario', $guia->nome_beneficiario);
        $dadosBeneficiario->addChild('ans:nomeSocial', $guia->nome_social);

        // Dados do Contratado Executante
        $dadosContratadoExecutante = $guiaConsulta->addChild('ans:contratadoExecutante');
        $dadosContratadoExecutante->addChild('ans:codigoPrestadorNaOperadora', $guia->codigo_operadora);
        $dadosContratadoExecutante->addChild('ans:nomeContratado', $guia->nome_contratado);
        $dadosContratadoExecutante->addChild('ans:codigoCNES', $guia->codigo_cnes);
        $conselhoProfissional = $dadosContratadoExecutante->addChild('ans:conselhoProfissional');
        $conselhoProfissional->addChild('ans:siglaConselho', $guia->conselho_profissional);
        $conselhoProfissional->addChild('ans:numeroConselho', $guia->numero_conselho);
        $conselhoProfissional->addChild('ans:UF', $guia->uf_conselho);
        $dadosContratadoExecutante->addChild('ans:codigoCBO', $guia->codigo_cbo);

        // Dados do Atendimento
        $dadosAtendimento = $guiaConsulta->addChild('ans:dadosAtendimento');
        $dadosAtendimento->addChild('ans:tipoConsulta', $guia->tipo_consulta);
        $dadosAtendimento->addChild('ans:dataAtendimento', $guia->data_atendimento);
        $dadosAtendimento->addChild('ans:indicacaoAcidente', $guia->indicacao_acidente);
        $dadosAtendimento->addChild('ans:indicacaoCoberturaEspecial', $guia->indicacao_cobertura_especial);
        $dadosAtendimento->addChild('ans:regimeAtendimento', $guia->regime_atendimento);
        $dadosAtendimento->addChild('ans:saudeOcupacional', $guia->saude_ocupacional);
        $dadosAtendimento->addChild('ans:codigoTabela', $guia->codigo_tabela);
        $dadosAtendimento->addChild('ans:codigoProcedimento', $guia->codigo_procedimento);
        $dadosAtendimento->addChild('ans:valorProcedimento', $guia->valor_procedimento);

        // Assinaturas
        $assinatura = $guiaConsulta->addChild('ans:assinatura');
        $assinatura->addChild('ans:assinaturaProfissionalExecutante', $guia->assinatura_profissional_executante);
        $assinatura->addChild('ans:assinaturaBeneficiario', $guia->assinatura_beneficiario);

        // Observação
        $guiaConsulta->addChild('ans:observacao', !empty($guia->observacao) ? $guia->observacao : 'N/A');

        // Epílogo
        $epilogo = $xml->addChild('ans:epilogo');
        $epilogo->addChild('ans:hash', $guia->hash);

        // Verificar se já existe uma conta financeira associada
        $contaExistente = ContasFinanceiras::whereHas('contaGuias', function ($query) use ($guia) {
            $query->where('guia_id', $guia->id)->where('tipo_guia', 'Consulta');
        })->first();
        if (!$contaExistente) {
            // Criar nova conta financeira
            $conta = ContasFinanceiras::create([
                'user_id' => auth()->id(),
                'status' => 'Aberto',
                'tipo_conta' => 'Receber',
                'convenio_id' => $guia->convenio_id,
                'tipo_guia' => 'Consulta',
                'parcelas' => '1/1',
                'data_emissao' => Carbon::parse($guia->data_atendimento)->format('Y-m-d'),
                'competencia' => Carbon::parse($guia->data_atendimento)->format('Y-m-d'),
                'data_vencimento' => now()->addDays(30)->format('Y-m-d'),
                'referencia' => $guia->numeracao,
                'tipo_doc' => 'XML',
                'centro_custos' => $guia->nome_contratado ?? 'Desconhecido',
                'documento' => 'lote_guias_consulta_' . $guia->numercao . '.xml',
                'valor' => $guia->valor_procedimento ?? 0,
                'historico' => 'Guia de Consulta - ' . $guia->data_atendimento,
            ]);

            // Criar relacionamento em `conta_guias`
            ContaGuia::create([
                'conta_financeira_id' => $conta->id,
                'guia_id' => $guia->id,
                'tipo_guia' => 'Consulta',
                'lote' => $guia->numeracao,
            ]);
        }


        // Retornar o XML como download
        return response($xml->asXML(), 200)
        ->header('Content-Type', 'application/xml')
        ->header('Content-Disposition', 'attachment; filename="guia_consulta_' . $guia->id . '.xml"');
    }

    public function gerarZipGuiaConsulta($id)
    {
        $guia = GuiaConsulta::with('profissional')->findOrFail($id);
        $numSequencial = $guia->numeracao;

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><ans:mensagemTISS xmlns:ans="http://www.ans.gov.br/padroes/tiss/schemas" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.ans.gov.br/padroes/tiss/schemas http://www.ans.gov.br/padroes/tiss/schemas/tissV4_01_00.xsd"></ans:mensagemTISS>');

        // Cabeçalho
        $cabecalho = $xml->addChild('ans:cabecalho');
        $identificacaoTransacao = $cabecalho->addChild('ans:identificacaoTransacao');
        $identificacaoTransacao->addChild('ans:tipoTransacao', 'ENVIO_LOTE_GUIAS');
        $identificacaoTransacao->addChild('ans:sequencialTransacao', $numSequencial);
        $identificacaoTransacao->addChild('ans:dataRegistroTransacao', date('Y-m-d'));
        $identificacaoTransacao->addChild('ans:horaRegistroTransacao', date('H:i:s'));

        $origem = $cabecalho->addChild('ans:origem');
        $identificacaoPrestador = $origem->addChild('ans:identificacaoPrestador');
        $identificacaoPrestador->addChild('ans:codigoPrestadorNaOperadora', $guia->codigo_operadora);

        $destino = $cabecalho->addChild('ans:destino');
        $destino->addChild('ans:registroANS', $guia->registro_ans);

        $cabecalho->addChild('ans:Padrao', '4.01.00');

        // Lote de Guias
        $prestadorParaOperadora = $xml->addChild('ans:prestadorParaOperadora');
        $loteGuias = $prestadorParaOperadora->addChild('ans:loteGuias');
        $loteGuias->addChild('ans:numeroLote', $numSequencial);
        $guiasTISS = $loteGuias->addChild('ans:guiasTISS');

        // Guia de Consulta
        $guiaConsulta = $guiasTISS->addChild('ans:guiaConsulta');
        $cabecalhoConsulta = $guiaConsulta->addChild('ans:cabecalhoConsulta');
        $cabecalhoConsulta->addChild('ans:registroANS', $guia->registro_ans);
        $cabecalhoConsulta->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_operadora);

        // Dados do Beneficiário
        $dadosBeneficiario = $guiaConsulta->addChild('ans:dadosBeneficiario');
        $dadosBeneficiario->addChild('ans:numeroCarteira', $guia->numero_carteira);
        $dadosBeneficiario->addChild('ans:atendimentoRN', $guia->atendimento_rn);

        // Dados do Contratado Executante
        $dadosContratadoExecutante = $guiaConsulta->addChild('ans:contratadoExecutante');
        $dadosContratadoExecutante->addChild('ans:codigoPrestadorNaOperadora', $guia->codigo_operadora);
        $dadosContratadoExecutante->addChild('ans:CNES', $guia->codigo_cnes);

        // Profissional Executante
        $profissionalExecutante = $guiaConsulta->addChild('ans:profissionalExecutante');
        $profissionalExecutante->addChild('ans:nomeProfissional', $guia->profissional->name);
        $profissionalExecutante->addChild('ans:conselhoProfissional', $guia->conselho_profissional);
        $profissionalExecutante->addChild('ans:numeroConselhoProfissional', $guia->numero_conselho);
        $profissionalExecutante->addChild('ans:UF', $guia->uf_conselho);
        $profissionalExecutante->addChild('ans:CBOS', $guia->codigo_cbo);

        // Indicacao Acidente
        $guiaConsulta->addChild('ans:indicacaoAcidente', $guia->indicacao_acidente);

        // Dados do Atendimento
        $dadosAtendimento = $guiaConsulta->addChild('ans:dadosAtendimento');
        $dadosAtendimento->addChild('ans:regimeAtendimento', $guia->regime_atendimento);
        $dadosAtendimento->addChild('ans:dataAtendimento', $guia->data_atendimento);
        $dadosAtendimento->addChild('ans:tipoConsulta', $guia->tipo_consulta);

        // Procedimento
        $procedimento = $dadosAtendimento->addChild('ans:procedimento');
        $procedimento->addChild('ans:codigoTabela', $guia->codigo_tabela);
        $procedimento->addChild('ans:codigoProcedimento', $guia->codigo_procedimento);
        $procedimento->addChild('ans:valorProcedimento', $guia->valor_procedimento);

        // Observação
        $guiaConsulta->addChild('ans:observacao', !empty($guia->observacao) ? $guia->observacao : 'N/A');

        // Concatene os dados críticos da guia em uma string
        $dadosParaHash = $guia->numero_guia_operadora . $guia->data_atendimento . $guia->numero_carteira . $guia->nome_beneficiario;

        // Gere o hash usando o algoritmo MD5
        $hash = md5($dadosParaHash);

        // Adicione o hash ao XML
        $epilogo = $xml->addChild('ans:epilogo');
        $epilogo->addChild('ans:hash', $hash);

        $guia->identificador = 'GERADO';
        $guia->save();

        // Salvar o XML temporariamente no servidor
        $fileName = 'guia_consulta_' . $guia->id . '.xml';
        $filePath = storage_path('app/public/' . $fileName);
        $xml->asXML($filePath);

        // Criar um arquivo ZIP contendo o XML
        $zipFileName = 'guia_consulta_' . $guia->id . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        $zip = new \ZipArchive;
        if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
            $zip->addFile($filePath, $fileName);
            $zip->close();
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function verificarNumeracao(Request $request)
    {
        $guiaIds = $request->input('guia_ids');

        // Busca a primeira guia com numeração entre as IDs fornecidas
        $guiaComNumeracao = GuiaConsulta::whereIn('id', $guiaIds)
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


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuiaConsulta $guiaConsulta)
    {
        $conselhos = [
            'CRAS' => '01', 'COREN' => '02', 'CRF' => '03', 'CRFA' => '04',
            'CREFITO' => '05', 'CRM' => '06', 'CRN' => '07', 'CRO' => '08',
            'CRP' => '09', 'OUTROS' => '10'
        ];

        $ufs = [
            'AC' => '12', 'AL' => '27', 'AP' => '16', 'AM' => '13',
            'BA' => '29', 'CE' => '23', 'DF' => '53', 'ES' => '32',
            'GO' => '52', 'MA' => '21', 'MT' => '51', 'MS' => '50',
            'MG' => '31', 'PA' => '15', 'PB' => '25', 'PR' => '41',
            'PE' => '26', 'PI' => '22', 'RJ' => '33', 'RN' => '24',
            'RS' => '43', 'RO' => '11', 'RR' => '14', 'SC' => '42',
            'SP' => '35', 'SE' => '28', 'TO' => '17'
        ];

        return view('guias.consultaEditar', compact('guiaConsulta', 'conselhos', 'ufs'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateGuiaConsulta(Request $request)
    {
        // Dados de apoio
        $conselhos = [
            'CRAS' => '01', 'COREN' => '02', 'CRF' => '03', 'CRFA' => '04',
            'CREFITO' => '05', 'CRM' => '06', 'CRN' => '07', 'CRO' => '08',
            'CRP' => '09', 'OUTROS' => '10'
        ];

        $ufs = [
            'AC' => '12', 'AL' => '27', 'AP' => '16', 'AM' => '13',
            'BA' => '29', 'CE' => '23', 'DF' => '53', 'ES' => '32',
            'GO' => '52', 'MA' => '21', 'MT' => '51', 'MS' => '50',
            'MG' => '31', 'PA' => '15', 'PB' => '25', 'PR' => '41',
            'PE' => '26', 'PI' => '22', 'RJ' => '33', 'RN' => '24',
            'RS' => '43', 'RO' => '11', 'RR' => '14', 'SC' => '42',
            'SP' => '35', 'SE' => '28', 'TO' => '17'
        ];

        // Criar uma nova guia de consulta
        $novaGuia = new GuiaConsulta();

        $novaGuia->fill($request->only([
            'numero_guia_operadora',
            'registro_ans',
            'numero_carteira',
            'validade_carteira',
            'atendimento_rn',
            'nome_social',
            'nome_beneficiario',
            'codigo_operadora',
            'nome_contratado',
            'codigo_cnes',
            'nome_profissional_executante',
            'numero_conselho',
            'codigo_cbo',
            'indicacao_acidente',
            'indicacao_cobertura_especial',
            'regime_atendimento',
            'saude_ocupacional',
            'data_atendimento',
            'tipo_consulta',
            'valor_procedimento',
            'observacao',
        ]) + [
            'identificador' => 'GERADO',
            'conselho_profissional' => array_key_exists($request->input('conselho_profissional'), $conselhos)
                ? $conselhos[$request->input('conselho_profissional')]
                : $request->input('conselho_profissional'),
            'uf_conselho' => array_key_exists($request->input('uf_conselho'), $ufs)
                ? $ufs[$request->input('uf_conselho')]
                : $request->input('uf_conselho'),
        ]);

        // Determinar a numeração da guia
        $novaGuia->numeracao = GuiaConsulta::max('numeracao') + 1;

        // Salvar a nova guia
        $novaGuia->save();

        return redirect()->route('faturamentoGlosa.index')->with('success', 'Nova Guia de Consulta criada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuiaConsulta $guiaConsulta)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $guiaConsulta = GuiaConsulta::findOrFail($id);

        $conselhos = [
            'CRAS' => '01', 'COREN' => '02', 'CRF' => '03', 'CRFA' => '04',

            'CREFITO' => '05', 'CRM' => '06', 'CRN' => '07', 'CRO' => '08',
            'CRP' => '09', 'OUTROS' => '10'
        ];

        $ufs = [
            'AC' => '12', 'AL' => '27', 'AP' => '16', 'AM' => '13',
            'BA' => '29', 'CE' => '23', 'DF' => '53', 'ES' => '32',
            'GO' => '52', 'MA' => '21', 'MT' => '51', 'MS' => '50',
            'MG' => '31', 'PA' => '15', 'PB' => '25', 'PR' => '41',
            'PE' => '26', 'PI' => '22', 'RJ' => '33', 'RN' => '24',
            'RS' => '43', 'RO' => '11', 'RR' => '14', 'SC' => '42',
            'SP' => '35', 'SE' => '28', 'TO' => '17'
        ];

        $guiaConsulta->update($request->only([
            'numero_guia_operadora',
            'registro_ans',
            'numero_carteira',
            'validade_carteira',
            'atendimento_rn',
            'nome_social',
            'nome_beneficiario',
            'codigo_operadora',
            'nome_contratado',
            'codigo_cnes',
            'nome_profissional_executante',
            'numero_conselho',
            'codigo_cbo',
            'indicacao_acidente',
            'indicacao_cobertura_especial',
            'regime_atendimento',
            'saude_ocupacional',
            'data_atendimento',
            'tipo_consulta',
            'valor_procedimento',
            'observacao',
        ]) + [
            'conselho_profissional' => array_key_exists($request->input('conselho_profissional'), $conselhos)
                ? $conselhos[$request->input('conselho_profissional')]
                : $request->input('conselho_profissional'),
            'uf_conselho' => array_key_exists($request->input('uf_conselho'), $ufs)
                ? $ufs[$request->input('uf_conselho')]
                : $request->input('uf_conselho'),
        ]);

        return redirect()->route('guiaconsulta.index')->with('success', 'Guia de Consulta atualizada com sucesso!');
    }
}
