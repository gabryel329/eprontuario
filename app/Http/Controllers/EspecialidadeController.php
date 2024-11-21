<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Permisoes;
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
        // Custom validation messages
        $messages = [
            'especialidade.max' => 'A especialidade não pode ter mais que 20 caracteres!',
        ];
    
        // Validate the request data
        $request->validate([
            'especialidade' => 'required|string|max:20',
            'conselho' => 'required|string|max:20',
        ], $messages);
    
        // Capitalize the input
        $especialidade = ucfirst(trim($request->input('especialidade')));
        $conselho = ucfirst(trim($request->input('conselho')));
    
        // Check if the permission already exists
        $existeEspecialidade = Especialidade::where('especialidade', $especialidade)->first();
    
        if ($existeEspecialidade) {
            return redirect()->route('especialidade.index')->with('error', 'Especialidade já existe!');
        }
    
        // Create a new permission
        Especialidade::create([
            'especialidade' => $especialidade,
            'conselho' => $conselho,
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
    // Busca a especialidade pelo ID
    $especialidade = Especialidade::find($id);

    // Verifica se a especialidade foi encontrada
    if (!$especialidade) {
        return redirect()->back()->with('error', 'Especialidade não encontrada!');
    }

    // Atualiza o campo 'especialidade' com a nova entrada
    $especialidade->especialidade = ucfirst(trim($request->input('especialidade')));
    $especialidade->conselho = strtoupper(trim($request->input('conselho')));

    // // Busca o conselho relacionado, se aplicável (substitua o modelo correto para Conselho)
    // $conselho = Especialidade::find($request->input('conselho_id')); 

    // if ($conselho) {
    //     // Atualiza o campo 'conselho' com a nova entrada
    //     $conselho->conselho = ucfirst(trim($request->input('conselho')));
    //     $conselho->save(); // Salva as alterações no conselho
    // }

    // Salva as alterações na especialidade
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
