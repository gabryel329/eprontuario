<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use Illuminate\Http\Request;

class ConvenioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $convenios = Convenio::all();

        return view('cadastros.convenios', compact(['convenios']));
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
        $nome=$request->input('nome');
        $cnpj=$request->input('cnpj');
        $ans=$request->input('ans');
        $uf=$request->input('uf');
        $cep=$request->input('cep');
        $rua=$request->input('rua');
        $bairro=$request->input('bairro');
        $cidade=$request->input('cidade');
        $complemento=$request->input('complemento');
        $telefone=$request->input('telefone');
        $celular=$request->input('celular');
        $numero=$request->input('numero');
    
        // Check if the permission already exists
        $existeConvenio = Convenio::where('ans', $ans)->first();
    
        if ($existeConvenio) {
            return redirect()->route('convenio.index')->with('error', 'Convenio já existe!');
        }
    
        // Create a new permission
        Convenio::create([
            'nome' => $nome,
            'ans' => $ans,
            'cnpj' => $cnpj,
            'numero' => $numero,
            'celular' => $celular,
            'telefone' => $telefone,
            'rua' => $rua,
            'uf' => $uf,
            'complemento' => $complemento,
            'cep' => $cep,
            'bairro' => $bairro,
            'cidade' => $cidade,


        ]);
    
        return redirect()->route('convenio.index')->with('success', 'Especialidade cadastrada!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Convenio $convenio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Convenio $convenio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
            $convenio = Convenio::find($id);
    
            if (!$convenio){
                return redirect()->back()->with('error', 'Convenio não encontrada!');
            }
    
            $convenio->nome=$request->input('nome');
            $convenio->cnpj=$request->input('cnpj');
            $convenio->ans=$request->input('ans');
            $convenio->uf=$request->input('uf');
            $convenio->cep=$request->input('cep');
            $convenio->rua=$request->input('rua');
            $convenio->bairro=$request->input('bairro');
            $convenio->cidade=$request->input('cidade');
            $convenio->complemento=$request->input('complemento');
            $convenio->telefone=$request->input('telefone');
            $convenio->celular=$request->input('celular');
            $convenio->numero=$request->input('numero');


    
            $convenio->save();
    
            return redirect()->back()->with('success', 'Convenio Atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $convenio = Convenio::findOrFail($id);
    
        $convenio->delete();
    
        return redirect()->route('convenio.index')->with('error', 'Convenio excluída com sucesso!');
    } 
}
