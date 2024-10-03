<?php

namespace App\Http\Controllers;

use App\Models\GuiaHonorario;
use App\Models\Convenio;
use App\Models\Empresas;
use Illuminate\Http\Request;

class GuiaHonorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Buscar todos os registros
        $guias = GuiaHonorario::all();
        $convenios = Convenio::all();
        // Retornar a view com os dados
        return view('guias.guia_honorario', compact('guias', 'convenios'));
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
    try {
        $user_id = auth()->id();

        GuiaHonorario::create([
            'user_id' => $user_id,
            'convenio_id' => $request->input('convenio_id'),
            'registro_ans' => $request->input('registro_ans'),
            'numero_guia_solicitacao' => $request->input('numero_guia_solicitacao'),
            'numero_guia_prestador' => $request->input('numero_guia_prestador'),
            'senha' => $request->input('senha'),
            'numero_guia_operadora' => $request->input('numero_guia_operadora'),
            'numero_carteira' => $request->input('numero_carteira'),
            'nome_social' => $request->input('nome_social'),
            'atendimento_rn' => $request->input('atendimento_rn', false), // booleano
            'nome_beneficiario' => $request->input('nome_beneficiario'),
            'codigo_operadora_contratado' => $request->input('codigo_operadora_contratado'),
            'nome_hospital_local' => $request->input('nome_hospital_local'),
            'codigo_cnes_contratado' => $request->input('codigo_cnes_contratado'),
            'nome_contratado' => $request->input('nome_contratado'),
            'codigo_operadora_executante' => $request->input('codigo_operadora_executante'),
            'codigo_cnes_executante' => $request->input('codigo_cnes_executante'),
            'data_inicio_faturamento' => $request->input('data_inicio_faturamento'),
            'data_fim_faturamento' => $request->input('data_fim_faturamento'),
            'observacoes' => $request->input('observacoes'),
            'valor_total_honorarios' => $request->input('valor_total_honorarios'),
            'data_emissao' => $request->input('data_emissao'),
            'assinatura_profissional_executante' => $request->input('assinatura_profissional_executante'),
        ]);

        return redirect()->back()->with('success', 'Guia de Honorário criada com sucesso!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erro ao criar a guia: ' . $e->getMessage());
    }
}

    public function impressaoGuia($id)
    {
        
        $guia = GuiaHonorario::find($id);
        $empresa = Empresas::first(); 
        $convenio = Convenio::find($guia->convenio_id);
        
        if (!$guia) {
            return redirect()->back()->with('error', 'Guia não encontrada.');
        }
        

        return view('formulario.guiahonorario', compact('guia', 'empresa', 'convenio'));
    }


    public function listarGuiasHonorario(Request $request)
    {
        $convenio_id = $request->get('convenio_id');

        if (!$convenio_id) {
            return response()->json(['error' => 'Convênio não encontrado.'], 404);
        }

        $guiaHonorario = GuiaHonorario::where('convenio_id', $convenio_id)->get();

        return response()->json(['guias' => $guiaHonorario]);
    }

    public function visualizarHonorario($id)
    {
        $guia = GuiaHonorario::find($id);
        if ($guia) {
            return response()->json($guia);
        } else {
            return response()->json(['error' => 'Guia não encontrada.'], 404);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(GuiaHonorario $guiaHonorario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuiaHonorario $guiaHonorario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuiaHonorario $guiaHonorario)
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
        $guiaHonorario->update($validatedData);

        return redirect()->back()->with('success', 'Guia TISS atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuiaHonorario $guiaHonorario)
    {
        //
    }
}
