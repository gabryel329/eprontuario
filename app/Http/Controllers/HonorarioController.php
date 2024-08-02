<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\Honorario;
use App\Models\Procedimentos;
use App\Models\Profissional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HonorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $honorario = Honorario::all();
        $profissionais = Profissional::with('honorarios')->get(); // Certifique-se de carregar a relação
        $procedimentos = Procedimentos::all();
        $convenios = Convenio::all();

        return view('financeiro.honorario', compact('honorario', 'profissionais', 'procedimentos', 'convenios'));
    }


    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'codigo.*' => 'required|string',
            'procedimento_id.*' => 'required|integer|exists:procedimentos,id',
            'porcentagem.*' => 'required|numeric',
            'convenio_id.*' => 'required|integer|exists:convenios,id',
            'profissional_id.*' => 'required|integer|exists:profissionals,id',
        ]);

        // Inicializar uma variável de sucesso
        $success = true;

        // Iterar sobre os dados validados e salvar cada registro
        foreach ($validatedData['convenio_id'] as $index => $convenioId) {
            $procedimentoId = $validatedData['procedimento_id'][$index];
            $codigo = $validatedData['codigo'][$index];
            $porcentagem = $validatedData['porcentagem'][$index];
            $profissionalId = $validatedData['profissional_id'][$index];

            // Verifica se o registro já existe
            $existingRecord = Honorario::where('convenio_id', $convenioId)
                ->where('procedimento_id', $procedimentoId)
                ->first();

            if (!$existingRecord) {
                // Cria um novo registro se ele não existir
                $convenioProcedimento = new Honorario();
                $convenioProcedimento->convenio_id = $convenioId;
                $convenioProcedimento->procedimento_id = $procedimentoId;
                $convenioProcedimento->codigo = $codigo;
                $convenioProcedimento->porcentagem = $porcentagem;
                $convenioProcedimento->profissional_id = $profissionalId;
                $convenioProcedimento->save();
            }
        }

        return response()->json(['success' => $success]);
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
