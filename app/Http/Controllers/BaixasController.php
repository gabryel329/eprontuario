<?php

namespace App\Http\Controllers;

use App\Models\Baixas;
use App\Models\Bancos;
use App\Models\ContaGuia;
use App\Models\ContasFinanceiras;
use App\Models\Convenio;
use App\Models\GuiaConsulta;
use App\Models\GuiaSp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BaixasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $baixa = Baixas::all();
    //     $convenios = Convenio::all();
    //     $guiaConsulta = GuiaConsulta::all();
    //     $guiasp = GuiaSp::all();
    //     $bancos = Bancos::all();
    //     return view('guias.faturamentoBaixas', compact('baixa', 'convenios', 'guiaConsulta', 'guiasp', 'bancos'));
    // }

    public function indexGlosa()
    {
        $baixa = Baixas::all();
        $convenios = Convenio::all();
        $guiaConsulta = GuiaConsulta::all();
        $guiasp = GuiaSp::all();
        $bancos = Bancos::all();
        $contas = ContasFinanceiras::whereNotNull('tipo_guia')
        ->where('status', 'Parcial/Glosa')
        ->with('contaGuias') // Carregar o relacionamento
        ->get();
        return view('guias.faturamentoGlosa', compact('baixa', 'convenios', 'guiaConsulta', 'guiasp', 'bancos', 'contas'));
    }

    public function filtrarConsulta(Request $request)
    {
        $query = GuiaConsulta::query();

        if ($request->convenio_id) {
            $query->where('convenio_id', $request->convenio_id);
        }
        if ($request->nome_paciente) {
            $query->where('nome_beneficiario', 'like', '%' . $request->nome_paciente . '%');
        }
        if ($request->numero_lote) {
            $query->where('numeracao', $request->numero_lote);
        }

        $guias = $query->get();

        return response()->json($guias);
    }

    public function filtrarSadt(Request $request)
    {
        $query = GuiaSp::query();

        if ($request->convenio_id) {
            $query->where('convenio_id', $request->convenio_id);
        }
        if ($request->nome_paciente) {
            $query->where('nome_beneficiario', 'like', '%' . $request->nome_paciente . '%');
        }
        if ($request->numero_lote) {
            $query->where('numero_lote', $request->numero_lote);
        }

        $guias = $query->get();

        return response()->json($guias);
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
    public function storeBaixa(Request $request, $id)
{
    $conta = ContasFinanceiras::findOrFail($id);

    // Determinar o valor pago
    $valorPago = $request->input('tipo_pagamento') === 'Total'
        ? $conta->valor
        : $request->input('valor_pagamento');

    // Verificar se já existe uma baixa para esta conta financeira
    $baixaExistente = Baixas::where('conta_financeira_id', $conta->id)->first();

    if ($baixaExistente) {
        // Atualizar a baixa existente
        $baixaExistente->update([
            'user_id' => auth()->id(),
            'tipo_pagamento' => $request->input('tipo_pagamento'),
            'valor_pagamento' => $valorPago,
            'banco_id' => $request->input('banco_id'),
            'forma_pagamento' => $request->input('forma_pagamento'),
            'numero_documento' => $request->input('numero_documento'),
            'observacao' => $request->input('observacao'),
        ]);
    } else {
        // Criar uma nova baixa
        Baixas::create([
            'conta_financeira_id' => $conta->id,
            'user_id' => auth()->id(),
            'tipo_pagamento' => $request->input('tipo_pagamento'),
            'valor_pagamento' => $valorPago,
            'banco_id' => $request->input('banco_id'),
            'forma_pagamento' => $request->input('forma_pagamento'),
            'numero_documento' => $request->input('numero_documento'),
            'observacao' => $request->input('observacao'),
        ]);
    }

    // Verificar se o pagamento foi parcial
    if ($request->input('tipo_pagamento') === 'Parcial') {
        // Atualizar a conta original com o status "Parcial/Glosa" e manter o valor total pago no campo `total`
        $conta->update([
            'total' => $valorPago, // Atualiza o total com o valor pago
            'status' => 'Parcial/Glosa',
        ]);
    } else {
        // Atualizar a conta original como "Pago" se o pagamento for total
        $conta->update([
            'total' => $valorPago,
            'status' => 'Pago',
        ]);
    }

    return redirect()->back()->with('success', 'Baixa registrada com sucesso!');
}


public function buscarGuiasPorConta($contaId)
{
    Log::info("Buscando guias para conta financeira ID: $contaId");

    $contasGuias = ContaGuia::where('conta_financeira_id', $contaId)->get('valor');

    Log::info("Registros encontrados em contas_guias: ", $contasGuias->toArray());

    if ($contasGuias->isEmpty()) {
        Log::warning("Nenhuma guia encontrada para a conta financeira ID: $contaId");
        return response()->json([], 200);
    }

    $guias = $contasGuias->map(function ($contaGuia) {
        $guia = null;

        if ($contaGuia->tipo_guia === 'Consulta') {
            $guia = GuiaConsulta::find($contaGuia->guia_id);
        } elseif ($contaGuia->tipo_guia === 'SADT') {
            $guia = GuiaSp::find($contaGuia->guia_id);
        }

        if ($guia) {
            return array_merge(
                $guia->toArray(),
                [
                    'tipo_guia' => $contaGuia->tipo_guia,
                    'guia_id' => $contaGuia->guia_id
                ]
            );
        }

        Log::warning("Tipo de guia inválido ou guia não encontrada: " . $contaGuia->tipo_guia);
        return null;
    })->filter();

    return response()->json($guias, 200);
}



    /**
     * Display the specified resource.
     */
    public function show(Baixas $baixas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Baixas $baixas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Baixas $baixas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Baixas $baixas)
    {
        //
    }
}
