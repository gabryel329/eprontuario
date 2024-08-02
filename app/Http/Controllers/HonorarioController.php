<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\Honorario;
use App\Models\Procedimentos;
use App\Models\Profissional;
use Illuminate\Http\Request;

class HonorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $honorario = Honorario::all();
        $profissioanls = Profissional::all();
        $procedimentos = Procedimentos::all();
        $convenios = Convenio::all();

        return view('financeiro.honorario', compact(['honorario', 'profissioanls', 'procedimentos', 'convenios']));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'profissional_id' => 'required|exists:profissionals,id',
        'convenio_id' => 'nullable|exists:convenios,id',
        'procedimentos' => 'required|array',
        'procedimentos.*.procedimento_id' => 'required|exists:procedimentos,id',
        'procedimentos.*.porcentagem' => 'required|string',
    ]);

    foreach ($validated['procedimentos'] as $procedimento) {
        Honorario::create([
            'profissional_id' => $validated['profissional_id'],
            'convenio_id' => $validated['convenio_id'] ?? null,
            'procedimento_id' => $procedimento['procedimento_id'],
            'porcentagem' => $procedimento['porcentagem'],
        ]);
    }

    return response()->json(['success' => true, 'message' => 'Dados salvos com sucesso!']);
}

    public function honorarios()
    {
        return $this->hasMany(Honorario::class);
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

    /**
     * Display the specified resource.
     */
    public function show(Honorario $honorario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $profissioanls = Profissional::findOrFail($id);
        $honorario = Honorario::where('profissional_id', $id)->get();
        $convenios = Convenio::all();
        $procedimentos = Procedimentos::all();

        return view('honorario.edit', compact('profissioanls', 'honorarios', 'convenios', 'procedimentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{

    // Remove existing records for this profissional
    Honorario::where('profissional_id', $id)->delete();

    // Save new records
    foreach ($request->input('procedimentos', []) as $procedimento) {
        Honorario::create([
            'profissional_id' => $id,
            'convenio_id' => 'convenio_id',
            'procedimento_id' => 'procedimento_id',
            'porcentagem' => 'porcentagem',
            'codigo' => 'codigo',
        ]);
    }

    return response()->json(['success' => true, 'message' => 'Atualizado com sucesso']);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Honorario $honorario)
    {
        //
    }
}
