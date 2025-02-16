<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\Disponibilidade;
use App\Models\Honorario;
use App\Models\Procedimentos;
use App\Models\Profissional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HonorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $honorario = Honorario::all();
        $profissionais = Profissional::with('honorarios')->whereNotNull('conselho_1')->get();
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
                ->where('profissional_id', $profissionalId)
                ->first();
    
            if (!$existingRecord) {
                // Cria um novo registro se ele não existir
                $honorario = new Honorario();
                $honorario->convenio_id = $convenioId;
                $honorario->procedimento_id = $procedimentoId;
                $honorario->codigo = $codigo;
                $honorario->porcentagem = $porcentagem;
                $honorario->profissional_id = $profissionalId;
                $honorario->save();
            } else {
                // Se o registro já existe, atualiza a porcentagem
                $existingRecord->porcentagem = $porcentagem;
                $existingRecord->save();
            }
        }
    
        return response()->json(['success' => $success]);
    }
    
    public function saveDisponibilidade(Request $request)
    {

        // Verifique se o profissional jã existe e atualize, caso exista
        $profissional = Profissional::find($request->input('profissional_id'));

        if ($profissional) {
            // Atualize os dados do profissional
            $profissional->update([
                // Atualize outros campos conforme necessãrio
            ]);

            // Salve ou atualize os dados na tabela 'disponibilidades'
            Disponibilidade::updateOrCreate(
                ['profissional_id' => $request->input('profissional_id')],
                [
                    'porcentagem' => $request->input('porcentagem'),
                    'valor' => $request->input('valor'),
                    'material' => $request->input('material'),
                    'medicamento' => $request->input('medicamento'),
                    'manha_dom' => $request->input('manha_dom'),
                    'manha_seg' => $request->input('manha_seg'),
                    'manha_ter' => $request->input('manha_ter'),
                    'manha_qua' => $request->input('manha_qua'),
                    'manha_qui' => $request->input('manha_qui'),
                    'manha_sex' => $request->input('manha_sex'),
                    'manha_sab' => $request->input('manha_sab'),
                    'inicio' => $request->input('inicio'),
                    'fim' => $request->input('fim'),
                    'intervalo' => $request->input('intervalo'),
                ]
            );

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => 'Profissional não encontrado.']);
        }
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


    public function relatorioFinanceiroIndex(Request $request)
    {
        $convenios = DB::table('convenios')->pluck('nome', 'id');
        $profissionals = DB::table('profissionals')->pluck('name', 'id');

        $resultados = null;
        if ($request->isMethod('post')) {
            $dataInicio = $request->input('data_inicio');
            $dataFim = $request->input('data_fim');
            $convenioId = $request->input('convenio_id');
            $profissionalId = $request->input('profissional_id');

            $query = DB::table('agendas as ag')
                ->select('ag.hora', 'ag.data', 'prof.name', 'proc.procedimento', 'conv.nome', 'hon.porcentagem', 'conpro.valor')
                ->join('procedimentos as proc', 'proc.procedimento', '=', 'ag.procedimento_id')
                ->join('profissionals as prof', 'prof.id', '=', 'ag.profissional_id')
                ->join('pacientes as pac', 'pac.id', '=', 'ag.paciente_id')
                ->leftJoin('convenios as conv', 'conv.id', '=', 'pac.convenio_id')
                ->leftJoin('convenio_procedimento as conpro', 'conpro.procedimento_id', '=', 'proc.id')
                ->leftJoin('honorarios as hon', 'hon.procedimento_id', '=', 'proc.id')
                ->distinct();

            if ($dataInicio) {
                $query->whereDate('ag.data', '>=', $dataInicio);
            }

            if ($dataFim) {
                $query->whereDate('ag.data', '<=', $dataFim);
            }

            if ($convenioId) {
                $query->where('conv.id', '=', $convenioId);
            }

            if ($profissionalId) {
                $query->where('prof.id', '=', $profissionalId);
            }

            $resultados = $query->get();
        }

        return view('financeiro.relatorio', compact('convenios', 'profissionals', 'resultados'));
    }

    public function relatorioGuiaIndex(Request $request)
    {
        $profissionais = Profissional::all()->whereNotNull('conselho_1');
        $convenios = Convenio::where('nome', '!=', 'Particular')->get();

        return view('guias.rel_guias', compact('profissionais', 'convenios'));
    }

    public function relatorioGuiaResult(Request $request)
    {
        $resultados = null;
        if ($request->isMethod('post')) {
            $dataInicio = $request->input('data_inicio');
            $dataFim = $request->input('data_fim');
            $convenioId = $request->input('convenio_id');
            $lote = $request->input('lote');
            $tipo_guia = $request->input('tipo_guia');
            Log::info($request->all());
    
            if ($tipo_guia == 1) {
                $query = DB::table('guia_sps as g')
                    ->select(
                        'g.id',
                        'g.data_autorizacao as data',
                        'g.nome_profissional as profissional', 
                        'g.identificador', 
                        'g.nome_beneficiario as paciente', 
                        'g.numeracao',
                        'g.agenda_id',
                        'conv.nome as convenio',
                        DB::raw('COUNT(DISTINCT e_sol.id) as qtd_ExamesSol'),
                        DB::raw('COUNT(DISTINCT e_aut.id) as qtd_ExamesAut'),
                        DB::raw('COUNT(DISTINCT mat.id) as qtd_Materiais'),
                        DB::raw('COUNT(DISTINCT med.id) as qtd_Medicamentos'),
                        DB::raw('(
                            COALESCE(SUM(CAST(mat.valor_total AS numeric)), 0) 
                            + COALESCE(SUM(CAST(med.valor_total AS numeric)), 0) 
                            + COALESCE(SUM(CAST(e_aut.valor_total AS numeric)), 0)
                        ) as valortotal')
                    )
                    ->join('exames_aut_sadt as e_aut', 'e_aut.guia_sps_id', '=', 'g.id')
                    ->join('exames_sadt as e_sol', 'e_sol.guia_sps_id', '=', 'g.id')
                    ->leftJoin('mat_agendas as mat', 'mat.guia_sps_id', '=', 'g.id')
                    ->leftJoin('med_agendas as med', 'med.guia_sps_id', '=', 'g.id')
                    ->join('convenios as conv', 'conv.id', '=', 'g.convenio_id')
                    ->groupBy('g.data_autorizacao','g.id', 'g.nome_profissional', 'g.identificador', 'g.numeracao', 'conv.nome')
                    ->distinct();
    
                if ($dataInicio) {
                    $query->where("g.data_autorizacao", '>=', $dataInicio);
                }
    
                if ($dataFim) {
                    $query->where("g.data_autorizacao", '<=', $dataFim);
                }
    
                if ($convenioId) {
                    $query->where('g.convenio_id', '=', $convenioId);
                }
    
                if ($lote) {
                    $query->where('g.numeracao', '=', $lote);
                }
            } else {
                $query = DB::table('guia_consulta as g')
                    ->select(
                        'g.id',
                        'g.data_atendimento as data',
                        'g.nome_profissional_executante  as profissional', 
                        'g.identificador', 
                        'g.numeracao',
                        'g.agenda_id',
                        'g.nome_beneficiario as paciente', 
                        'g.valor_procedimento as valortotal',
                        'conv.nome as convenio'
                    )
                    ->join('convenios as conv', 'conv.id', '=', 'g.convenio_id')
                    ->groupBy('g.data_atendimento','g.id', 'g.nome_profissional_executante', 'g.identificador', 'g.numeracao', 'conv.nome');
    
                if ($dataInicio) {
                    $query->where('g.data_atendimento', '>=', $dataInicio);
                }
    
                if ($dataFim) {
                    $query->where('g.data_atendimento', '<=', $dataFim);
                }
    
                if ($convenioId) {
                    $query->where('g.convenio_id', '=', $convenioId);
                }
    
                if ($lote) {
                    $query->where('g.numeracao', '=', $lote);
                }
            }
    
            // Log the SQL query
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $fullSql = vsprintf(str_replace('?', '%s', $sql), $bindings);
            Log::info('SQL Query: ' . $fullSql);
    
            $resultados = $query->get();
        }
    
        return response()->json($resultados);
    }
    


    public function getHonorariosByProfissional($profissionalId)
    {
        $honorarios = Honorario::where('profissional_id', $profissionalId)->get();
        return response()->json($honorarios);
    }




    public function destroy($id)
    {
        try {
            $honorario = Honorario::findOrFail($id);
            $honorario->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao remover lançamento.']);
        }
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids)) {
            Honorario::destroy($ids);
            return response()->json(['success' => true, 'message' => 'Excluido com sucesso']);
        }

        return response()->json(['success' => true, 'message' => 'Excluido com sucesso']);
    }

}
