<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $especialidade = Especialidade::all();
        return view('cadastros.especialidade', compact('especialidade'));
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
            // Validate the request data
            $request->validate([
                'especialidade' => 'required|string|max:30',
            ]);
        
            // Capitalize the input
            $especialidade = ucfirst($request->input('especialidade'));
        
            // Check if the permission already exists
            $existeEspecialidade = Especialidade::where('especialidade', $especialidade)->first();
        
            if ($existeEspecialidade) {
                return redirect()->route('especialidade.index')->with('error', 'Especialidade já existe!');
            } 
        
            // Create a new permission
            Especialidade::create([
                'especialidade' => $especialidade,
            ]);
        
            return redirect()->route('especialidade.index')->with('success', 'Especialidade cadastrada!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Especialidade $especialidade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Especialidade $especialidade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
            $especialidade = Especialidade::find($id);
    
            if (!$especialidade){
                return redirect()->back()->with('error', 'Especialidade não encontrada!');
            }
    
            $especialidade->especialidade=ucfirst($request->input('especialidade'));
    
            $especialidade->save();
    
            return redirect()->back()->with('success', 'Especialidade Atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $especialidade = Especialidade::findOrFail($id);
    
        $especialidade->delete();
    
        return redirect()->route('especialidade.index')->with('error', 'Especialidade excluída com sucesso!');
    } 
}