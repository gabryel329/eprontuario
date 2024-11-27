<?php

namespace App\Http\Controllers;

use App\Models\Taxa;
use Illuminate\Http\Request;

class TaxaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taxas = Taxa::all();
        return view('cadastros.taxa', compact('taxas'));
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
        $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|string|max:255',
        ]);

        Taxa::create($request->all());

        return redirect()->back()->with('success', 'Taxa Criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $taxa = Taxa::find($id);

        if (!$taxa){
            return redirect()->back()->with('error', 'Taxa não encontrada!');
        }

        $taxa->descricao = $request->input('descricao');
        $taxa->valor = $request->input('valor');

        $taxa->save();

        return redirect()->back()->with('success', 'Taxa Atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $taxa = Taxa::findOrFail($id);
    
        $taxa->delete();
    
        return redirect()->back()->with('error', 'Taxa Excluida com sucesso!');
    } 
}
