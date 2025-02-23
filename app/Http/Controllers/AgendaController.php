<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Convenio;
use App\Models\Disponibilidade;
use App\Models\Empresas;
use App\Models\Especialidade;
use App\Models\Exames;
use App\Models\ExamesSadt;
use Illuminate\Support\Collection;
use App\Models\Feriado;
use App\Models\MatAgenda;
use App\Models\MedAgenda;
use App\Models\Medicamento;
use App\Models\Pacientes;
use App\Models\Painel;
use App\Models\ProcAgenda;
use App\Models\Procedimentos;
use App\Models\Produtos;
use App\Models\Profissional;
use App\Models\Remedio;
use App\Models\Taxa;
use App\Models\TaxaAgenda;
use App\Models\TipoAtendimento;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $agendas = Agenda::where('profissional_id', $request->profissional_id)
                ->where('data', $request->data)
                ->get();

            return response()->json(['agendas' => $agendas]);
        }
        $tiposConsultas = TipoAtendimento::all();
        $agendas = Agenda::all();
        $pacientes = Pacientes::all();
        $profissional = Profissional::whereNotNull('conselho_1')->get();
        $procedimentos = Procedimentos::all();
        $feriado = Feriado::all();

        return view('agenda.criar', compact(['agendas', 'pacientes', 'profissional', 'procedimentos', 'feriado', 'tiposConsultas']));
    }

    public function geraAgenda(Request $request)
    {
        $profissionais = Profissional::whereNotNull('conselho_1')->get();

        return view('agenda.geraragenda', compact(['profissionais']));
    }

    public function detalhesConsulta($id)
    {
        ini_set('memory_limit', '512M');

        $agendas = Agenda::find($id);

        if (!$agendas) {
            return redirect()->back()->withErrors('Agenda não encontrada');
        }

        if ($agendas && $agendas->paciente && $agendas->paciente->convenio) {
            $tabelaProcedimentos = $agendas->paciente->convenio->tab_proc_id;

            if ($tabelaProcedimentos === null) {
                $agendas->procedimento_lista = DB::table('procedimentos')
                    ->select('id', 'procedimento', 'codigo', 'valor_proc')
                    ->orderBy('id', 'asc')
                    ->get();
            } elseif (Schema::hasTable($tabelaProcedimentos)) {
                if (str_starts_with($tabelaProcedimentos, 'tab_amb92') || str_starts_with($tabelaProcedimentos, 'tab_amb96')) {
                    $agendas->procedimento_lista = DB::table($tabelaProcedimentos)
                        ->select('id', 'descricao as procedimento', 'codigo', 'valor_proc')
                        ->orderBy('id', 'asc')
                        ->get();
                } elseif (str_starts_with($tabelaProcedimentos, 'tab_cbhpm')) {
                    $agendas->procedimento_lista = DB::table($tabelaProcedimentos)
                        ->select('id', 'procedimento', 'codigo_anatomico as codigo', 'valor_proc')
                        ->orderBy('id', 'asc')
                        ->get();
                } else {
                    $agendas->procedimento_lista = collect([
                        (object) [
                            'id' => null,
                            'procedimento' => 'Procedimento não encontrado',
                            'codigo' => null,
                            'valor_proc' => null
                        ]
                    ]);
                }
            } else {
                $agendas->procedimento_lista = collect([
                    (object) [
                        'id' => null,
                        'procedimento' => 'Tabela de procedimentos não encontrada',
                        'codigo' => null,
                        'valor_proc' => null
                    ]
                ]);
            }
        }
        // dd($agendas->procedimento_lista);
        if ($agendas->paciente->convenio) {
            $tabelaMedicamentos = $agendas->paciente->convenio->tab_med_id;

            if ($tabelaMedicamentos && Schema::hasTable($tabelaMedicamentos)) {
                $query = DB::table($tabelaMedicamentos);

                if (str_starts_with($tabelaMedicamentos, 'tab_brasindice')) {
                    $query->select('id', 'medicamento', 'preco', 'TUSS as codigo', 'APRESENTACAO as unid');
                } elseif (str_starts_with($tabelaMedicamentos, 'tab_simpro')) {
                    $query->select('id', 'DESCRICAO as medicamento');
                }

                $agendas->medicamentos = $query->get();
            } else {
                $agendas->medicamentos = DB::table('medicamentos')
                ->select('id', 'nome as medicamento', 'tipo as codigo', 'padrao as unid', 'preco_venda as preco') // Define codigo como NULL
                ->orderBy('id')
                ->get();
            }
        } else {
            $agendas->medicamentos = DB::table('medicamentos')
                ->select('id', 'nome as medicamento', 'tipo as codigo', 'padrao as unid', 'preco_venda as preco') // Define codigo como NULL
                ->orderBy('id')
                ->get();


        }

        $pacientes = Pacientes::join('agendas', 'pacientes.id', '=', 'agendas.paciente_id')
            ->where('agendas.id', $id)
            ->select('pacientes.*', 'agendas.data', 'agendas.hora')
            ->first();

        if ($agendas->paciente->convenio) {
            $tabelaMaterias = $agendas->paciente->convenio->tab_mat_id;

            if ($tabelaMaterias && Schema::hasTable($tabelaMaterias)) {
                $query = DB::table($tabelaMaterias);

                if (str_starts_with($tabelaMedicamentos, 'tab_brasindice')) {
                    $query->select('id', 'medicamento', 'preco', 'TUSS as codigo', 'APRESENTACAO as unid');
                } elseif (str_starts_with($tabelaMedicamentos, 'tab_simpro')) {
                    $query->select('id', 'DESCRICAO as medicamento');
                }

                $agendas->materias = $query->get();
            } else {
                // Caso a tabela não exista
                $agendas->materias = DB::table('produtos')
                ->select('id', 'nome as medicamento', 'tipo as codigo', 'padrao as unid', 'preco_venda as preco') // Define codigo como NULL
                ->orderBy('id')
                ->get();
            }
        } else {
            // Caso não exista um convenio
            $agendas->materias = DB::table('produtos')
                ->select('id', 'nome as medicamento', 'tipo as codigo', 'padrao as unid', 'preco_venda as preco') // Define codigo como NULL
                ->orderBy('id')
                ->get();
        }


        $taxas = Taxa::all();

        return view('agenda.detalhesconsulta', compact('agendas', 'pacientes', 'taxas'));
    }

    public function storeMedicamento(Request $request)
    {
        Log::info('Dados recebidos no backend:', $request->all());

        try {
            $validated = $request->validate([
                'paciente_id' => 'required|exists:pacientes,id',
                'agenda_id' => 'required|exists:agendas,id',
                'medicamento_id' => 'required|array',
                'medicamento_id.*' => 'required',
                'quantidade' => 'required|array',
                'quantidade.*' => ['required', 'regex:/^\d+$/'],
                'codigo' => 'required|array',
                'codigo.*' => 'required|string',
                'valor' => 'nullable|array',
                'valor.*' => 'nullable|numeric|min:0',
                'unidade_medida' => 'required|array',
                'unidade_medida.*' => 'required|string',
                'fator' => 'nullable|array',
                'fator.*' => 'nullable|string',
            ]);

            // Certifica-se de que todos os arrays têm o mesmo tamanho
            $count = count($validated['medicamento_id']);

            for ($index = 0; $index < $count; $index++) {
                if (
                    isset($validated['quantidade'][$index]) &&
                    isset($validated['codigo'][$index]) &&
                    isset($validated['valor'][$index]) &&
                    isset($validated['unidade_medida'][$index]) &&
                    isset($validated['fator'][$index])
                ) {
                    $medicamento_id = $validated['medicamento_id'][$index];
                    $quantidade = (int) $validated['quantidade'][$index];
                    $valor = (float) $validated['valor'][$index];
                    $fator = (float) str_replace(',', '.', $validated['fator'][$index] ?? 1); // Converte vírgula para ponto
                    $valor_total = number_format($quantidade * $valor * $fator, 2, '.', ''); // Aplica fator ao cálculo

                    Log::info('Processando medicamento:', [
                        'medicamento_id' => $medicamento_id,
                        'quantidade' => $quantidade,
                        'valor' => $valor,
                        'valor_total' => $valor_total,
                        'codigo' => $validated['codigo'][$index],
                        'unidade_medida' => $validated['unidade_medida'][$index],
                    ]);

                    $medAgenda = MedAgenda::firstOrNew([
                        'agenda_id' => $validated['agenda_id'],
                        'paciente_id' => $validated['paciente_id'],
                        'medicamento_id' => $medicamento_id,
                    ]);

                    $medAgenda->codigo = $validated['codigo'][$index];
                    $medAgenda->quantidade = $quantidade;
                    $medAgenda->valor = $valor;
                    $medAgenda->unidade_medida = $validated['unidade_medida'][$index];
                    $medAgenda->fator = $validated['fator'][$index];
                    $medAgenda->cd = '02';
                    $medAgenda->tabela = '20';
                    $medAgenda->valor_total = $valor_total;
                    $medAgenda->save();
                } else {
                    Log::warning("Dados incompletos no índice {$index}: ", $validated);
                }
            }

            return response()->json(['message' => 'Medicamentos salvos com sucesso!']);
        } catch (\Exception $e) {
            Log::error('Erro ao salvar medicamento:', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao salvar o medicamento.'], 500);
        }
    }




    public function verificarMedicamento($agenda_id, $paciente_id)
    {
        $remedios = MedAgenda::where('agenda_id', $agenda_id)
            ->where('paciente_id', $paciente_id)
            ->select('medicamento_id', 'quantidade', 'codigo', 'valor', 'unidade_medida', 'fator')
            ->get();

        if ($remedios->isEmpty()) {
            return response()->json(['error' => 'Nenhuma prescrição encontrada'], 404);
        }

        return response()->json(['data' => $remedios]);
    }

    public function storeProcedimento(Request $request)
{
    Log::info('Dados recebidos no backend:', $request->all());

    try {
        // Validação ajustada
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'agenda_id' => 'required|exists:agendas,id',
            'procedimento_id.*' => 'required',
            'codigo.*' => 'required|string',
            'valor.*' => 'required|string',
            'dataproc.*' => 'required|date',
        ]);

        foreach ($validated['procedimento_id'] as $index => $procedimento_id) {
            $valor = (float) $validated['valor'][$index];

            Log::info('Processando procedimento:', [
                'procedimento_id' => $procedimento_id,
                'valor' => $valor,
                'codigo' => $validated['codigo'][$index],
                'dataproc' => $validated['dataproc'][$index],
            ]);

            // Busca ou cria um novo registro incluindo o campo `dataproc`
            $ProcAgenda = ProcAgenda::firstOrNew([
                'agenda_id' => $validated['agenda_id'],
                'paciente_id' => $validated['paciente_id'],
                'procedimento_id' => $procedimento_id,
                'dataproc' => $validated['dataproc'][$index], // Inclui dataproc na condição de busca
            ]);

            // Atualizar ou criar os valores para o procedimento
            $ProcAgenda->codigo = $validated['codigo'][$index];
            $ProcAgenda->valor = $valor;
            $ProcAgenda->save();
        }

        return response()->json(['message' => 'Procedimentos salvos com sucesso!']);
    } catch (\Exception $e) {
        Log::error('Erro ao salvar procedimento:', ['exception' => $e->getMessage()]);
        return response()->json(['error' => 'Erro ao salvar o procedimento.'], 500);
    }
}


    public function verificarProcedimento($agenda_id, $paciente_id)
    {
        $procedimentos = ProcAgenda::where('agenda_id', $agenda_id)
            ->where('paciente_id', $paciente_id)
            ->get(['procedimento_id', 'dataproc', 'codigo', 'valor']); // Certifique-se de selecionar os campos necessários

        if ($procedimentos->isEmpty()) {
            return response()->json(['error' => 'Nenhum procedimento encontrado'], 404);
        }

        return response()->json(['data' => $procedimentos]);
    }



    public function storeMaterial(Request $request)
{
    try {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'agenda_id' => 'required|exists:agendas,id',
            'material_id' => 'required|array',
            'material_id.*' => 'required',
            'quantidade' => 'required|array',
            'quantidade.*' => ['required', 'regex:/^\d+$/'],
            'codigo' => 'required|array',
            'codigo.*' => 'required|string',
            'valor' => 'nullable|array',
            'valor.*' => 'nullable|numeric|min:0',
            'unidade_medida' => 'required|array',
            'unidade_medida.*' => 'required|string',
            'fator' => 'nullable|array',
            'fator.*' => 'nullable|string',
        ]);

        // Certifica-se de que todos os arrays têm o mesmo tamanho
        $count = count($validated['material_id']);

        for ($index = 0; $index < $count; $index++) {
            if (
                isset($validated['quantidade'][$index]) &&
                isset($validated['codigo'][$index]) &&
                isset($validated['valor'][$index]) &&
                isset($validated['unidade_medida'][$index]) &&
                isset($validated['fator'][$index])
            ) {
                $material_id = $validated['material_id'][$index];
                $quantidade = (int) $validated['quantidade'][$index];
                $valor = (float) $validated['valor'][$index];
                $fator = (float) str_replace(',', '.', $validated['fator'][$index] ?? 1); // Converte vírgula para ponto
                $valor_total = number_format($quantidade * $valor * $fator, 2, '.', ''); // Aplica fator ao cálculo

                Log::info('Processando materias:', [
                    'material_id' => $material_id,
                    'quantidade' => $quantidade,
                    'valor' => $valor,
                    'valor_total' => $valor_total,
                    'codigo' => $validated['codigo'][$index],
                    'unidade_medida' => $validated['unidade_medida'][$index],
                ]);

                $matAgenda = MatAgenda::firstOrNew([
                    'agenda_id' => $validated['agenda_id'],
                    'paciente_id' => $validated['paciente_id'],
                    'material_id' => $material_id,
                ]);

                $matAgenda->codigo = $validated['codigo'][$index];
                $matAgenda->quantidade = $quantidade;
                $matAgenda->valor = $valor;
                $matAgenda->unidade_medida = $validated['unidade_medida'][$index];
                $matAgenda->fator = $validated['fator'][$index];
                $matAgenda->cd = '03';
                $matAgenda->tabela = '19';
                $matAgenda->valor_total = $valor_total;
                $matAgenda->save();
            } else {
                Log::warning("Dados incompletos no índice {$index}: ", $validated);
            }
        }

        return response()->json(['message' => 'Materiais salvos com sucesso!']);
    } catch (\Exception $e) {
        Log::error('Erro ao salvar materiais:', ['exception' => $e->getMessage()]);
        return response()->json(['error' => 'Erro ao salvar os materiais.'], 500);
    }
}

    public function verificarMaterial($agenda_id, $paciente_id)
    {
        $material = MatAgenda::where('agenda_id', $agenda_id)
            ->where('paciente_id', $paciente_id)
            ->get();

        if ($material->isEmpty()) {
            return response()->json(['error' => 'Nenhum material encontrado'], 404);
        }

        return response()->json(['data' => $material]);
    }

    public function storeTaxa(Request $request)
    {
        try {
            // Validação dos campos
            $validated = $request->validate([
                'paciente_id' => 'required|exists:pacientes,id',
                'agenda_id' => 'required|exists:agendas,id',
                'taxa_id.*' => 'required',
            ]);

            // Loop para salvar ou atualizar cada material
            foreach ($validated['taxa_id'] as $taxa_id) {
                TaxaAgenda::updateOrCreate(
                    [
                        'agenda_id' => $validated['agenda_id'],
                        'paciente_id' => $validated['paciente_id'],
                        'taxa_id' => $taxa_id,
                    ]
                );
            }

            return response()->json(['message' => 'Taxas salvas com sucesso!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage()); // Registra o erro no log
            return response()->json(['error' => 'Erro ao salvar as taxas.'], 500);
        }
    }

    public function verificarTaxa($agenda_id, $paciente_id)
    {
        $taxa = TaxaAgenda::where('agenda_id', $agenda_id)
            ->where('paciente_id', $paciente_id)
            ->get();

        if ($taxa->isEmpty()) {
            return response()->json(['error' => 'Nenhuma taxa encontrada'], 404);
        }

        return response()->json(['data' => $taxa]);
    }


    public function index3(Request $request)
    {
        $especialidades = Especialidade::all();
        $profissionais = collect(); // Default empty collection for "profissionais"

        if ($request->has('especialidade_id')) {
            $especialidadeId = $request->input('especialidade_id');
            $profissionais = DB::table('especialidade_profissional as ep')
                ->join('profissionals as p', 'p.id', '=', 'ep.profissional_id')
                ->join('especialidades as e', 'e.id', '=', 'ep.especialidade_id')
                ->where('e.id', $especialidadeId)
                ->select('p.id', 'p.name')
                ->get();
        }
        $convenios = Convenio::all();
        $agendas = Agenda::all();
        $pacientes = Pacientes::all();
        $procedimentos = Procedimentos::all();
        $feriado = Feriado::all();

        return view('agenda.marcacao', compact('especialidades', 'convenios', 'profissionais', 'agendas', 'pacientes', 'procedimentos', 'feriado'));
    }

    public function getProcedimentos(Request $request)
    {
        try {
            $convenioId = $request->input('convenio_id');
            $convenio = Convenio::find($convenioId);

            if ($convenio) {
                // Verifica se o convenio possui uma tabela de procedimentos
                if ($convenio->tab_proc_id) {
                    // Verifica se a tabela especificada existe antes de consultar
                    if (Schema::hasTable($convenio->tab_proc_id)) {
                        // Verifica se o nome da tabela começa com "tab_amb92" ou "tab_amb96"
                        if (str_starts_with($convenio->tab_proc_id, 'tab_amb92') || str_starts_with($convenio->tab_proc_id, 'tab_amb96')) {
                            $procedimentos = DB::table($convenio->tab_proc_id)->select('id', 'descricao', 'codigo', 'valor_proc')->orderBy('id', 'asc')->get();
                        } elseif (str_starts_with($convenio->tab_proc_id, 'tab_cbhpm')) {
                            $procedimentos = DB::table($convenio->tab_proc_id)->select('id', 'procedimento', 'codigo_anatomico', 'valor_proc')->orderBy('id', 'asc')->get();
                        }
                    } else {
                        return response()->json(['error' => 'Tabela de procedimentos não encontrada.'], 404);
                    }
                } else {
                    // Caso tab_proc_id seja null, usa a tabela padrão 'procedimentos'
                    $procedimentos = DB::table('procedimentos')->select('id', 'procedimento', 'codigo', 'valor_proc')->orderBy('id', 'asc')->get();
                }

                return response()->json($procedimentos);
            }
            return response()->json([]);
        } catch (\Exception $e) {
            // Loga o erro e retorna uma resposta com o erro
            Log::error("Erro ao buscar procedimentos: " . $e->getMessage());
            return response()->json(['error' => 'Erro interno ao buscar procedimentos.'], 500);
        }
    }

    public function verificarDisponibilidade($profissionalId, $especialidadeId, $data)
    {
        // Inicializando a variável de disponibilidades como null
        $diasdisponivel = null;

        // Somente buscar disponibilidades se profissional e especialidade forem informados
        if ($profissionalId && $especialidadeId) {
            $diasdisponivel = DB::table('disponibilidades')
                ->selectRaw("
                    CASE WHEN COUNT(dom) > 0 THEN 'Domingo' END AS dom,
                    CASE WHEN COUNT(seg) > 0 THEN 'Segunda-feira' END AS seg,
                    CASE WHEN COUNT(ter) > 0 THEN 'Terça-feira' END AS ter,
                    CASE WHEN COUNT(qua) > 0 THEN 'Quarta-feira' END AS qua,
                    CASE WHEN COUNT(qui) > 0 THEN 'Quinta-feira' END AS qui,
                    CASE WHEN COUNT(sex) > 0 THEN 'Sexta-feira' END AS sex,
                    CASE WHEN COUNT(sab) > 0 THEN 'Sábado' END AS sab
                ")
                ->where('profissional_id', $profissionalId)
                ->where('especialidade_id', $especialidadeId)
                ->first();
        }

        // Obter todos os convênios, pacientes e procedimentos
        $convenios = Convenio::all();
        $pacientes = Pacientes::all();
        $procedimentos = Procedimentos::all();

        // Obter o dia da semana
        $diaDaSemana = date('N', strtotime($data));

        // Inicializar os horários disponíveis
        $horariosDisponiveis = [];

        // Verificar cada dia da semana
        switch ($diaDaSemana) {
            case 1: // Segunda-feira
                $disponibilidades = Disponibilidade::where('profissional_id', $profissionalId)
                    ->where('especialidade_id', $especialidadeId)
                    ->where('data', $data)
                    ->whereNotNull('seg')
                    ->orderBy('hora', 'asc')
                    ->get();
                break;
            case 2: // Terça-feira
                $disponibilidades = Disponibilidade::where('profissional_id', $profissionalId)
                    ->where('especialidade_id', $especialidadeId)
                    ->where('data', $data)
                    ->whereNotNull('ter')
                    ->orderBy('hora', 'asc')
                    ->get();
                break;
            case 3: // Quarta-feira
                $disponibilidades = Disponibilidade::where('profissional_id', $profissionalId)
                    ->where('especialidade_id', $especialidadeId)
                    ->where('data', $data)
                    ->whereNotNull('qua')
                    ->orderBy('hora', 'asc')
                    ->get();
                break;
            case 4: // Quinta-feira
                $disponibilidades = Disponibilidade::where('profissional_id', $profissionalId)
                    ->where('especialidade_id', $especialidadeId)
                    ->where('data', $data)
                    ->whereNotNull('qui')
                    ->orderBy('hora', 'asc')
                    ->get();
                break;
            case 5: // Sexta-feira
                $disponibilidades = Disponibilidade::where('profissional_id', $profissionalId)
                    ->where('especialidade_id', $especialidadeId)
                    ->where('data', $data)
                    ->whereNotNull('sex')
                    ->orderBy('hora', 'asc')
                    ->get();
                break;
            case 6: // Sábado
                $disponibilidades = Disponibilidade::where('profissional_id', $profissionalId)
                    ->where('especialidade_id', $especialidadeId)
                    ->where('data', $data)
                    ->whereNotNull('sab')
                    ->orderBy('hora', 'asc')
                    ->get();
                break;
            case 7: // Domingo
                $disponibilidades = Disponibilidade::where('profissional_id', $profissionalId)
                    ->where('especialidade_id', $especialidadeId)
                    ->whereNotNull('dom')
                    ->orderBy('hora', 'asc')
                    ->get();
                break;
            default:
                $disponibilidades = collect(); // Nenhuma disponibilidade encontrada
        }

        // Processar as disponibilidades encontradas
        foreach ($disponibilidades as $disponibilidade) {
            $horariosDisponiveis[] = [
                'hora' => $disponibilidade->hora,
                'data' => $disponibilidade->data,
                'paciente_nome' => $disponibilidade->name,
                'procedimento_id' => $disponibilidade->procedimento_id,
                'name' => $disponibilidade->name,
                'celular' => $disponibilidade->celular,
                'matricula' => $disponibilidade->matricula,
                'codigo' => $disponibilidade->codigo,
                'convenio_id' => $disponibilidade->convenio_id,
                'paciente_id' => $disponibilidade->paciente_id,
                'valor_proc' => $disponibilidade->valor_proc,
            ];
        }

        return response()->json([
            'horarios' => $horariosDisponiveis,
            'convenios' => $convenios,
            'pacientes' => $pacientes,
            'procedimentos' => $procedimentos,
            'diasdisponivel' => $diasdisponivel
        ]);
    }



    public function agendar(Request $request)
    {
        // Recebe o array de agendamentos
        $agendamentos = $request->all();

        foreach ($agendamentos as $agendamentoData) {
            // Converte a data de d/m/Y para Y-m-d se necessário
            $data = DateTime::createFromFormat('d/m/Y', $agendamentoData['data'])->format('Y-m-d');
            $hora = $agendamentoData['horario'];
            $profissionalId = $agendamentoData['profissionalId'];
            $especialidadeId = $agendamentoData['especialidadeId'];
            $procedimentoId = $agendamentoData['procedimento_id'];
            $paciente = $agendamentoData['paciente'];
            $pacienteId = $agendamentoData['paciente_id']; // Verifica se o paciente_id foi enviado
            $celular = $agendamentoData['celular'];
            $matricula = $agendamentoData['matricula'];
            $codigo = $agendamentoData['codigo'];
            $valor_proc = $agendamentoData['valor_proc'];
            $convenioId = $agendamentoData['convenio'];

            $existeAgenda = Agenda::where('data', $data)
                ->where('hora', $hora)
                ->where('profissional_id', $profissionalId)
                ->where('status', '=', "MARCADO")
                ->first();

            if ($existeAgenda) {
                // Atualiza a agenda existente
                $existeAgenda->procedimento_id = $procedimentoId;
                $existeAgenda->status = "MARCADO";
                $existeAgenda->name = $paciente;
                $existeAgenda->paciente_id = $pacienteId;
                $existeAgenda->celular = $celular;
                $existeAgenda->matricula = $matricula;
                $existeAgenda->convenio_id = $convenioId;
                $existeAgenda->codigo = $codigo;
                $existeAgenda->valor_proc = $valor_proc;
                $existeAgenda->especialidade_id = $especialidadeId;
                $existeAgenda->save();
            } else {
                // Cria uma nova agenda
                $novoAgendamento = new Agenda();
                $novoAgendamento->hora = $hora;
                $novoAgendamento->data = $data;
                $novoAgendamento->procedimento_id = $procedimentoId;
                $novoAgendamento->status = "MARCADO";
                $novoAgendamento->name = $paciente;
                $novoAgendamento->paciente_id = $pacienteId;
                $novoAgendamento->celular = $celular;
                $novoAgendamento->matricula = $matricula;
                $novoAgendamento->profissional_id = $profissionalId;
                $novoAgendamento->convenio_id = $convenioId;
                $novoAgendamento->especialidade_id = $especialidadeId;
                $novoAgendamento->codigo = $codigo;
                $novoAgendamento->valor_proc = $valor_proc;
                $novoAgendamento->save();
            }

            // Agora calcula o dia da semana (1 = seg, 2 = ter, ..., 7 = dom)
            $diaDaSemana = date('N', strtotime($data));

            // Determina a coluna de disponibilidade com base no dia da semana
            $colunaDia = '';
            switch ($diaDaSemana) {
                case 1:
                    $colunaDia = 'seg';  // Segunda-feira
                    break;
                case 2:
                    $colunaDia = 'ter';  // Terça-feira
                    break;
                case 3:
                    $colunaDia = 'qua';  // Quarta-feira
                    break;
                case 4:
                    $colunaDia = 'qui';  // Quinta-feira
                    break;
                case 5:
                    $colunaDia = 'sex';  // Sexta-feira
                    break;
                case 6:
                    $colunaDia = 'sab';  // Sábado
                    break;
                case 7:
                    $colunaDia = 'dom';  // Domingo
                    break;
            }

            // Verifica se a disponibilidade já existe para o dia da semana correspondente
            $existeDisponibilidade = DB::table('disponibilidades')
                ->where('hora', $hora)
                ->where('data', $data)
                ->where('profissional_id', $profissionalId)
                ->where('especialidade_id', $especialidadeId)
                ->whereNotNull($colunaDia)  // Verifica se há disponibilidade no dia correto
                ->first();

            // Se houver disponibilidade, atualiza os dados
            if ($existeDisponibilidade) {
                DB::table('disponibilidades')
                    ->where('id', $existeDisponibilidade->id)
                    ->update([
                        'procedimento_id' => $procedimentoId,
                        'name' => $paciente,
                        'celular' => $celular,
                        'matricula' => $matricula,
                        'codigo' => $codigo,
                        'valor_proc' => $valor_proc,
                        'convenio_id' => $convenioId,
                        'paciente_id' => $pacienteId,
                    ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Disponibilidade não encontrada para o dia da semana.']);
            }
        }

        try {
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function getProfissionais($especialidadeId)
    {
        $profissionais = DB::table('especialidade_profissional as ep')
            ->join('profissionals as p', 'p.id', '=', 'ep.profissional_id')
            ->join('especialidades as e', 'e.id', '=', 'ep.especialidade_id')
            ->where('e.id', $especialidadeId)
            ->select('p.id', 'p.name')
            ->get();

        // Verifique se algum dado foi encontrado
        if ($profissionais->isEmpty()) {
            return response()->json(['message' => 'Nenhum profissional encontrado para a especialidade selecionada.'], 404);
        }

        return response()->json(['profissionais' => $profissionais]);
    }

    public function getEspecialidades($profissionalId)
    {
        $especialidades = DB::table('especialidade_profissional as ep')
            ->join('especialidades as e', 'e.id', '=', 'ep.especialidade_id')
            ->where('ep.profissional_id', $profissionalId)
            ->select('e.id', 'e.especialidade')
            ->get();

        if ($especialidades->isEmpty()) {
            return response()->json(['message' => 'Nenhuma especialidade encontrada para o profissional selecionado.'], 404);
        }

        // Retornar apenas as especialidades em formato JSON
        return response()->json($especialidades);
    }

    public function GerarAgendaStore(Request $request)
    {
        // Coleta dos dados do request
        $profissionalId = $request->input('profissional_id');
        $especialidadeId = $request->input('especialidade_id');
        $turno = $request->input('turno');
        $inicio = $request->input('inihonorario'); // Formato: HH:MM
        $intervalo = $request->input('interhonorario'); // Intervalo em minutos
        $fim = $request->input('fimhonorario'); // Formato: HH:MM
        $mes = $request->input('mes');
        $anoAtual = date('Y'); // Ano atual

        $diasSemana = ['dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sab'];

        // Convertendo os horários para o formato DateTime
        $inicio = DateTime::createFromFormat('H:i', $inicio);
        $fim = DateTime::createFromFormat('H:i', $fim);
        $intervalo = (int) $intervalo;

        // Função para encontrar todas as datas para um dia da semana específico no mês
        function encontrarDatasPorDiaDaSemana($diaSemana, $mes, $ano)
        {
            $datas = [];
            $totalDiasNoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); // Total de dias no mês
            for ($dia = 1; $dia <= $totalDiasNoMes; $dia++) {
                $data = DateTime::createFromFormat('Y-m-d', "{$ano}-{$mes}-{$dia}");
                if ($data->format('w') == $diaSemana) { // Se o dia da semana for o desejado
                    $datas[] = $data;
                }
            }
            return $datas;
        }

        // Mapear os dias da semana do PHP (0=Domingo, 6=Sábado) com os nomes de dias do formulário
        $diasSemanaMap = [
            'dom' => 0,
            'seg' => 1,
            'ter' => 2,
            'qua' => 3,
            'qui' => 4,
            'sex' => 5,
            'sab' => 6,
        ];

        $disponibilidades = [];

        // Iterar sobre os dias da semana selecionados
        foreach ($diasSemana as $dia) {
            if ($request->input($dia)) { // Verifica se o dia foi selecionado
                // Encontrar todas as datas no mês para o dia da semana específico
                $datasPorDia = encontrarDatasPorDiaDaSemana($diasSemanaMap[$dia], $mes, $anoAtual);

                // Iterar sobre todas as datas e gerar os horários
                foreach ($datasPorDia as $data) {
                    $tempInicio = clone $inicio; // Clonar o objeto DateTime para não alterar a referência original
                    while ($tempInicio <= $fim) {
                        $disponibilidade = [
                            'profissional_id' => $profissionalId,
                            'especialidade_id' => $especialidadeId,
                            'turno' => $turno,
                            'hora' => $tempInicio->format('H:i'),
                            'data' => $data->format('Y-m-d'), // A data específica para o dia da semana
                            'mes' => $mes,
                            'material' => null,
                            'medicamento' => null,
                            'inicio' => $inicio->format('H:i'),
                            'fim' => $fim->format('H:i'),
                            'intervalo' => $intervalo,
                        ];

                        // Marca o dia da semana atual com 'S'
                        foreach ($diasSemana as $d) {
                            $disponibilidade[$d] = ($d === $dia) ? 'S' : null;
                        }

                        $disponibilidades[] = $disponibilidade;
                        $tempInicio->modify("+{$intervalo} minutes");
                    }
                }
            }
        }

        // Verifique se já existem registros para o profissional_id, especialidade_id e turno
        $existingDisponibilidade = DB::table('disponibilidades')
            ->where('profissional_id', $profissionalId)
            ->where('especialidade_id', $especialidadeId)
            ->where('turno', $turno)
            ->where('mes', $mes)
            ->first();

        if ($existingDisponibilidade) {
            // Se existir, faz o update
            DB::table('disponibilidades')
                ->where('profissional_id', $profissionalId)
                ->where('especialidade_id', $especialidadeId)
                ->where('turno', $turno)
                ->delete(); // Remove as antigas disponibilidades para inserir as novas

            // Insere as novas disponibilidades
            DB::table('disponibilidades')->insert($disponibilidades);

            // Redireciona com sucesso para update
            return redirect()->back()->with('success', 'Disponibilidades atualizadas com sucesso!');
        } else {
            // Caso não existam registros, faz o insert
            DB::table('disponibilidades')->insert($disponibilidades);

            // Redireciona com sucesso para store
            return redirect()->back()->with('success', 'Disponibilidades cadastradas com sucesso!');
        }
    }


    public function getSavedData($profissionalId, $especialidadeId, $data)
    {
        // Recuperar os dados salvos do banco de dados
        $agendamentos = Agenda::where('profissional_id', $profissionalId)
            ->where('especialidade_id', $especialidadeId)
            ->whereDate('data', $data)
            ->get();

        // Retornar os dados como JSON
        return response()->json([
            'success' => true,
            'agendamentos' => $agendamentos
        ]);
    }



    public function getDisponibilidade($profissionalId)
    {
        $profissional = Profissional::find($profissionalId);

        if (!$profissional) {
            return response()->json(['error' => 'Profissional não encontrado.'], 404);
        }

        $diasDisponiveis = [
            'domingo' => $profissional->dom,
            'segunda' => $profissional->seg,
            'terca' => $profissional->ter,
            'quarta' => $profissional->qua,
            'quinta' => $profissional->qui,
            'sexta' => $profissional->sex,
            'sabado' => $profissional->sab,
        ];

        return response()->json([
            'dias_disponiveis' => $diasDisponiveis,
            'inicio_horario' => $profissional->inihonorariomanha,
            'intervalo' => $profissional->interhonorariomanha,
            'fim_horario' => $profissional->fimhonorariomanha,
        ]);
    }

    public function index1(Request $request)
    {
        $pacientes = Pacientes::all();

        $examesSolicitados = Exames::all();

        $proce = Procedimentos::all();

        $profissionals = Profissional::join('especialidade_profissional', 'profissionals.id', '=', 'especialidade_profissional.profissional_id')
            ->leftJoin('especialidades', 'especialidade_profissional.especialidade_id', '=', 'especialidades.id')
            ->select(
                'profissionals.*',
                'especialidades.conselho as conselho_profissional'
            )
            ->distinct('profissionals.id') // Retorna registros únicos por profissional
            ->get();
        $agendas = collect();
        $tiposConsultas = TipoAtendimento::all();
        // Store form values in the session
        if ($request->has('data') || $request->has('profissional_id')) {
            $query = Agenda::query();

            if ($request->has('selecionar_pelo_medico') && $request->selecionar_pelo_medico == 1) {
                // Buscar apenas pelo médico
                if ($request->has('profissional_id')) {
                    session(['profissional_id' => $request->profissional_id]);
                    $query->where('profissional_id', $request->profissional_id);
                } else {
                    session()->forget('profissional_id');
                }
            } else {
                // Buscar por data e/ou médico
                if ($request->has('data')) {
                    session(['data' => $request->data]);
                    $query->where('data', $request->data);
                } else {
                    session()->forget('data');
                }

                if ($request->has('profissional_id')) {
                    session(['profissional_id' => $request->profissional_id]);
                    $query->where('profissional_id', $request->profissional_id);
                } else {
                    session()->forget('profissional_id');
                }
            }

            $agendas = $query->orderBy('hora', 'asc')->get();

            foreach ($agendas as $agenda) {
                if ($agenda->paciente && $agenda->paciente->convenio) {
                    $tabelaProcedimentos = $agenda->paciente->convenio->tab_proc_id;

                    if ($tabelaProcedimentos && $agenda->procedimento_id) {
                        // Verifica se a tabela especificada existe antes de consultar
                        if (Schema::hasTable($tabelaProcedimentos)) {
                            // Define a coluna correta de acordo com o prefixo do nome da tabela
                            if (str_starts_with($tabelaProcedimentos, 'tab_amb92') || str_starts_with($tabelaProcedimentos, 'tab_amb96')) {
                                $procedimento = DB::table($tabelaProcedimentos)
                                    ->where('descricao', $agenda->procedimento_id)
                                    ->value('descricao'); // Supondo que a coluna seja 'descricao'
                            } elseif (str_starts_with($tabelaProcedimentos, 'tab_cbhpm')) {
                                $procedimento = DB::table($tabelaProcedimentos)
                                    ->where('procedimento', $agenda->procedimento_id)
                                    ->value('procedimento'); // Supondo que a coluna seja 'procedimento'
                            } else {
                                $procedimento = 'Procedimento não encontrado';
                            }

                            $agenda->procedimento_nome = $procedimento ?? 'Procedimento não encontrado';
                        } else {
                            $agenda->procedimento_nome = 'Tabela de procedimentos não encontrada';
                        }
                    } else {
                        $agenda->procedimento_nome = 'Procedimento não encontrado';
                    }
                } else {
                    $agenda->procedimento_nome = DB::table('procedimentos')
                        ->where('procedimento', $agenda->procedimento_id)
                        ->value('procedimento');
                }
            }

            foreach ($agendas as $agenda) {
                if ($agenda->paciente && $agenda->paciente->convenio) {
                    $tabelaProcedimentos = $agenda->paciente->convenio->tab_proc_id;

                    if ($tabelaProcedimentos === null) {
                        // Executa a consulta alternativa se `tab_proc_id` for nulo
                        $agenda->procedimento_lista = DB::table('procedimentos')
                            ->orderBy('id', 'asc')
                            ->pluck('procedimento');
                    } elseif (Schema::hasTable($tabelaProcedimentos)) {
                        // Verifica se a tabela especificada existe antes de consultar
                        // Define a coluna correta de acordo com o prefixo do nome da tabela
                        if (str_starts_with($tabelaProcedimentos, 'tab_amb92') || str_starts_with($tabelaProcedimentos, 'tab_amb96')) {
                            $procedimentos = DB::table($tabelaProcedimentos)
                                ->orderBy('id', 'asc')
                                ->pluck('descricao'); // Obter todos os valores da coluna 'descricao'
                        } elseif (str_starts_with($tabelaProcedimentos, 'tab_cbhpm')) {
                            $procedimentos = DB::table($tabelaProcedimentos)
                                ->orderBy('id', 'asc')
                                ->pluck('procedimento'); // Obter todos os valores da coluna 'procedimento'
                        } else {
                            $procedimentos = ['Procedimento não encontrado'];
                        }

                        $agenda->procedimento_lista = $procedimentos;
                    } else {
                        $agenda->procedimento_lista = ['Tabela de procedimentos não encontrada'];
                    }
                } else {
                    $agenda->procedimento_lista = ['Tabela de procedimentos não especificada'];
                }
            }

        } else {
            // Clear session data if no filter is applied
            session()->forget(['data', 'profissional_id']);
        }

        return view('agenda.lista', compact('profissionals', 'proce','agendas', 'pacientes', 'tiposConsultas', 'examesSolicitados'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        log::info($request->all());
        // Capitalize the input
        $data = $request->input('data');
        $hora = $request->input('hora');
        $name = ucfirst($request->input('name'));
        $sobrenome = ucfirst($request->input('sobrenome'));
        $celular = $request->input('celular');
        $procedimento_id = $request->input('procedimento_id');
        $profissional_id = $request->input('profissional_id');
        $paciente_id = $request->input('paciente_id');
        $convenio_id = $request->input('convenio_id');

        // Check if the agenda already exists
        $existeAgenda = Agenda::where('data', $data)
            ->where('hora', $hora)
            ->first();

        if ($existeAgenda) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Já existe Consulta para este horário.'], 400);
            }

            return redirect()->back()->with('error', 'Já existe Consulta para este horário.');
        }

        // Criar um novo item na agenda
        $agendaData = [
            'data' => $data,
            'hora' => $hora,
            'name' => $name,
            'sobrenome' => $sobrenome,
            'celular' => $celular,
            'procedimento_id' => $procedimento_id,
            'profissional_id' => $profissional_id,
            'status' => "MARCADO",
        ];

        if ($paciente_id) {
            $agendaData['paciente_id'] = $paciente_id;
        }

        if ($convenio_id) {
            $agendaData['convenio_id'] = $convenio_id;
        }

        $agenda = Agenda::create($agendaData);

        if ($request->ajax()) {
            return response()->json(['success' => 'Consulta Criada com sucesso!', 'agenda' => $agenda]);
        }

        return redirect()->back()->with('success', 'Consulta Criada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function consultaAgenda()
    {
        $especialidades = Especialidade::all();
        $profissionais = Profissional::whereNotNull('conselho_1')->get();

        return view('agenda.rel_agenda', compact(['especialidades', 'profissionais']));
    }

    public function filtrarAgenda(Request $request)
    {
        // Verificação para garantir que pelo menos um filtro esteja preenchido (data, profissional ou especialidade)
        if (!$request->filled('data_inicio') && !$request->filled('data_fim') && !$request->filled('profissional_id') && !$request->filled('especialidade_id')) {
            return response()->json(['error' => 'Por favor, selecione pelo menos um filtro.'], 400);
        }

        // Inicializando a variável de disponibilidades como null
        $disponibilidades = null;

        // Somente buscar disponibilidades se profissional e especialidade forem informados
        if ($request->filled('profissional_id') && $request->filled('especialidade_id')) {
            $disponibilidades = DB::table('disponibilidades')
                ->selectRaw("
                CASE WHEN COUNT(dom) > 0 THEN 'Domingo' END AS dom,
                CASE WHEN COUNT(seg) > 0 THEN 'Segunda-feira' END AS seg,
                CASE WHEN COUNT(ter) > 0 THEN 'Terça-feira' END AS ter,
                CASE WHEN COUNT(qua) > 0 THEN 'Quarta-feira' END AS qua,
                CASE WHEN COUNT(qui) > 0 THEN 'Quinta-feira' END AS qui,
                CASE WHEN COUNT(sex) > 0 THEN 'Sexta-feira' END AS sex,
                CASE WHEN COUNT(sab) > 0 THEN 'Sábado' END AS sab
            ")
                ->where('profissional_id', $request->profissional_id)
                ->where('especialidade_id', $request->especialidade_id)
                ->first();
        }

        // Consultar as agendas apenas se houver algum filtro aplicável
        $query = Agenda::query();

        // Adicionar filtro por profissional, se presente
        if ($request->filled('profissional_id')) {
            $query->where('profissional_id', $request->profissional_id);
        }

        // Adicionar filtro por especialidade, se presente
        if ($request->filled('especialidade_id')) {
            $query->where('especialidade_id', $request->especialidade_id);
        }

        // Adicionar filtro por intervalo de datas, se presente
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('data', [$request->data_inicio, $request->data_fim]);
        }

        // Se não houver filtros de profissional nem especialidade, não retornar resultados
        if (!$request->filled('profissional_id') && !$request->filled('especialidade_id')) {
            return response()->json(['error' => 'Por favor, selecione pelo menos um profissional ou uma especialidade.'], 400);
        }


        // Buscar as agendas ordenadas por hora
        $agendas = $query->orderBy('data', 'asc')->orderBy('hora', 'asc')->get();

        // Adicionar o nome do paciente e do convênio a cada agenda
        foreach ($agendas as $agenda) {
            $agenda->paciente_nome = $agenda->paciente ? $agenda->paciente->name : 'Paciente não encontrado';
            $agenda->convenio_id = $agenda->paciente->convenio->nome ?: 'Convênio não encontrado';
        }

        $empresas = Empresas::all();
        // Retornar os resultados
        return response()->json([
            'disponibilidades' => $disponibilidades,
            'agendas' => $agendas,
            'empresas' => $empresas
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request)
    {
        $agenda = Agenda::find($request->id);
        if ($agenda) {
            if ($request->status == 'CHEGOU' && is_null($agenda->paciente_id)) {
                return response()->json(['error' => 'Paciente não vinculado.'], 400);
            }
            $agenda->status = $request->status;
            $agenda->save();
            return response()->json(['success' => 'Status atualizado com sucesso.']);
        } else {
            return response()->json(['error' => 'Agenda não encontrada.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // Validar os dados do request
        $request->validate([
            'profissional_id' => 'required|exists:profissionals,id',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'paciente_id' => 'required|integer',
            'convenio_id' => 'required|integer|exists:convenios,id',
            'name' => 'required|string|max:255',
        ]);

        // Encontrar a agenda pelo ID
        $agenda = Agenda::findOrFail($id);

        $paciente = Pacientes::find($request->paciente_id);

        $convenio = $paciente->convenio_id;

        Log::info($convenio);

        // Atualizar os dados da agenda
        $agenda->profissional_id = $request->profissional_id;
        $agenda->data = $request->data;
        $agenda->hora = $request->hora;
        $agenda->paciente_id = $request->paciente_id;
        $agenda->convenio_id = $convenio;
        $agenda->matricula = $request->matricula;
        $agenda->name = $request->name;
        $agenda->celular = $request->celular;

        // Verificar e atualizar o procedimento, código e valor_proc
        if ($request->has('procedimento_id')) {
            $agenda->procedimento_id = $request->procedimento_id;

            // Obter o convênio e a tabela de procedimentos associada
            $convenio = Convenio::find($request->convenio_id);

            if (!$convenio) {
                Log::warning('Convênio não encontrado', ['convenio_id' => $request->convenio_id]);
                return; // Interrompe se o convênio não for válido
            }

            $tabelaProcedimentos = $convenio->tab_proc_id;

            // Log para verificar qual tabela está sendo usada
            Log::info('Tabela de Procedimentos Associada:', ['tabela' => $tabelaProcedimentos]);

            $procedimento = null;

            // Verificar se a tabela existe e buscar o procedimento
            if ($tabelaProcedimentos && Schema::hasTable($tabelaProcedimentos)) {
                Log::info('Executando consulta na tabela dinâmica', ['tabela' => $tabelaProcedimentos]);

                // Ativar o log de SQL para capturar a consulta
                DB::enableQueryLog();

                // Selecionar a consulta de acordo com o prefixo da tabela
                if (str_starts_with($tabelaProcedimentos, 'tab_amb92') || str_starts_with($tabelaProcedimentos, 'tab_amb96')) {
                    $procedimento = DB::table($tabelaProcedimentos)
                        ->where('descricao', $request->procedimento_id)
                        ->select('codigo', 'valor_proc')
                        ->first();
                } elseif (str_starts_with($tabelaProcedimentos, 'tab_cbhpm')) {
                    $procedimento = DB::table($tabelaProcedimentos)
                        ->where('procedimento', $request->procedimento_id)
                        ->select('codigo_anatomico as codigo', 'valor_proc')
                        ->first();
                }

                // Log do SQL executado
                Log::info('SQL Executado:', ['sql' => DB::getQueryLog()]);
            } else {
                // Caso a tabela dinâmica não exista, buscar na tabela padrão
                Log::info('Tabela dinâmica não encontrada. Consultando tabela padrão: procedimentos');
                $procedimento = DB::table('procedimentos')
                    ->where('procedimento', $request->procedimento_id)
                    ->select('codigo', 'valor_proc')
                    ->first();
            }

            // Atualizar o código e o valor_proc, se o procedimento for encontrado
            if ($procedimento) {
                $agenda->codigo = $procedimento->codigo ?? $agenda->codigo; // Atualiza apenas se o campo existir
                $agenda->valor_proc = $procedimento->valor_proc ?? $agenda->valor_proc; // Atualiza apenas se o campo existir
            } else {
                Log::warning('Procedimento não encontrado', ['procedimento_id' => $request->procedimento_id]);
            }
        }


        // Salvar as mudanças
        $agenda->save();

        // Redirecionar de volta com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Agenda atualizada com sucesso.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Encontrar o item da agenda pelo ID e deletar
            $agenda = Agenda::findOrFail($id);
            $agenda->delete();

            // Retornar uma resposta JSON com uma mensagem de sucesso
            return response()->json(['success' => 'Agenda deletada com sucesso.']);
        } catch (\Exception $e) {
            // Retornar uma resposta JSON com uma mensagem de erro
            return response()->json(['error' => 'Erro ao deletar a agenda.'], 500);
        }
    }


    public function agendaMedica(Request $request)
    {
        $pacientes = Pacientes::all();

        // Get the currently logged-in user
        $user = auth()->user();
        $profissionalId = $user->profissional_id;

        // Check if a date is provided in the request; otherwise, use the current date
        $data = $request->input('data', Carbon::now()->format('Y-m-d'));

        // Filter agendas based on the logged-in user's linked professional ID
        $agendasChegou = Agenda::where('profissional_id', $profissionalId)
            ->where('data', $data)
            ->where('status', 'CHEGOU')
            ->whereNotNull('paciente_id')
            ->orderBy('hora', 'asc')
            ->get();

        $agendasMarcado = Agenda::where('profissional_id', $profissionalId)
            ->where('data', $data)
            ->where('status', "MARCADO")
            ->orderBy('hora', 'asc')
            ->get();

        $agendasEvadio = Agenda::where('profissional_id', $profissionalId)
            ->where('data', $data)
            ->where('status', 'EVADIU')
            ->orderBy('hora', 'asc')
            ->get();

        $agendasCancelado = Agenda::where('profissional_id', $profissionalId)
            ->where('data', $data)
            ->where('status', 'CANCELADO')
            ->orderBy('hora', 'asc')
            ->get();

        $agendasFinalizado = Agenda::where('profissional_id', $profissionalId)
            ->where('data', $data)
            ->where('status', 'FINALIZADO')
            ->orderBy('hora', 'asc')
            ->get();

        // Store form values in the session
        session(['data' => $data]);

        return view('agenda.agendamedica', compact('agendasMarcado', 'agendasEvadio', 'agendasCancelado', 'agendasChegou', 'pacientes', 'data', 'agendasFinalizado'));
    }


    public function storeConsultorioPainel(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $sala = $user->sala;
        $permisaoId = $user->permisao_id;
        $agendaId = $request->input('agenda_id');
        $pacienteId = $request->input('paciente_id');

        // Verificar se jÃÂ¡ existe um registro com o mesmo agenda_id
        $painel = Painel::where('agenda_id', $agendaId)
            ->where('permisao_id', $permisaoId)
            ->first();


        if ($painel) {

            $painel->update([
                'user_id' => $userId,
                'sala_id' => $sala,
                'permisao_id' => $permisaoId,
                'sequencia' => $painel->sequencia + 1, // Incrementa a coluna sequencia
            ]);

            return response()->json(['success' => 'Painel atualizado com sucesso']);
        } else {
            // Se nÃÂ£o existe, crie um novo registro
            $painel = new Painel();
            $painel->paciente_id = $pacienteId;
            $painel->agenda_id = $agendaId;
            $painel->user_id = $userId;
            $painel->sala_id = $sala;
            $painel->permisao_id = $permisaoId;
            $painel->sequencia = 1; // Inicializa sequencia como 1 para novos registros
            $painel->save();

            return response()->json(['success' => true, 'message' => 'Dados salvos com sucesso']);
        }
    }


    public function verificarFeriado(Request $request)
    {
        $data = $request->input('data');

        // Verificar se a data ÃÂ© um domingo
        $isSunday = Carbon::parse($data)->isSunday();

        // Verificar se a data ÃÂ© um feriado
        $isHoliday = Feriado::where('data', $data)->exists();

        return response()->json([
            'isHoliday' => $isHoliday,
            'isSunday' => $isSunday,
            'data' => $data
        ]);
    }
}
