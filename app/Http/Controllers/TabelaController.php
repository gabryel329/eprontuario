<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\TabConvenio;
use App\Models\Tabela;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Smalot\PdfParser\Parser;
use Illuminate\Http\Request;

class TabelaController extends Controller
{
    public function importarExcelIndex()
    {
        // Consultar todas as tabelas que começam com "tab_"
        $tabelas = DB::select("
            SELECT table_name 
            FROM information_schema.tables 
            WHERE table_schema = 'public' 
            AND (
                table_name LIKE 'tab_amb%' OR 
                table_name LIKE 'tab_brasindice%' OR 
                table_name LIKE 'tab_cbhpm%' OR
                table_name LIKE 'tab_simpro%'
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

        // Extrair apenas os nomes das tabelas
        $tabelas = array_map(function ($table) {
            return $table->table_name;
        }, $tabelas);

        $portes = array_map(function ($table) {
            return $table->table_name;
        }, $portes);

        $ch = array_map(function ($table) {
            return $table->table_name;
        }, $ch);

        return view('cadastros.imp_tabela', compact(['tabelas', 'portes', 'ch']));
    }

    public function porteExcluir($nome)
    {
        // Excluir a tabela específica
        DB::statement("DROP TABLE IF EXISTS {$nome}");

        return redirect()->route('imp_tabela.index')->with('success', "Porte {$nome} excluído com sucesso!");
    }

    public function chExcluir($nome)
    {
        // Excluir a tabela específica
        DB::statement("DROP TABLE IF EXISTS {$nome}");

        return redirect()->route('imp_tabela.index')->with('success', "CH {$nome} excluído com sucesso!");
    }

    public function excluirTabela($nome)
    {
        // Excluir a tabela específica
        DB::statement("DROP TABLE IF EXISTS {$nome}");

        return redirect()->route('imp_tabela.index')->with('success', "Tabela {$nome} excluída com sucesso!");
    }

    public function porteSalvar(Request $request)
    {
        // Obter a descrição e formatar para o nome da tabela
        $descricao = $request->input('descricao');
        $tableName = 'porte_' . strtolower(str_replace(' ', '_', $descricao)); // Adicionar prefixo "porte_"

        // Coletar todos os dados do formulário, exceto o campo 'descricao' e '_token'
        $data = $request->except(['descricao', '_token']);

        // Verificar se a tabela existe; caso contrário, criar a tabela
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) use ($data) {
                $table->id();
                foreach ($data as $column => $value) {
                    $table->string($column)->nullable();
                }
                $table->timestamps();
            });
        }

        // Inserir os dados na tabela
        try {
            DB::table($tableName)->insert($data);
            return redirect()->back()->with('success', 'Dados inseridos com sucesso!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Erro ao inserir dados.');
        }
    }

    public function chSalvar(Request $request)
    {
        // Obter a descrição e formatar para o nome da tabela
        $descricao = $request->input('descricao');
        $tableName = 'ch_' . strtolower(str_replace(' ', '_', $descricao)); // Adicionar prefixo "porte_"

        // Coletar todos os dados do formulário, exceto o campo 'descricao' e '_token'
        $data = $request->except(['descricao', '_token']);

        // Verificar se a tabela existe; caso contrário, criar a tabela
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) use ($data) {
                $table->id();
                foreach ($data as $column => $value) {
                    $table->string($column)->nullable();
                }
                $table->timestamps();
            });
        }

        // Inserir os dados na tabela
        try {
            DB::table($tableName)->insert($data);
            return redirect()->back()->with('success', 'Dados inseridos com sucesso!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Erro ao inserir dados.');
        }
    }


    public function importarExcel(Request $request)
    {
        ini_set('memory_limit', '512M');
        \Log::info('Entrou no método importarExcel');
        try {
            $request->validate([
                'tabela' => 'required|in:brasindice,amb92,simpro,amb96,cbhpm',
                'excel_data' => 'required|array',
                'descricao' => 'required|string|max:255'
            ]);

            $prefixoTabela = strtolower($request->input('tabela'));

            // Formatar a descrição para uso no nome da tabela (substitui espaços por underscores)
            $descricao = str_replace(' ', '_', $request->input('descricao'));

            // Concatenar o prefixo da tabela com a descrição formatada
            $tableName = "tab_{$prefixoTabela}_{$descricao}";

            // Criar a tabela com o nome final
            $this->criarTabela($prefixoTabela, $tableName);

            $rows = $request->input('excel_data');

            if (empty($rows)) {
                return response()->json(['error' => 'Nenhum dado válido encontrado no Excel.'], 400);
            }

            $batchSize = 1000; // Tamanho do lote
            $dataBatch = [];

            foreach ($rows as $index => $row) {
                $dataBatch[] = $this->formatarDados($prefixoTabela, $row);

                if (count($dataBatch) === $batchSize || $index === array_key_last($rows)) {
                    DB::table($tableName)->insert($dataBatch);
                    $dataBatch = []; // Limpa o lote
                }
            }

            return response()->json(['message' => "Importação concluída com sucesso!"]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => 'Ocorreu um erro no servidor.'], 500);
        }
    }

    // Função para criar a tabela de acordo com o tipo selecionado
    private function criarTabela($prefixoTabela, $tableName)
    {
        Schema::create($tableName, function (Blueprint $table) use ($prefixoTabela) {
            $table->id();
            switch ($prefixoTabela) {
                case 'brasindice':
                    $table->string('COD_LAB', 500)->nullable();
                    $table->string('LABORATORIO', 500)->nullable();
                    $table->string('COD_ITEM', 500)->nullable();
                    $table->string('medicamento', 500)->nullable();
                    $table->string('COD_APR', 500)->nullable();
                    $table->string('APRESENTACAO', 500)->nullable();
                    $table->string('preco', 500)->nullable();
                    $table->string('QTDE_FRACIONAMENTO', 500)->nullable();
                    $table->string('PMC_PFB', 500)->nullable();
                    $table->string('PRECO_FRACAO', 500)->nullable();
                    $table->string('EDICAO', 500)->nullable();
                    $table->string('IPI', 500)->nullable();
                    $table->string('PORTARIA_PIS_COFINS', 500)->nullable();
                    $table->string('EAN', 500)->nullable();
                    $table->string('TISS', 500)->nullable();
                    $table->string('GENERICO', 500)->nullable();
                    $table->string('TUSS', 500)->nullable();
                    break;
                case 'simpro':
                    $table->string('SEQUENCIA')->notNullable();
                    $table->string('CD_SIMPRO', 500)->nullable();
                    $table->string('DESCRICAO')->notNullable();
                    $table->string('VIGENCIA', 500)->nullable();
                    $table->string('PC_FR_FAB', 500)->nullable();
                    $table->string('TP_EMBAL', 500)->nullable();
                    $table->string('TP_FRACAO', 500)->nullable();
                    $table->string('CD_MERCACAO', 500)->nullable();
                    $table->string('FABRICA', 500)->nullable();
                    $table->string('PC_FR_VEND', 500)->nullable();
                    $table->string('PAGINA', 500)->nullable();
                    $table->string('DATA2', 500)->nullable();
                    $table->string('DATASINC', 500)->nullable();
                    $table->string('TUSS', 500)->nullable();
                    $table->string('ANVISA', 500)->nullable();
                    break;
                case 'amb92':
                case 'amb96':
                    $table->string('codigo', 500)->nullable();
                    $table->string('teste1', 500)->nullable();
                    $table->string('descricao1', 500)->nullable();
                    $table->string('teste2', 500)->nullable();
                    $table->string('teste3', 500)->nullable();
                    $table->string('teste4', 500)->nullable();
                    $table->string('cod_amb', 500)->nullable();
                    $table->string('descricao', 500)->nullable();
                    $table->string('teste5', 500)->nullable();
                    $table->string('teste6', 500)->nullable();
                    $table->string('teste7', 500)->nullable();
                    $table->string('teste8', 500)->nullable();
                    $table->string('filme', 500)->nullable();
                    $table->string('custo_operacional', 500)->nullable();
                    $table->string('ch', 500)->nullable();
                    $table->string('auxiliar', 500)->nullable();
                    $table->string('teste9', 500)->nullable();
                    $table->string('porte', 500)->nullable();
                    $table->string('valor_proc', 500)->nullable();
                    break;
                case 'cbhpm':
                    $table->string('id_grupo', 500)->nullable();
                    $table->string('descricao_grupo', 500)->nullable();
                    $table->string('id_subgrupo', 500)->nullable();
                    $table->string('descricao_subgrupo', 500)->nullable();
                    $table->string('codigo_anatomico', 500)->nullable();
                    $table->string('procedimento', 500)->nullable();
                    $table->string('porcentagem', 500)->nullable();
                    $table->string('de', 500)->nullable();
                    $table->string('porte', 500)->nullable();
                    $table->string('custo_operacional', 500)->nullable();
                    $table->string('auxiliares', 500)->nullable();
                    $table->string('porte_anestesico', 500)->nullable();
                    $table->string('filmes', 500)->nullable();
                    $table->string('incidencia', 500)->nullable();
                    $table->string('unidade_radiof', 500)->nullable();
                    $table->string('valor_proc', 500)->nullable();

                    break;
            }
            $table->timestamps();
        });
    }

    // Função para formatar dados dependendo da tabela selecionada
    private function formatarDados($prefixoTabela, $row)
    {
        switch ($prefixoTabela) {
            case 'brasindice':
                return [
                    'COD_LAB' => $row[0] ?? null,
                    'LABORATORIO' => $row[1] ?? null,
                    'COD_ITEM' => $row[2] ?? null,
                    'medicamento' => $row[3] ?? null,
                    'COD_APR' => $row[4] ?? null,
                    'APRESENTACAO' => $row[5] ?? null,
                    'preco' => $row[6] ?? null,
                    'QTDE_FRACIONAMENTO' => $row[7] ?? null,
                    'PMC_PFB' => $row[8] ?? null,
                    'PRECO_FRACAO' => $row[9] ?? null,
                    'EDICAO' => $row[10] ?? null,
                    'IPI' => $row[11] ?? null,
                    'PORTARIA_PIS_COFINS' => $row[12] ?? null,
                    'EAN' => $row[13] ?? null,
                    'TISS' => $row[14] ?? null,
                    'GENERICO' => $row[15] ?? null,
                    'TUSS' => $row[16] ?? null,
                ];
            case 'simpro':
                return [
                    'SEQUENCIA' => $row[0] ?? null,
                    'CD_SIMPRO' => $row[1] ?? null,
                    'DESCRICAO' => $row[2] ?? null,
                    'VIGENCIA' => $row[3] ?? null,
                    'PC_FR_FAB' => $row[4] ?? null,
                    'TP_EMBAL' => $row[5] ?? null,
                    'TP_FRACAO' => $row[6] ?? null,
                    'CD_MERCACAO' => $row[7] ?? null,
                    'FABRICA' => $row[8] ?? null,
                    'PC_FR_VEND' => $row[9] ?? null,
                    'PAGINA' => $row[10] ?? null,
                    'DATA2' => $row[11] ?? null,
                    'DATASINC' => $row[12] ?? null,
                    'TUSS' => $row[13] ?? null,
                    'ANVISA' => $row[14] ?? null,
                ];
            case 'amb92':
            case 'amb96':
                return [
                    'codigo' => $row[0] ?? null,
                    'descricao1' => $row[2] ?? null,
                    'cod_amb' => $row[6] ?? null,
                    'descricao' => $row[7] ?? null,
                    'filme' => $row[12] ?? null,
                    'custo_operacional' => $row[13] ?? null,
                    'ch' => $row[14] ?? null,
                    'auxiliar' => $row[15] ?? null,
                    'porte' => $row[17] ?? null,
                    'valor_proc' => $row[18] ?? null,
                ];
            case 'cbhpm':
                return [
                    'id_grupo' => $row[0] ?? null,
                    'descricao_grupo' => $row[1] ?? null,
                    'id_subgrupo' => $row[2] ?? null,
                    'descricao_subgrupo' => $row[3] ?? null,
                    'codigo_anatomico' => $row[4] ?? null,
                    'procedimento' => isset($row[5]) ? substr($row[5], 0, 1000) : null, // Truncar para 255 caracteres
                    'porcentagem' => $row[6] ?? null,
                    'de' => $row[7] ?? null,
                    'porte' => $row[8] ?? null,
                    'custo_operacional' => $row[9] ?? null,
                    'auxiliares' => $row[10] ?? null,
                    'porte_anestesico' => $row[11] ?? null,
                    'filmes' => $row[12] ?? null,
                    'incidencia' => $row[13] ?? null,
                    'unidade_radiof' => $row[14] ?? null,
                    'valor_proc' => $row[15] ?? null,
                ];
            default:
                return [];
        }
    }

    public function importarTxt(Request $request)
    {
        ini_set('memory_limit', '512M');
        \Log::info('Entrou no método importarTxt');

        try {
            $request->validate([
                'tabela' => 'required|in:brasindice,amb92,simpro,amb96,cbhpm',
                'file' => 'required',
                'descricao' => 'required|string|max:255'
            ]);

            $prefixoTabela = strtolower($request->input('tabela'));

            // Formatar a descrição para uso no nome da tabela (substitui espaços por underscores)
            $descricao = str_replace(' ', '_', $request->input('descricao'));

            // Concatenar o prefixo da tabela com a descrição formatada
            $tableName = "tab_{$prefixoTabela}_{$descricao}";

            // Criar a tabela com o nome final
            $this->criarTabela($prefixoTabela, $tableName);

            // Processar o arquivo TXT
            $file = $request->file('file');
            $fileContent = file($file->getPathname(), FILE_IGNORE_NEW_LINES);

            if (empty($fileContent)) {
                return response()->json(['error' => 'O arquivo TXT está vazio ou inválido.'], 400);
            }

            $batchSize = 1000; // Tamanho do lote
            $dataBatch = [];

            foreach ($fileContent as $index => $line) {
                // Converte para UTF-8
                $line = mb_convert_encoding($line, 'UTF-8', 'auto');
                $row = str_getcsv($line, ',', '"');
                $dataBatch[] = $this->formatarDados($prefixoTabela, $row);
            
                if (count($dataBatch) === $batchSize || $index === array_key_last($fileContent)) {
                    DB::table($tableName)->insert($dataBatch);
                    $dataBatch = []; // Limpa o lote
                }
            }

            return redirect()->back()->with('success', 'Dados inseridos com sucesso!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Erro ao inserir dados.');
        }
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function TabelaProcedimento()
    {

        $convenios = Convenio::skip(1)->get();
        $tabconvenios = TabConvenio::all();
        $tabelas = Tabela::all();
        return view('financeiro.tabela', compact(['tabelas', 'convenios', 'tabconvenios']));
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
        $nome = $request->input('nome');
        $valor = $request->input('valor');

        // Check if the permission already exists
        $existeTabela = Tabela::where('nome', $nome)->first();

        if ($existeTabela) {
            return redirect()->route('financeiro.tabela')->with('error', 'Tabela já existe!');
        }

        // Create a new permission
        Tabela::create([
            'nome' => $nome,
            'valor' => $valor,
        ]);

        return redirect()->route('financeiro.tabela')->with('success', 'Tabela cadastrada!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tabela $tabela)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tabela $tabela)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tabela = Tabela::find($id);

        if (!$tabela) {
            return redirect()->back()->with('error', 'Tabela não encontrada!');
        }

        $tabela->nome = $request->input('nome');
        $tabela->valor = $request->input('valor');

        $tabela->save();

        return redirect()->back()->with('success', 'Tabela Atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tabela $id)
    {
        $tabela = Tabela::findOrFail($id);

        $tabela->delete();

        return redirect()->route('financeiro.tabela')->with('error', 'Tabela excluída com sucesso!');
    }


}
