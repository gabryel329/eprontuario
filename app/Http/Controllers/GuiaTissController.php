<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\GuiaTiss;
use Illuminate\Http\Request;

class GuiaTissController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retorna os convênios na carga inicial
        $convenios = Convenio::all();
        return view('financeiro.guiatiss', compact('convenios'));
    }

    public function listarGuiasPorConvenio(Request $request)
    {
        $convenio_id = $request->get('convenio_id');

        if (!$convenio_id) {
            return response()->json(['error' => 'Convênio não encontrado.'], 404);
        }

        $guiatiss = Guiatiss::where('convenio_id', $convenio_id)->get();

        return response()->json(['guias' => $guiatiss]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GuiaTiss $guiaTiss)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuiaTiss $guiaTiss)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuiaTiss $guiaTiss)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuiaTiss $guiaTiss)
    {
        //
    }
}
