<?php

namespace App\Http\Controllers;

use App\Models\TipoProf;
use Illuminate\Http\Request;

class TipoProfController extends Controller
{
    public function index()
    {
        $tipoprof = TipoProf::all();
        return view('cadastros.tipoprof', compact('tipoprof'));
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
        $nome = ucfirst(trim($request->input('nome')));
    
        // Check if the permission already exists
        $existeTipoProf = TipoProf::where('nome', $nome)->first();
    
        if ($existeTipoProf) {
            return redirect()->route('tipoprof.index')->with('error', 'Tipo Profissional já existe!');
        }
    
        // Create a new permission
        TipoProf::create([
            'nome' => $nome,
        ]);
    
        return redirect()->route('tipoprof.index')->with('success', 'Tipo Profissional cadastrada!');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tipoprof = TipoProf::find($id);

        if (!$tipoprof){
            return redirect()->back()->with('error', 'Tipo Profissional não encontrada!');
        }

        $tipoprof->nome = ucfirst(trim($request->input('nome')));

        $tipoprof->save();

        return redirect()->back()->with('success', 'Tipo Profissional Atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tipoprof = TipoProf::findOrFail($id);
    
        $tipoprof->delete();
    
        return redirect()->route('tipoprof.index')->with('error', 'Tipo Profissional excluída com sucesso!');
    } 
}
