<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\ConvenioProcedimento;
use App\Models\Procedimentos;
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

    public function convenioProcedimentoIndex()
    {
        $convenios = Convenio::with('convenioProcedimentos.procedimento')->get();
        $procedimentos = Procedimentos::all();
        $convProces = ConvenioProcedimento::all();
        return view('financeiro.convenioProcedimento', compact('convenios', 'procedimentos', 'convProces'));
    }

    public function convenioProcedimentoStore(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'codigo.*' => 'required|string',
            'procedimento_id.*' => 'required|integer|exists:procedimentos,id',
            'valor.*' => 'required|numeric',
            'convenio_id.*' => 'required|integer|exists:convenios,id',
        ]);

        // Processar cada linha do formulário
        $success = true;
        foreach ($request->input('convenio_id') as $index => $convenioId) {
            $procedimentoId = $request->input('procedimento_id')[$index];
            $codigo = $request->input('codigo')[$index];
            $valor = $request->input('valor')[$index];

            // Verifica se o registro já existe
            $existingRecord = ConvenioProcedimento::where('convenio_id', $convenioId)
                ->where('procedimento_id', $procedimentoId)
                ->first();

            if ($existingRecord) {
                // Se o registro já existe, pula para o próximo
                continue;
            }

            // Cria um novo registro
            $convenioProcedimento = new ConvenioProcedimento();
            $convenioProcedimento->convenio_id = $convenioId;
            $convenioProcedimento->procedimento_id = $procedimentoId;
            $convenioProcedimento->codigo = $codigo;
            $convenioProcedimento->valor = $valor;
            
            // Salva o registro
            if (!$convenioProcedimento->save()) {
                $success = false;
            }
        }

        // Retorna uma resposta JSON
        if ($success) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Erro ao salvar dados.'], 500);
        }
    }
   
    public function convenioProcedimentoDelete(string $id)
    {
        $convProces = ConvenioProcedimento::findOrFail($id);
    
        $convProces->delete();
    
        return redirect()->back()->with('error', 'Excluída com sucesso!');
    } 

}
