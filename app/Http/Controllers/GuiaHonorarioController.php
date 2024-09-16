<?php

namespace App\Http\Controllers;

use App\Models\GuiaHonorario;
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

        // Retornar a view com os dados
        return view('guias.guia_honorario', compact('guias'));
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
    // Validação dos campos, você pode ajustar as regras conforme necessário
    $request->validate([
        'registro_ans' => 'required|string|max:255',
        'num_guia_solicitacao_internacao' => 'required|string|max:255',
        'senha' => 'required|string|max:255',
        'num_guia_atribuido_operadora' => 'required|string|max:255',
        'numero_carteira' => 'required|string|max:255',
        'nome_social' => 'nullable|string|max:255',
        'atendimento_rn' => 'required|boolean',
        'nome' => 'required|string|max:255',
        'codigo_operadora' => 'required|string|max:255',
        'nome_hospital' => 'required|string|max:255',
        'codigo_operadora_contratado' => 'required|string|max:255',
        'nome_contratado' => 'required|string|max:255',
        'codigo_cnes' => 'required|string|max:255',
        'data_inicio_faturamento' => 'required|date',
        'data_fim_faturamento' => 'required|date',
        'data' => 'required|date',
        'hora_inicial' => 'required',
        'hora_final' => 'required',
        'tabela' => 'required|string|max:255',
        'codigo_procedimento' => 'required|string|max:255',
        'descricao' => 'required|string|max:255',
        'quantidade' => 'required|integer',
        'via' => 'required|string|max:255',
        'tecnica' => 'required|string|max:255',
        'fator_reducao' => 'required|numeric',
        'valor_unitario' => 'required|numeric',
        'valor_total' => 'required|numeric',
        'seq_ref' => 'required|string|max:255',
        'grau_part' => 'required|string|max:255',
        'codigo_operadora_profissional' => 'required|string|max:255',
        'cpf_profissional' => 'required|string|max:255',
        'nome_profissional' => 'required|string|max:255',
        'conselho' => 'required|string|max:255',
        'numero_conselho' => 'required|string|max:255',
        'uf_conselho' => 'required|string|max:2',
        'codigo_cbo' => 'required|string|max:255',
        'observacoes' => 'nullable|string',
        'valor_total_honorarios' => 'required|numeric',
        'data_emissao' => 'required|date',
        'assinatura_profissional' => 'required|string|max:255',
    ]);

    // Criar nova Guia de Honorário
    $guiaHonorario = new GuiaHonorario([
        'registro_ans' => $request->registro_ans,
        'num_guia_solicitacao_internacao' => $request->num_guia_solicitacao_internacao,
        'senha' => $request->senha,
        'num_guia_atribuido_operadora' => $request->num_guia_atribuido_operadora,
        'numero_carteira' => $request->numero_carteira,
        'nome_social' => $request->nome_social,
        'atendimento_rn' => $request->atendimento_rn,
        'nome' => $request->nome,
        'codigo_operadora' => $request->codigo_operadora,
        'nome_hospital' => $request->nome_hospital,
        'codigo_operadora_contratado' => $request->codigo_operadora_contratado,
        'nome_contratado' => $request->nome_contratado,
        'codigo_cnes' => $request->codigo_cnes,
        'data_inicio_faturamento' => $request->data_inicio_faturamento,
        'data_fim_faturamento' => $request->data_fim_faturamento,
        'data' => $request->data,
        'hora_inicial' => $request->hora_inicial,
        'hora_final' => $request->hora_final,
        'tabela' => $request->tabela,
        'codigo_procedimento' => $request->codigo_procedimento,
        'descricao' => $request->descricao,
        'quantidade' => $request->quantidade,
        'via' => $request->via,
        'tecnica' => $request->tecnica,
        'fator_reducao' => $request->fator_reducao,
        'valor_unitario' => $request->valor_unitario,
        'valor_total' => $request->valor_total,
        'seq_ref' => $request->seq_ref,
        'grau_part' => $request->grau_part,
        'codigo_operadora_profissional' => $request->codigo_operadora_profissional,
        'cpf_profissional' => $request->cpf_profissional,
        'nome_profissional' => $request->nome_profissional,
        'conselho' => $request->conselho,
        'numero_conselho' => $request->numero_conselho,
        'uf_conselho' => $request->uf_conselho,
        'codigo_cbo' => $request->codigo_cbo,
        'observacoes' => $request->observacoes,
        'valor_total_honorarios' => $request->valor_total_honorarios,
        'data_emissao' => $request->data_emissao,
        'assinatura_profissional' => $request->assinatura_profissional,
    ]);

    // Salvar a Guia de Honorário
    $guiaHonorario->save();

    // Redirecionar ou retornar uma resposta
    return redirect()->route('guia_honorario.index')->with('success', 'Guia de Honorários criada com sucesso.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuiaHonorario $guiaHonorario)
    {
        //
    }
}
