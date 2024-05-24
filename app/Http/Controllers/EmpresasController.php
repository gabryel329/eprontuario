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
        $empresa = Empresas::all();

        return view('cadastros.empresas', compact(['empresa']));
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
        $nome = ucfirst($request->input('name'));

        // Get the other inputs
        $email = $request->input('email');
        $cnpj = $request->input('cnpj');    
        $cep = $request->input('cep');
        $rua = $request->input('rua');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');
        $celular = $request->input('celular');

        // Check if the user already exists
        $existeEmpresa = Empresas::where('cnpj', $cnpj)->first();

        if ($existeEmpresa) {
            return redirect()->route('empresa.index')->with('error', 'Empresa já existente!');
        } 

        // Create a new user
            Empresas::create([
                'name' => $nome,
                'email' => $email,
                'cnpj' => $cnpj,
                'cep' => $cep,
                'rua' => $rua,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'uf' => $uf,
                'numero' => $numero,
                'complemento' => $complemento,
                'celular' => $celular,
            ]);

        return redirect()->route('empresa.index')->with('success', 'Empresa cadastrada com Sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the user by ID
        $empresa = Empresas::find($id);

        if (!$empresa) {
            return redirect()->route('empresa.index')->with('error', 'Empresa não encontrada!');
        }

        // Return the view with the user data
        return view('empresa.show', compact('empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresas $empresas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Encontrar o paciente pelo ID
        $empresa = Empresas::findOrFail($id);
    
        // Capitalizar os campos de nome e sobrenome
        $nome = ucfirst($request->input('name'));
    
        // Atualizar os campos do paciente
        $empresa->update([
            'name' => $nome,
            'email' => $request->input('email'),
            'cnpj' => $request->input('cnpj'),
            'cep' => $request->input('cep'),
            'rua' => $request->input('rua'),
            'bairro' => $request->input('bairro'),
            'cidade' => $request->input('cidade'),
            'uf' => $request->input('uf'),
            'numero' => $request->input('numero'),
            'celular' => $request->input('celular'),
        ]);
    
        return redirect()->route('empresa.index')->with('success', 'Empresa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the user by ID
        $empresa = Empresas::find($id);

        if (!$empresa) {
            return redirect()->route('empresa.index')->with('error', 'Empresa não encontrada!');
        }

        // Delete the user
        $empresa->delete();

        return redirect()->route('empresa.index')->with('success', 'Empresa excluída com Sucesso!');
    }
}
