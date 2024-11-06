<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Convenio;
use App\Models\Empresas;
use App\Models\GuiaConsulta;
use App\Models\GuiaTiss;
use App\Models\Pacientes;
use App\Models\Profissional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuiaConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guiaConsulta = GuiaConsulta::all();
        $convenios = Convenio::all();
        return view('guias.guia_consulta', compact('guiaConsulta', 'convenios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function listarGuiasConsulta(Request $request)
    {
        $convenio_id = $request->get('convenio_id');

        if (!$convenio_id) {
            return response()->json(['error' => 'Convênio não encontrado.'], 404);
        }

        $guiaConsulta = GuiaConsulta::where('convenio_id', $convenio_id)->get();

        return response()->json(['guias' => $guiaConsulta]);
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
        // Verifica se já existe uma guia para o mesmo agenda_id
        $guiaExistente = GuiaConsulta::where('agenda_id', $request->input('agenda_id'))->exists();

        if ($guiaExistente) {
            // Se já existe, retorna uma mensagem de sucesso sem salvar uma nova guia
            return response()->json([
                'success' => true,
                'message' => 'Guia Consulta já existente.'
            ]);
        }

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
        $guia->codigo_cnes = $request->input('codigo_cnes');
        $guia->nome_profissional_executante = $request->input('nome_profissional_executante');
        $guia->conselho_profissional = $request->input('conselho_profissional');
        $guia->numero_conselho = $request->input('numero_conselho');
        $guia->uf_conselho = $request->input('uf_conselho');
        $guia->codigo_cbo = $request->input('codigo_cbo');
        $guia->indicacao_acidente = $request->input('indicacao_acidente');
        $guia->indicacao_cobertura_especial = $request->input('indicacao_cobertura_especial');
        $guia->regime_atendimento = $request->input('regime_atendimento');
        $guia->saude_ocupacional = $request->input('saude_ocupacional');
        $guia->data_atendimento = $request->input('data_atendimento');
        $guia->tipo_consulta = $request->input('tipo_consulta');
        $guia->codigo_tabela = $request->input('codigo_tabela');
        $guia->codigo_procedimento = $request->input('codigo_procedimento');
        $guia->valor_procedimento = $request->input('valor_procedimento');
        $guia->observacao = $request->input('observacao');

        // Salva a nova guia no banco de dados
        $guia->save();

        // Retorna uma resposta de sucesso após salvar
        return response()->json([
            'success' => true,
            'message' => 'Guia Consulta criada no sucesso!.'
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()->id();

        $convenio_id = $request->input('convenio_id');
        $registro_ans = $request->input('registro_ans');
        $numero_guia_prestador = $request->input('numero_guia_prestador');
        $numero_carteira = $request->input('numero_carteira');
        $nome_beneficiario = $request->input('nome_beneficiario');
        $data_atendimento = $request->input('data_atendimento');
        $hora_inicio_atendimento = $request->input('hora_inicio_atendimento');
        $tipo_consulta = $request->input('tipo_consulta');
        $indicacao_acidente = $request->input('indicacao_acidente');
        $codigo_tabela = $request->input('codigo_tabela');
        $codigo_procedimento = $request->input('codigo_procedimento');
        $valor_procedimento = $request->input('valor_procedimento');
        $nome_profissional = $request->input('nome_profissional');
        $sigla_conselho = $request->input('sigla_conselho');
        $numero_conselho = $request->input('numero_conselho');
        $uf_conselho = $request->input('uf_conselho');
        $cbo = $request->input('cbo');
        $observacao = $request->input('observacao');
        $hash = $request->input('hash');


        $guiaConsulta = GuiaConsulta::create([
            'user_id' => $user_id,
            'convenio_id' => $convenio_id,
            'registro_ans' => $registro_ans,
            'numero_guia_prestador' => $numero_guia_prestador,
            'numero_carteira' => $numero_carteira,
            'nome_beneficiario' => $nome_beneficiario,
            'data_atendimento' => $data_atendimento,
            'hora_inicio_atendimento' => $hora_inicio_atendimento,
            'tipo_consulta' => $tipo_consulta,
            'indicacao_acidente' => $indicacao_acidente,
            'codigo_tabela' => $codigo_tabela,
            'codigo_procedimento' => $codigo_procedimento,
            'valor_procedimento' => $valor_procedimento,
            'nome_profissional' => $nome_profissional,
            'sigla_conselho' => $sigla_conselho,
            'numero_conselho' => $numero_conselho,
            'uf_conselho' => $uf_conselho,
            'cbo' => $cbo,
            'observacao' => $observacao,
            'hash' => $hash,
        ]);

        return redirect()->back()->with('success', 'Guia TISS criada com sucesso')->with('guiaTiss', $guiaConsulta);
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

    public function gerarXmlGuiaConsulta($id)
    {
        // Buscar a guia pelo ID
        $guia = GuiaConsulta::findOrFail($id);

        // Criar o XML utilizando SimpleXMLElement
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><ans:mensagemTISS xmlns:ans="http://www.ans.gov.br/padroes/tiss/schemas" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.ans.gov.br/padroes/tiss/schemas tissV4_01_00.xsd"></ans:mensagemTISS>');

        // Cabeçalho
        $cabecalho = $xml->addChild('ans:cabecalho');
        $identificacaoTransacao = $cabecalho->addChild('ans:identificacaoTransacao');
        $identificacaoTransacao->addChild('ans:tipoTransacao', 'ENVIO_LOTE_GUIAS');
        $identificacaoTransacao->addChild('ans:sequencialTransacao', '4131');
        $identificacaoTransacao->addChild('ans:dataRegistroTransacao', date('Y-m-d'));
        $identificacaoTransacao->addChild('ans:horaRegistroTransacao', date('H:i:s'));

        $origem = $cabecalho->addChild('ans:origem');
        $identificacaoPrestador = $origem->addChild('ans:identificacaoPrestador');
        $identificacaoPrestador->addChild('ans:codigoPrestadorNaOperadora', $guia->codigo_operadora);

        $destino = $cabecalho->addChild('ans:destino');
        $destino->addChild('ans:registroANS', $guia->registro_ans);

        $cabecalho->addChild('ans:versaoPadrao', '4.01.00');

        // Lote de Guias
        $prestadorParaOperadora = $xml->addChild('ans:prestadorParaOperadora');
        $loteGuias = $prestadorParaOperadora->addChild('ans:loteGuias');
        $loteGuias->addChild('ans:numeroLote', '4131');
        $guiasTISS = $loteGuias->addChild('ans:guiasTISS');

        // Guia de Consulta
        $guiaConsulta = $guiasTISS->addChild('ans:guiaConsulta');
        $cabecalhoConsulta = $guiaConsulta->addChild('ans:cabecalhoConsulta');
        $identificacaoGuia = $cabecalhoConsulta->addChild('ans:identificacaoGuia');
        $identificacaoGuia->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_operadora);
        $cabecalhoConsulta->addChild('ans:numeroGuiaPrincipal', $guia->numero_guia_operadora);

        // Dados do Beneficiário
        $dadosBeneficiario = $guiaConsulta->addChild('ans:dadosBeneficiario');
        $dadosBeneficiario->addChild('ans:numeroCarteira', $guia->numero_carteira);
        $dadosBeneficiario->addChild('ans:nomeBeneficiario', $guia->nome_beneficiario);
        $dadosBeneficiario->addChild('ans:atendimentoRN', $guia->atendimento_rn);

        // Dados do Contratado Executante
        $dadosContratadoExecutante = $guiaConsulta->addChild('ans:dadosContratadoExecutante');
        $dadosContratadoExecutante->addChild('ans:codigoPrestadorNaOperadora', $guia->codigo_operadora);
        $dadosContratadoExecutante->addChild('ans:nomeContratado', $guia->nome_contratado);
        $conselhoProfissional = $dadosContratadoExecutante->addChild('ans:conselhoProfissional');
        $conselhoProfissional->addChild('ans:siglaConselho', $guia->conselho_profissional); // Ex: CRM
        $conselhoProfissional->addChild('ans:numeroConselho', $guia->numero_conselho);
        $conselhoProfissional->addChild('ans:UF', $guia->uf_conselho);

        // Dados do Atendimento
        $dadosAtendimento = $guiaConsulta->addChild('ans:dadosAtendimento');
        $dadosAtendimento->addChild('ans:tipoConsulta', $guia->tipo_consulta); // Ex: 1 (Consulta de rotina)
        $dadosAtendimento->addChild('ans:dataAtendimento', $guia->data_atendimento);

        // Epílogo
        $epilogo = $xml->addChild('ans:epilogo');
        $epilogo->addChild('ans:hash', $guia->hash); // Utiliza o hash do banco de dados

        // Retornar o XML como download
        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="guia_consulta_' . $guia->id . '.xml"');
    }

    public function gerarZipGuiaConsulta($id)
    {
        // Buscar a guia pelo ID
        $guia = GuiaConsulta::findOrFail($id);

        // Criar o XML utilizando SimpleXMLElement
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><ans:mensagemTISS xmlns:ans="http://www.ans.gov.br/padroes/tiss/schemas" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.ans.gov.br/padroes/tiss/schemas tissV4_01_00.xsd"></ans:mensagemTISS>');

        // Cabeçalho
        $cabecalho = $xml->addChild('ans:cabecalho');
        $identificacaoTransacao = $cabecalho->addChild('ans:identificacaoTransacao');
        $identificacaoTransacao->addChild('ans:tipoTransacao', 'ENVIO_LOTE_GUIAS');
        $identificacaoTransacao->addChild('ans:sequencialTransacao', '0000000001');
        $identificacaoTransacao->addChild('ans:dataRegistroTransacao', date('Y-m-d'));
        $identificacaoTransacao->addChild('ans:horaRegistroTransacao', date('H:i:s'));

        $origem = $cabecalho->addChild('ans:origem');
        $identificacaoPrestador = $origem->addChild('ans:identificacaoPrestador');
        $identificacaoPrestador->addChild('ans:codigoPrestadorNaOperadora', $guia->codigo_operadora);

        $destino = $cabecalho->addChild('ans:destino');
        $destino->addChild('ans:registroANS', $guia->registro_ans);

        $cabecalho->addChild('ans:versaoPadrao', '4.01.00');

        // Lote de Guias
        $prestadorParaOperadora = $xml->addChild('ans:prestadorParaOperadora');
        $loteGuias = $prestadorParaOperadora->addChild('ans:loteGuias');
        $loteGuias->addChild('ans:numeroLote', '0001');
        $guiasTISS = $loteGuias->addChild('ans:guiasTISS');

        // Guia de Consulta
        $guiaConsulta = $guiasTISS->addChild('ans:guiaConsulta');
        $cabecalhoConsulta = $guiaConsulta->addChild('ans:cabecalhoConsulta');
        $identificacaoGuia = $cabecalhoConsulta->addChild('ans:identificacaoGuia');
        $identificacaoGuia->addChild('ans:numeroGuiaPrestador', $guia->numero_guia_operadora);
        $cabecalhoConsulta->addChild('ans:numeroGuiaPrincipal', $guia->numero_guia_operadora);

        // Dados do Beneficiário
        $dadosBeneficiario = $guiaConsulta->addChild('ans:dadosBeneficiario');
        $dadosBeneficiario->addChild('ans:numeroCarteira', $guia->numero_carteira);
        $dadosBeneficiario->addChild('ans:nomeBeneficiario', $guia->nome_beneficiario);
        $dadosBeneficiario->addChild('ans:atendimentoRN', $guia->atendimento_rn);

        // Dados do Contratado Executante
        $dadosContratadoExecutante = $guiaConsulta->addChild('ans:dadosContratadoExecutante');
        $dadosContratadoExecutante->addChild('ans:codigoPrestadorNaOperadora', $guia->codigo_operadora);
        $dadosContratadoExecutante->addChild('ans:nomeContratado', $guia->nome_contratado);
        $conselhoProfissional = $dadosContratadoExecutante->addChild('ans:conselhoProfissional');
        $conselhoProfissional->addChild('ans:siglaConselho', $guia->conselho_profissional); // Ex: CRM
        $conselhoProfissional->addChild('ans:numeroConselho', $guia->numero_conselho);
        $conselhoProfissional->addChild('ans:UF', $guia->uf_conselho);

        // Dados do Atendimento
        $dadosAtendimento = $guiaConsulta->addChild('ans:dadosAtendimento');
        $dadosAtendimento->addChild('ans:tipoConsulta', $guia->tipo_consulta); // Ex: 1 (Consulta de rotina)
        $dadosAtendimento->addChild('ans:dataAtendimento', $guia->data_atendimento);

        // Epílogo
        $epilogo = $xml->addChild('ans:epilogo');
        $epilogo->addChild('ans:hash', $guia->hash); // Utiliza o hash do banco de dados

        // Salvar o XML temporariamente no servidor
        $fileName = 'guia_consulta_' . $guia->id . '.xml';
        $filePath = storage_path('app/public/' . $fileName);
        $xml->asXML($filePath);

        // Criar um arquivo ZIP contendo o XML
        $zipFileName = 'guia_consulta_' . $guia->id . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        $zip = new \ZipArchive;
        if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
            $zip->addFile($filePath, $fileName);  // Adiciona o XML ao ZIP
            $zip->close();
        }

        // Retornar o arquivo ZIP como download
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuiaConsulta $guiaConsulta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuiaConsulta $guiaConsulta)
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
            'numero_conselho' => 'required|string|max:255',
            'uf_conselho' => 'required|string|max:2',
            'cbo' => 'required|string|max:255',
            'observacao' => 'nullable|string',
            'hash' => 'nullable|string|max:255',
        ]);

        // Atualizar a guia TISS
        $guiaConsulta->update($validatedData);

        return redirect()->back()->with('success', 'Guia Consulta atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuiaConsulta $guiaConsulta)
    {
        //
    }
}
