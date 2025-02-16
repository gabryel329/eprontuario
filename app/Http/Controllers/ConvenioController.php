<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\ConvenioProcedimento;
use App\Models\Procedimentos;
use App\Models\Tabela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
                table_name LIKE 'tab_simpro%' OR
                table_name LIKE 'tab_brasindice%'
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

        $ch = DB::select("
            SELECT table_name
            FROM information_schema.tables
            WHERE table_schema = 'public'
            AND (
                table_name LIKE 'ch_%'
            );
        ");

        return view('cadastros.convenios', compact(['convenios', 'portes', 'medicamentos', 'materiais', 'procedimentos', 'ch']));
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
                table_name LIKE 'tab_simpro%' OR
                table_name LIKE 'tab_brasindice%'
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

        $ch = DB::select("
            SELECT table_name
            FROM information_schema.tables
            WHERE table_schema = 'public'
            AND (
                table_name LIKE 'ch_%'
            );
        ");
        return view('cadastros.editconvenios', compact(['convenios', 'procedimentos', 'materiais', 'medicamentos', 'portes', 'ch']));
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
            'tab_proc_id'
        ]);

        // Verifica as condições específicas para 'tab_cota_porte' e 'tab_cota_ch'
        $tabCotaPorte = $request->input('tab_cota_porte');
        $tabCotaCh = $request->input('tab_cota_ch');

        if ($tabCotaPorte && !$tabCotaCh) {
            $data['tab_cota_porte'] = $tabCotaPorte;
            $data['tab_cota_ch'] = null;  // Apaga 'tab_cota_ch' no banco
        } elseif ($tabCotaCh && !$tabCotaPorte) {
            $data['tab_cota_ch'] = $tabCotaCh;
            $data['tab_cota_porte'] = null;  // Apaga 'tab_cota_porte' no banco
        } else {
            // Se ambos estiverem presentes, mantém ambos
            $data['tab_cota_porte'] = $tabCotaPorte;
            $data['tab_cota_ch'] = $tabCotaCh;
        }

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

    // app/Http/Controllers/ConvenioController.php
    public function getProceduresIndex()
    {
        $convenio = Convenio::all();
        return view('val_proc', compact(['convenio']));
    }

    public function getProcedures($id)
    {
        try {
            $convenio = Convenio::findOrFail($id);
            $tableProc = $convenio->tab_proc_id;
            $tablePorte = $convenio->tab_cota_porte;
            $tableCh = $convenio->tab_cota_ch;

            // Verifica se a tabela de procedimentos existe
            if (!Schema::hasTable($tableProc)) {
                return response()->json(['error' => 'Tabela de procedimentos não encontrada'], 404);
            }

            // Variáveis para armazenar os resultados
            $proceduresWithValues = [];

            if (str_starts_with($tableProc, 'tab_cbhpm')) {
                $proceduresCBHPM = DB::table($tableProc)
                    ->select("codigo_anatomico as codigo", "procedimento", "porte", "custo_operacional", "porcentagem")
                    ->get();

                // Verifica se a tabela de portes existe
                if (!Schema::hasTable($tablePorte)) {
                    return response()->json(['error' => 'Tabela de portes não encontrada'], 404);
                }

                // Cálculo para proceduresCBHPM
                foreach ($proceduresCBHPM as $procedure) {
                    $porteColumn = strtolower($procedure->porte); // Converte o valor de `porte` para minúsculas

                    try {
                        // Verifica se o valor de `porte` não é vazio e existe como coluna
                        if (!empty($porteColumn) && Schema::hasColumn($tablePorte, $porteColumn)) {
                            // Usa uma consulta SQL bruta para selecionar o porte e o valor de `uco` dinamicamente
                            $porteValue = DB::select("SELECT p.\"$porteColumn\" as porte_valor, p.\"uco\" FROM \"$tablePorte\" p WHERE p.\"id\" = 1 LIMIT 1");

                            // Obtém os valores da coluna `porte` e `uco` se a consulta retornar resultados
                            $valorPorte = isset($porteValue[0]->porte_valor) ? (float) str_replace(',', '.', $porteValue[0]->porte_valor) : null;
                            $valorUco = isset($porteValue[0]->uco) ? (float) str_replace(',', '.', $porteValue[0]->uco) : null;
                            $custoOperacional = !empty($procedure->custo_operacional) ? (float) str_replace(',', '.', $procedure->custo_operacional) : null;
                            $porcentagem = !empty($procedure->porcentagem) ? (float) str_replace(',', '.', $procedure->porcentagem) : null;

                            // Cálculo do valor final
                            if ($custoOperacional !== null && $valorUco !== null) {
                                $resultadoMultiplicacao = $custoOperacional * $valorUco;
                                if ($porcentagem !== null) {
                                    // Cálculo com porcentagem
                                    $valor = ($valorPorte * ($porcentagem / 100)) + $resultadoMultiplicacao;
                                } else {
                                    // Cálculo padrão sem porcentagem
                                    $valor = $resultadoMultiplicacao + $valorPorte;
                                }
                            } else {
                                // Se custo_operacional ou uco é inválido, usa apenas o valor do porte
                                $valor = $valorPorte;
                            }
                        } else {
                            $valor = null; // Coluna de porte não encontrada ou valor de porte é vazio
                        }

                        // Adiciona o procedimento e o valor calculado ao array final, com duas casas decimais
                        $proceduresWithValues[] = [
                            'codigo' => $procedure->codigo,
                            'procedimento' => $procedure->procedimento,
                            'porte' => $procedure->porte,
                            'valor' => $valor !== null ? number_format($valor, 2, '.', '') : null,
                        ];
                    } catch (\Exception $e) {
                        // Log de erro para o cálculo do procedimento específico
                        \Log::error("Erro ao calcular valor para o porte {$procedure->porte}: " . $e->getMessage());
                        $proceduresWithValues[] = [
                            'codigo' => $procedure->codigo,
                            'procedimento' => $procedure->procedimento,
                            'porte' => $procedure->porte,
                            'valor' => null,
                        ];
                    }
                }
            } elseif (str_starts_with($tableProc, 'tab_amb92') || str_starts_with($tableProc, 'tab_amb96')) {
                $proceduresAMB = DB::table($tableProc)
                    ->select("codigo", "descricao as procedimento", "filme", "ch")
                    ->get();

                // Verifica se a tabela de CH existe
                if (!Schema::hasTable($tableCh)) {
                    return response()->json(['error' => 'Tabela de CH não encontrada'], 404);
                }

                // Cálculo para proceduresAMB
                foreach ($proceduresAMB as $procedure) {
                    $valor = null; // Valor calculado do procedimento

                    try {
                        // Obtém o valor da coluna `ch` e `fr` da tabela tableCh
                        $chValue = DB::table($tableCh)->select("ch", "fr")->where('id', 1)->first();

                        if ($chValue) {
                            $valorChTableProc = (float) str_replace(',', '.', $procedure->ch);
                            $valorChTableCh = (float) str_replace(',', '.', $chValue->ch);

                            // Cálculo base: ch (tableProc) * ch (tableCh)
                            $resultadoCh = $valorChTableProc * $valorChTableCh;

                            if (!empty($procedure->filme)) {
                                $valorFilme = (float) str_replace(',', '.', $procedure->filme);
                                $valorFr = (float) str_replace(',', '.', $chValue->fr);

                                // Cálculo com `filme`: fr (tableCh) * filme (tableProc) + resultadoCh
                                $valor = ($valorFr * $valorFilme) + $resultadoCh;
                            } else {
                                // Cálculo sem `filme`: apenas o resultado de `ch * ch`
                                $valor = $resultadoCh;
                            }
                        }

                        // Adiciona o resultado ao array final
                        $proceduresWithValues[] = [
                            'codigo' => $procedure->codigo,
                            'procedimento' => $procedure->procedimento,
                            'valor' => $valor !== null ? number_format($valor, 2, '.', '') : null,
                        ];
                    } catch (\Exception $e) {
                        \Log::error("Erro ao calcular valor para o procedimento {$procedure->codigo}: " . $e->getMessage());
                        $proceduresWithValues[] = [
                            'codigo' => $procedure->codigo,
                            'procedimento' => $procedure->procedimento,
                            'valor' => null,
                        ];
                    }
                }
            } else {
                return response()->json(['error' => 'Tipo de tabela de procedimentos não suportado'], 400);
            }

            return response()->json($proceduresWithValues);
        } catch (\Exception $e) {
            // Log geral para identificar o erro
            \Log::error("Erro ao obter procedimentos: " . $e->getMessage());
            return response()->json(['error' => 'Ocorreu um erro ao processar a solicitação'], 500);
        }
    }


    public function updateProceduresValues($id)
{
    try {
        $convenio = Convenio::findOrFail($id);
        $tableProc = $convenio->tab_proc_id;
        $tablePorte = $convenio->tab_cota_porte;
        $tableCh = $convenio->tab_cota_ch;

        // Verifica se a tabela de procedimentos existe
        if (!Schema::hasTable($tableProc)) {
            return response()->json(['error' => 'Tabela de procedimentos não encontrada'], 404);
        }

        if (str_starts_with($tableProc, 'tab_cbhpm')) {
            $proceduresCBHPM = DB::table($tableProc)
                ->select("id", "codigo_anatomico as codigo", "procedimento", "porte", "custo_operacional", "porcentagem")
                ->get();

            foreach ($proceduresCBHPM as $procedure) {
                $porteColumn = strtolower($procedure->porte);

                if (!empty($porteColumn) && Schema::hasColumn($tablePorte, $porteColumn)) {
                    $porteValue = DB::select("SELECT p.\"$porteColumn\" as porte_valor, p.\"uco\" FROM \"$tablePorte\" p WHERE p.\"id\" = 1 LIMIT 1");

                    $valorPorte = isset($porteValue[0]->porte_valor) ? (float) str_replace(',', '.', $porteValue[0]->porte_valor) : null;
                    $valorUco = isset($porteValue[0]->uco) ? (float) str_replace(',', '.', $porteValue[0]->uco) : null;
                    $custoOperacional = !empty($procedure->custo_operacional) ? (float) str_replace(',', '.', $procedure->custo_operacional) : null;
                    $porcentagem = !empty($procedure->porcentagem) ? (float) str_replace(',', '.', $procedure->porcentagem) : null;

                    if ($custoOperacional !== null && $valorUco !== null) {
                        $resultadoMultiplicacao = $custoOperacional * $valorUco;
                        if ($porcentagem !== null) {
                            $valor = ($valorPorte * ($porcentagem / 100)) + $resultadoMultiplicacao;
                        } else {
                            $valor = $resultadoMultiplicacao + $valorPorte;
                        }
                    } else {
                        $valor = $valorPorte;
                    }

                    // Atualiza a coluna valor_proc na tabela
                    DB::table($tableProc)
                        ->where('id', $procedure->id)
                        ->update(['valor_proc' => number_format($valor, 2, '.', '')]);
                }
            }
        } elseif (str_starts_with($tableProc, 'tab_amb92') || str_starts_with($tableProc, 'tab_amb96')) {
            $proceduresAMB = DB::table($tableProc)
                ->select("id", "codigo", "descricao as procedimento", "filme", "ch")
                ->get();

            // Verifica se a tabela de CH existe
            if (!Schema::hasTable($tableCh)) {
                return response()->json(['error' => 'Tabela de CH não encontrada'], 404);
            }

            // Cálculo para proceduresAMB
            foreach ($proceduresAMB as $procedure) {
                $valor = null; // Valor calculado do procedimento

                try {
                    // Obtém o valor da coluna `ch` e `fr` da tabela tableCh
                    $chValue = DB::table($tableCh)->select("ch", "fr")->where('id', 1)->first();

                    if ($chValue) {
                        $valorChTableProc = (float) str_replace(',', '.', $procedure->ch);
                        $valorChTableCh = (float) str_replace(',', '.', $chValue->ch);

                        // Cálculo base: ch (tableProc) * ch (tableCh)
                        $resultadoCh = $valorChTableProc * $valorChTableCh;

                        if (!empty($procedure->filme)) {
                            $valorFilme = (float) str_replace(',', '.', $procedure->filme);
                            $valorFr = (float) str_replace(',', '.', $chValue->fr);

                            // Cálculo com `filme`: fr (tableCh) * filme (tableProc) + resultadoCh
                            $valor = ($valorFr * $valorFilme) + $resultadoCh;
                        } else {
                            // Cálculo sem `filme`: apenas o resultado de `ch * ch`
                            $valor = $resultadoCh;
                        }

                        // Atualiza a coluna valor_proc na tabela
                        DB::table($tableProc)
                            ->where('id', $procedure->id)
                            ->update(['valor_proc' => number_format($valor, 2, '.', '')]);
                    }
                } catch (\Exception $e) {
                    \Log::error("Erro ao calcular valor para o procedimento {$procedure->codigo}: " . $e->getMessage());
                }
            }
        } else {
            return response()->json(['error' => 'Tipo de tabela de procedimentos não suportado'], 400);
        }

        return response()->json(['success' => 'Valores dos procedimentos atualizados com sucesso.']);
    } catch (\Exception $e) {
        \Log::error("Erro ao atualizar valores dos procedimentos: " . $e->getMessage());
        return response()->json(['error' => 'Erro ao processar a atualização dos valores'], 500);
    }
}


}
