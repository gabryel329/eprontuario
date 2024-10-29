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

        // Extrair apenas os nomes das tabelas
        $tabelas = array_map(function ($table) {
            return $table->table_name;
        }, $tabelas);

        return view('cadastros.imp_tabela', compact('tabelas'));
    }

    public function excluirTabela($nome)
    {
        // Excluir a tabela específica
        DB::statement("DROP TABLE IF EXISTS {$nome}");

        return redirect()->route('imp_tabela.index')->with('success', "Tabela {$nome} excluída com sucesso!");
    }

    public function importarExcel(Request $request)
    {
        $request->validate([
            'tabela' => 'required|in:brasindice,amb92,simpro,amb96,cbhpm',
            'pdf_text' => 'required|string',
        ]);

        $prefixoTabela = strtolower($request->input('tabela'));
        $tableName = "tab_{$prefixoTabela}1";

        while (Schema::hasTable($tableName)) {
            $tableName = $this->incrementarNomeTabela($tableName);
        }

        $this->criarTabela($prefixoTabela, $tableName);

        $rows = $this->processarTextoPdf($request->input('pdf_text'));

        if (empty($rows)) {
            return response()->json(['error' => 'Nenhum dado válido encontrado no PDF.'], 400);
        }

        foreach ($rows as $row) {
            DB::table($tableName)->insert($this->formatarDados($prefixoTabela, $row));
        }

        return response()->json(['message' => "Importação para {$tableName} concluída com sucesso!"]);
    }



    // Função para processar o texto extraído do PDF
    private function processarTextoPdf($pdfText)
    {
        // Verificar se o texto não está vazio
        if (empty(trim($pdfText))) {
            return []; // Retorna um array vazio se o PDF estiver em branco
        }

        // Dividir o texto em linhas
        $lines = explode("\n", trim($pdfText));
        $data = [];

        // Processar cada linha
        foreach ($lines as $line) {
            // Remover espaços extras e dividir por espaços múltiplos
            $columns = preg_split('/\s+/', trim($line));

            // Apenas adicionar se houver pelo menos uma coluna válida
            if (!empty($columns)) {
                $data[] = $columns;
            }
        }

        return $data;
    }


    // Função para incrementar o nome da tabela
    private function incrementarNomeTabela($tableName)
    {
        if (preg_match('/\d+$/', $tableName, $matches)) {
            $number = (int) $matches[0] + 1;
            return preg_replace('/\d+$/', $number, $tableName);
        }
        return $tableName . '2';
    }

    // Função para criar a tabela de acordo com o tipo selecionado
    private function criarTabela($prefixoTabela, $tableName)
    {
        Schema::create($tableName, function (Blueprint $table) use ($prefixoTabela) {
            $table->id();
            switch ($prefixoTabela) {
                case 'brasindice':
                    $table->string('COD_LAB');
                    $table->string('LABORATORIO');
                    $table->string('COD_ITEM');
                    $table->string('ITEM');
                    $table->string('COD_APR');
                    $table->string('APRESENTACAO');
                    $table->string('PRECO');
                    $table->string('QTDE_FRACIONAMENTO');
                    $table->string('PMC_PFB');
                    $table->string('PRECO_FRACAO');
                    $table->string('EDICAO');
                    $table->string('IPI');
                    $table->string('PORTARIA_PIS_COFINS');
                    $table->string('EAN');
                    $table->string('TISS');
                    $table->string('GENERICO');
                    $table->string('TUSS')->nullable();
                    break;
                case 'simpro':
                    $table->string('SEQUENCIA')->notNullable();
                    $table->string('CD_SIMPRO')->nullable();
                    $table->string('DESCRICAO')->notNullable();
                    $table->string('VIGENCIA')->nullable();
                    $table->string('PC_FR_FAB')->nullable();
                    $table->string('TP_EMBAL')->nullable();
                    $table->string('TP_FRACAO')->nullable();
                    $table->string('CD_MERCACAO')->nullable();
                    $table->string('FABRICA')->nullable();
                    $table->string('PC_FR_VEND')->nullable();
                    $table->string('PAGINA')->nullable();
                    $table->string('DATA2')->nullable();
                    $table->string('DATASINC')->nullable();
                    $table->string('TUSS')->nullable();
                    $table->string('ANVISA')->nullable();
                    break;
                case 'amb92':
                case 'amb96':
                    $table->string('codigo')->nullable();
                    $table->string('descricao')->nullable();
                    $table->string('m2')->nullable();
                    $table->string('filme')->nullable();
                    $table->string('auxiliares')->nullable();
                    $table->string('incidencia')->nullable();
                    $table->string('porte')->nullable();
                    $table->string('anestesico')->nullable();
                    $table->string('tabela')->nullable();
                    $table->string('valor_co')->nullable();
                    $table->string('valor_total')->nullable();
                    break;
                case 'cbhpm':
                    $table->string('particular')->nullable();
                    $table->string('servico')->nullable();
                    $table->string('descricao')->nullable();
                    $table->string('aux')->nullable();
                    $table->string('m2')->nullable();
                    $table->string('indice')->nullable();
                    $table->string('pa')->nullable();
                    $table->string('ps')->nullable();
                    $table->string('valor')->nullable();
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
                    'ITEM' => $row[3] ?? null,
                    'COD_APR' => $row[4] ?? null,
                    'APRESENTACAO' => $row[5] ?? null,
                    'PRECO' => $row[6] ?? null,
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
                return [
                    'codigo' => $row[0] ?? null,
                    'descricao' => $row[1] ?? null,
                    'm2' => $row[2] ?? null,
                    'filme' => $row[3] ?? null,
                    'auxiliares' => $row[4] ?? null,
                    'incidencia' => $row[5] ?? null,
                    'porte' => $row[6] ?? null,
                    'anestesico' => $row[7] ?? null,
                    'tabela' => $row[8] ?? null,
                    'valor_co' => $row[9] ?? null,
                    'valor_total' => $row[10] ?? null,
                ];
            case 'amb96':
                return [
                    'codigo' => $row[0] ?? null,
                    'procedimento' => $row[1] ?? null,
                    'hm' => $row[2] ?? null,
                    'cop' => $row[3] ?? null,
                    'num_aux' => $row[4] ?? null,
                    'porte' => $row[5] ?? null,
                    'incid' => $row[6] ?? null,
                    'filme_m2' => $row[7] ?? null,
                ];
            case 'cbhpm':
                return [
                    'particular' => $row[0] ?? null,
                    'servico' => $row[1] ?? null,
                    'descricao' => $row[2] ?? null,
                    'aux' => $row[3] ?? null,
                    'm2' => $row[4] ?? null,
                    'indice' => $row[5] ?? null,
                    'pa' => $row[6] ?? null,
                    'ps' => $row[7] ?? null,
                    'valor' => $row[8] ?? null,
                ];
            default:
                return [];
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
