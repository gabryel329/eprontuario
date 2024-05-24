<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the company with ID 1
        $empresa = Empresas::find(1);
        return view('cadastros.empresas', compact('empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // Get the company with ID 1
        $empresa = Empresas::find(1);

        if (!$empresa) {
            return redirect()->route('empresa.index')->with('error', 'Empresa não encontrada!');
        }

        return view('empresa.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Get the company with ID 1
        $empresa = Empresas::find(1);

        if (!$empresa) {
            return redirect()->back()->with('error', 'Empresa não encontrada!');
        }

        // Update the company's details
        $empresa->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'cnpj' => $request->input('cnpj'),
            'cep' => $request->input('cep'),
            'rua' => $request->input('rua'),
            'bairro' => $request->input('bairro'),
            'cidade' => $request->input('cidade'),
            'uf' => $request->input('uf'),
            'numero' => $request->input('numero'),
            'celular' => $request->input('celular'),
            'medico' => $request->input('medico'),
            'crm' => $request->input('crm'),
        ]);

        return redirect()->back()->with('success', 'Empresa atualizada com sucesso!');
    }
}