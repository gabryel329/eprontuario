<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\GuiaTiss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuiaTissController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guiatiss = GuiaTiss::all();
        $convenios = Convenio::all();
        return view('financeiro.guiatiss', compact('guiatiss', 'convenios'));
    }

    public function listarGuiasPorConvenio(Request $request)
    {
        $convenio_id = $request->get('convenio_id');

        if (!$convenio_id) {
            return response()->json(['error' => 'Convênio não encontrado.'], 404);
        }

        $guiatiss = Guiatiss::where('convenio_id', $convenio_id)->get();

        return response()->json(['guias' => $guiatiss]);
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
    // Capturar todos os dados enviados
    $data = $request->all();

    $data['user_id'] = Auth::id();
    // Criar a nova entrada no banco de dados
    $guiaTiss = GuiaTiss::create($data);

    return redirect()->back()->with('success', 'Guia TISS criada com sucesso');
}



    /**
     * Display the specified resource.
     */
    public function show(GuiaTiss $guiaTiss)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuiaTiss $guiaTiss)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuiaTiss $guiaTiss)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'convenio_id' => 'required|exists:convenios,id',
            'registro_ans' => 'required|string|max:255',
            'numero_guia_prestador' => 'required|string|max:255',
            'numero_carteira' => 'required|string|max:255',
            'nome_beneficiario' => 'required|string|max:255',
            'data_atendimento' => 'required|date',
            'hora_inicio_atendimento' => 'required|date_format:H:i',
            'tipo_consulta' => 'required|string|max:255',
            'indicacao_acidente' => 'nullable|string|max:255',
            'codigo_tabela' => 'required|string|max:255',
            'codigo_procedimento' => 'required|string|max:255',
            'valor_procedimento' => 'required|numeric|min:0',
            'nome_profissional' => 'required|string|max:255',
            'sigla_conselho' => 'required|string|max:10',
            'numero_conselho' => 'required|string|max:255',
            'uf_conselho' => 'required|string|max:2',
            'cbo' => 'required|string|max:255',
            'observacao' => 'nullable|string',
            'hash' => 'nullable|string|max:255',
        ]);

        // Atualizar a guia TISS
        $guiaTiss->update($validatedData);

        return redirect()->route('guiaTiss.index')->with('success', 'Guia TISS atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuiaTiss $guiaTiss)
    {
        //
    }
}
