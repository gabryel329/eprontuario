<?php

namespace App\Http\Controllers;

use App\Models\Permisoes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class PermisoesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permisao = Permisoes::all();
        return view('cadastros.permisao', compact('permisao'));
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
        'cargo.max' => 'A permissão não pode ter mais que 15 caracteres!',
    ];

    // Validate the request data
    $request->validate([
        'cargo' => 'required|string|max:15',
    ], $messages);

    // Capitalize the input
    $permisao = ucfirst(trim($request->input('cargo')));

    // Check if the permission already exists
    $existePermisao = Permisoes::where('cargo', $permisao)->first();

    if ($existePermisao) {
        return redirect()->route('permisao.index')->with('error', 'Permissão já existe!');
    }

    // Create a new permission
    Permisoes::create([
        'cargo' => $permisao,
    ]);

    return redirect()->route('permisao.index')->with('success', 'Permissão cadastrada!');
}



    /**
     * Display the specified resource.
     */
    public function show(Permisoes $permisoes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permisoes $permisoes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $permisao = Permisoes::find($id);

        if (!$permisao){
            return redirect()->back()->with('error', 'Permissão não encontrada!');
        }

        // Verifica se o ID é 1 ou 2
        if (in_array($id, [1, 2])) {
            return redirect()->route('permisao.index')->with('error', 'Você não pode editar esta permissão!');
        }

        $permisao->cargo = ucfirst(trim($request->input('cargo')));

        $permisao->save();

        return redirect()->back()->with('success', 'Permissão Atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Verifica se o ID é 1 ou 2
        if (in_array($id, [1, 2])) {
            return redirect()->route('permisao.index')->with('error', 'Você não pode excluir esta permissão!');
        }
    
        $permisao = Permisoes::findOrFail($id);
    
        $permisao->delete();
    
        return redirect()->route('permisao.index')->with('success', 'Permissão excluída com sucesso!');
    }
      
}   
