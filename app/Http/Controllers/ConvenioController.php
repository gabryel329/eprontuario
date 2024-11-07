<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\ConvenioProcedimento;
use App\Models\Procedimentos;
use App\Models\Tabela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConvenioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $convenios = Convenio::all();
        $procedimentos = DB::select("
            SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = 'public' 
            AND (
                table_name LIKE 'tab_amb%' OR
                table_name LIKE 'tab_cbhpm%'
            );
        ");

        $materiais = DB::select("
            SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = 'public' 
            AND (
                table_name LIKE 'tab_simpro%'
            );
        ");

        $medicamentos = DB::select("
            SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = 'public' 
            AND (
                table_name LIKE 'tab_simpro%' OR
                table_name LIKE 'tab_brasindice%'
            );
        ");

        $portes = DB::select("
            SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = 'public' 
            AND (
                table_name LIKE 'porte_%'
            );
        ");

        return view('cadastros.convenios', compact(['convenios', 'portes', 'medicamentos', 'materiais', 'procedimentos']));
    }

    public function index1()
    {
        $convenios = Convenio::all();

        return view('cadastros.listaconvenio', compact(['convenios']));
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
        $data = $request->only([
            'nome',
            'cnpj',
            'ans',
            'cep',
            'rua',
            'bairro',
            'cidade',
            'uf',
            'numero',
            'complemento',
            'telefone',
            'celular',
            'operadora',
            'multa',
            'jutos',
            'dias_desc',
            'desconto',
            'agfaturamento',
            'pagamento',
            'impmedico',
            'inss',
            'iss',
            'ir',
            'pis',
            'cofins',
            'csl',
            'tab_cota_id',
            'tab_taxa_id',
            'tab_mat_id',
            'tab_med_id',
            'tab_proc_id',
            'tab_cota_porte',
            'tab_cota_ch'
        ]);

        $existeConvenio = Convenio::where('ans', $data['ans'])->first();

        if ($existeConvenio) {
            return redirect()->route('convenio.index')->with('error', 'Convênio já existe!');
        }
        Convenio::create($data);
        return redirect()->route('convenio.index')->with('success', 'Convênio cadastrado com sucesso!');
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
    public function edit($id)
    {
        $convenios = Convenio::findOrFail($id);
        $procedimentos = DB::select("
            SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = 'public' 
            AND (
                table_name LIKE 'tab_amb%' OR
                table_name LIKE 'tab_cbhpm%'
            );
        ");

        $materiais = DB::select("
            SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = 'public' 
            AND (
                table_name LIKE 'tab_simpro%'
            );
        ");

        $medicamentos = DB::select("
            SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = 'public' 
            AND (
                table_name LIKE 'tab_simpro%' OR
                table_name LIKE 'tab_brasindice%'
            );
        ");

        $portes = DB::select("
            SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = 'public' 
            AND (
                table_name LIKE 'porte_%'
            );
        ");
        return view('cadastros.editconvenios', compact(['convenios', 'procedimentos', 'materiais', 'medicamentos', 'portes']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Busca o convênio pelo ID
        $convenio = Convenio::find($id);

        if (!$convenio) {
            return redirect()->back()->with('error', 'Convênio não encontrado!');
        }

        // Pega apenas os campos enviados no request
        $data = $request->only([
            'nome',
            'cnpj',
            'ans',
            'cep',
            'rua',
            'bairro',
            'cidade',
            'uf',
            'numero',
            'complemento',
            'telefone',
            'celular',
            'operadora',
            'multa',
            'jutos',
            'dias_desc',
            'desconto',
            'agfaturamento',
            'pagamento',
            'impmedico',
            'inss',
            'iss',
            'ir',
            'pis',
            'cofins',
            'csl',
            'tab_cota_id',
            'tab_taxa_id',
            'tab_mat_id',
            'tab_med_id',
            'tab_proc_id',
            'tab_cota_porte',
            'tab_cota_ch'
        ]);

        // Atualiza o convênio com os novos dados
        $convenio->update($data);

        return redirect()->back()->with('success', 'Convênio atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $convenio = Convenio::findOrFail($id);

        $convenio->delete();

        return redirect()->back()->with('sucess', 'Convenio excluido com sucesso!');
    }

    public function convenioProcedimentoIndex()
    {
        $convenios = Convenio::with('convenioProcedimentos.procedimento')->skip(1)->get();

        $procedimentos = Procedimentos::all();
        $convProces = ConvenioProcedimento::all();
        return view('financeiro.convenioProcedimento', compact('convenios', 'procedimentos', 'convProces'));
    }

    public function convenioProcedimentoStore(Request $request)
    {
        $success = true;
        $convenioIdList = $request->input('convenio_id');

        foreach ($convenioIdList as $index => $convenioId) {
            $procedimentoId = $request->input('procedimento_id')[$index];
            $codigo = $request->input('codigo')[$index];
            $valor = $request->input('valor')[$index];
            $operador = $request->input('operador')[$index];
            if (empty($procedimentoId)) {
                // Skip if procedimento_id is null or empty
                continue;
            }

            $existingRecord = ConvenioProcedimento::where('convenio_id', $convenioId)
                ->where('procedimento_id', $procedimentoId)
                ->first();

            if ($existingRecord) {
                // Update existing record if necessary
                $updateNeeded = false;
                if ($existingRecord->codigo != $codigo) {
                    $existingRecord->codigo = $codigo;
                    $updateNeeded = true;
                }
                if ($existingRecord->valor != $valor) {
                    $existingRecord->valor = $valor;
                    $updateNeeded = true;
                }

                if ($updateNeeded) {
                    if (!$existingRecord->save()) {
                        $success = false;
                    }
                }
            } else {
                // Create a new record if it doesn't exist
                $convenioProcedimento = new ConvenioProcedimento();
                $convenioProcedimento->convenio_id = $convenioId;
                $convenioProcedimento->procedimento_id = $procedimentoId;
                $convenioProcedimento->codigo = $codigo;
                $convenioProcedimento->valor = $valor;
                $convenioProcedimento->operador = $operador;
                if (!$convenioProcedimento->save()) {
                    $success = false;
                }
            }
        }

        if ($success) {
            // Redirect with a success message
            return redirect()->back()->with('success', 'Dados salvos com sucesso!');
        } else {
            // Redirect with an error message
            return redirect()->back()->with('error', 'Erro ao salvar dados.');
        }
    }


    public function convenioProcedimentoDelete(string $id)
    {
        $convProces = ConvenioProcedimento::findOrFail($id);
        $convProces->delete();

        return redirect()->back()->with('success', 'Excluído com sucesso!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && !empty($ids)) {
            $deleted = ConvenioProcedimento::destroy($ids);

            if ($deleted) {
                return response()->json(['success' => true, 'message' => 'Itens excluídos com sucesso!']);
            } else {
                return response()->json(['success' => false, 'message' => 'Erro ao excluir itens!'], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Nenhum item selecionado!'], 400);
    }


}
