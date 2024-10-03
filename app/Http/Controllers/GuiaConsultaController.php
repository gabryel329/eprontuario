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

        $paciente = Pacientes::find($agenda->paciente_id);

        $profissional = Profissional::join('tipo_profs', 'profissionals.tipoprof_id', '=', 'tipo_profs.id')
        ->select('profissionals.*', 'tipo_profs.conselho as conselho_profissional')
        ->where('profissionals.id', $agenda->profissional_id)
        ->first();

        $convenio = Convenio::find($agenda->convenio_id);
        
        $empresa = Empresas::first();

        return view('formulario.guiaconsulta', [
            'agenda' => $agenda,
            'paciente' => $paciente,
            'profissional' => $profissional,
            'convenio' => $convenio,
            'empresa' => $empresa,
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
        
        $guia = GuiaConsulta::find($id);
        $empresa = Empresas::first(); 
        $convenio = Convenio::find($guia->convenio_id);
        
        if (!$guia) {
            return redirect()->back()->with('error', 'Guia não encontrada.');
        }
        

        return view('formulario.guiaconsulta', compact('guia', 'empresa', 'convenio'));
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
