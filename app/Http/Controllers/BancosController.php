<?php

namespace App\Http\Controllers;

use App\Models\Bancos;
use Illuminate\Http\Request;

class BancosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bancos = Bancos::all();
        return view('financeiro.bancos', compact('bancos'));
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
        Bancos::create($request->all());

        return redirect()->back()->with('sucess', 'Banco cadastrado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bancos $bancos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bancos $bancos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banco = Bancos::findOrFail($id);
        $banco->update($request->all());

        return redirect()->back()->with('sucess', 'Banco atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banco = Bancos::findOrFail($id);
        $banco->delete();

        return redirect()->back()->with('sucess', 'Banco excluído com sucesso');
    }
}
