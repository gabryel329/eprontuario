<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\TabConvenio;
use App\Models\Tabela;
use Illuminate\Http\Request;

class TabelaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function TabelaProcedimento (){
        
        $convenios = Convenio::skip(1)->get();
        $tabconvenios = TabConvenio::all();
        $tabelas = Tabela::all();
        return view('financeiro.tabela', compact(['tabelas','convenios','tabconvenios']));
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
        // Capitalize the input
        $nome = $request->input('nome');
        $valor = $request->input('valor');
    
        // Check if the permission already exists
        $existeTabela = Tabela::where('nome', $nome)->first();
    
        if ($existeTabela) {
            return redirect()->route('financeiro.tabela')->with('error', 'Tabela já existe!');
        }
    
        // Create a new permission
        Tabela::create([
            'nome' => $nome,
            'valor' => $valor,
        ]);
    
        return redirect()->route('financeiro.tabela')->with('success', 'Tabela cadastrada!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tabela $tabela)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tabela $tabela)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tabela = Tabela::find($id);

        if (!$tabela){
            return redirect()->back()->with('error', 'Tabela não encontrada!');
        }

        $tabela->nome = $request->input('nome');
        $tabela->valor = $request->input('valor');

        $tabela->save();

        return redirect()->back()->with('success', 'Tabela Atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tabela $id)
    {
        $tabela = Tabela::findOrFail($id);
    
        $tabela->delete();
    
        return redirect()->route('financeiro.tabela')->with('error', 'Tabela excluída com sucesso!');
    }
}
