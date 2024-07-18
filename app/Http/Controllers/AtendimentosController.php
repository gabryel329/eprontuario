<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Anamnese;
use App\Models\Atendimentos;
use App\Models\Exames;
use App\Models\Medicamento;
use App\Models\Pacientes;
use App\Models\Procedimentos;
use App\Models\Profissional;
use App\Models\Remedio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtendimentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($agenda_id, $paciente_id)
    {
        $agenda = Agenda::findOrFail($agenda_id);
        $medicamento = Medicamento::all();
        $procedimento = Procedimentos::all();

        $paciente = Pacientes::findOrFail($paciente_id);

        // Consulta para obter o histórico de atendimento do paciente
        $historico = DB::table('agendas as ag')
            ->join('pacientes as pa', 'ag.paciente_id', '=', 'pa.id')
            ->join('profissionals as pro', 'ag.profissional_id', '=', 'pro.id')
            ->join('procedimentos as prc', 'ag.procedimento_id', '=', 'prc.procedimento')
            
            ->leftJoin('anamneses as an', function ($join) {
                $join->on('an.paciente_id', '=', 'pa.id')
                    ->on(DB::raw('DATE(an.created_at)'), '=', 'ag.data');
            })
            ->leftJoin('atendimentos as at', function ($join) {
                $join->on('at.paciente_id', '=', 'pa.id')
                    ->on(DB::raw('DATE(at.created_at)'), '=', 'ag.data');
            })
            ->leftJoin('exames as ex', function ($join) {
                $join->on('ex.paciente_id', '=', 'pa.id')
                    ->on(DB::raw('DATE(ex.created_at)'), '=', 'ag.data');
            })
            ->leftJoin('remedios as re', function ($join) {
                $join->on('re.paciente_id', '=', 'pa.id')
                    ->on(DB::raw('DATE(re.created_at)'), '=', 'ag.data');
            })
            ->leftJoin('procedimentos as proc2', 'ex.procedimento_id', '=', 'proc2.id')
            ->leftJoin('medicamentos as med', 're.medicamento_id', '=', 'med.id')
            ->select(
                'ag.data',
                'pa.id as paciente_id',
                DB::raw('STRING_AGG(DISTINCT proc2.procedimento::text, \',\') as procedimentos'),
                DB::raw('STRING_AGG(DISTINCT med.nome::text, \',\') as medicamentos'),
                DB::raw('STRING_AGG(DISTINCT an.id::text, \',\') as anamneses_ids'),
                DB::raw('STRING_AGG(DISTINCT at.id::text, \',\') as atendimentos_ids'),
                DB::raw('STRING_AGG(DISTINCT ex.id::text, \',\') as exames_ids'),
                DB::raw('STRING_AGG(DISTINCT re.dose::text, \',\') as dose'),
                DB::raw('STRING_AGG(DISTINCT re.horas::text, \',\') as horas'),
                'pro.name as an_profissional_id',
                'an.pa as an_pa',
                'an.temp as an_temp',
                'an.peso as an_peso',
                'an.altura as an_altura',
                'an.gestante as an_gestante',
                'an.dextro as an_dextro',
                'an.spo2 as an_spo2',
                'an.fc as an_fc',
                'an.fr as an_fr',
                'an.acolhimento as an_acolhimento',
                'an.acolhimento1 as an_acolhimento1',
                'an.acolhimento2 as an_acolhimento2',
                'an.acolhimento3 as an_acolhimento3',
                'an.acolhimento4 as an_acolhimento4',
                'an.alergia1 as an_alergia1',
                'an.alergia2 as an_alergia2',
                'an.alergia3 as an_alergia3',
                'an.anamnese as an_anamnese',
                'at.queixas as at_queixas',
                'at.atestado as at_atestado',
                'at.evolucao as at_evolucao',
                'at.condicao as at_condicao'
            )
            ->where('pa.id', $paciente_id)
            ->groupBy(
                'ag.data',
                'pa.id',
                'pro.name',
                'an.pa',
                'an.temp',
                'an.peso',
                'an.altura',
                'at.condicao',
                'at.evolucao',
                'at.atestado',
                'an.spo2',
                'an.dextro',
                'an.gestante',
                'at.queixas',
                'an.anamnese',
                'an.alergia3',
                'an.alergia2',
                'an.alergia1',
                'an.acolhimento4',
                'an.acolhimento3',
                'an.acolhimento2',
                'an.acolhimento1',
                'an.acolhimento',
                'an.fr',
                'an.fc'
            )
            ->orderBy('ag.data', 'asc')
            ->get();

        return view('atendimentos.atendimentomedico', compact('agenda', 'paciente', 'medicamento', 'procedimento', 'historico'));
    }




    public function storeAtendimento(Request $request)
    {
        // Verificar se já existe um registro com o mesmo agenda_id
        $atendimento = Atendimentos::where('agenda_id', $request->input('agenda_id'))->first();

        if ($atendimento) {
            // Se o registro já existe, atualize os dados
            $atendimento->update([
                'queixas' => $request->input('queixas'),
                'evolucao' => $request->input('evolucao'),
                'atestado' => $request->input('atestado'),
                'condicao' => $request->input('condicao'),
                'paciente_id' => $request->input('paciente_id'),
                'profissional_id' => $request->input('profissional_id'),
            ]);

            return response()->json(['success' => 'Atendimento atualizado com sucesso']);
        } else {
            // Se não existe, crie um novo registro
            $atendimento = Atendimentos::create([
                'queixas' => $request->input('queixas'),
                'evolucao' => $request->input('evolucao'),
                'atestado' => $request->input('atestado'),
                'condicao' => $request->input('condicao'),
                'paciente_id' => $request->input('paciente_id'),
                'agenda_id' => $request->input('agenda_id'),
                'profissional_id' => $request->input('profissional_id'),
            ]);

            return response()->json(['success' => 'Atendimento cadastrado com sucesso', 'atendimento_id' => $atendimento->id]);
        }
    }

    public function verificarAtendimento($agenda_id, $paciente_id)
    {
        // Verificar se existe um atendimento para a agenda e o paciente especificados
        $atendimento = Atendimentos::where('agenda_id', $agenda_id)
            ->where('paciente_id', $paciente_id)
            ->first();

        if ($atendimento) {
            // Se o atendimento existe, retornar os dados do atendimento
            return response()->json(['data' => $atendimento]);
        } else {
            // Se o atendimento não existe, retornar uma mensagem de erro
            return response()->json(['error' => 'Atendimento não encontrado'], 404);
        }
    }

    public function storeAnamnese(Request $request)
    {
        // Obtenha a data atual
        $dataAtual = Carbon::now()->toDateString();

        // Verificar se já existe uma anamnese para o paciente na data atual
        $anamnese = Anamnese::where('paciente_id', $request->input('paciente_id'))
            ->whereDate('created_at', $dataAtual)
            ->first();

        if ($anamnese) {
            // Se já existe, atualize os dados
            $anamnese->update([
                'pa' => $request->input('pa'),
                'temp' => $request->input('temp'),
                'peso' => $request->input('peso'),
                'altura' => $request->input('altura'),
                'gestante' => $request->input('gestante'),
                'dextro' => $request->input('dextro'),
                'spo2' => $request->input('spo2'),
                'fc' => $request->input('fc'),
                'fr' => $request->input('fr'),
                'acolhimento' => $request->input('acolhimento'),
                'acolhimento1' => $request->input('acolhimento1'),
                'acolhimento2' => $request->input('acolhimento2'),
                'acolhimento3' => $request->input('acolhimento3'),
                'acolhimento4' => $request->input('acolhimento4'),
                'alergia1' => $request->input('alergia1'),
                'alergia2' => $request->input('alergia2'),
                'alergia3' => $request->input('alergia3'),
                'anamnese' => $request->input('anamnese'),
                'paciente_id' => $request->input('paciente_id'),
                'profissional_id' => $request->input('profissional_id'),
            ]);

            return response()->json(['success' => 'Anamnese atualizada com sucesso']);
        } else {
            // Se não existe, crie uma nova anamnese
            $anamnese = Anamnese::create([
                'pa' => $request->input('pa'),
                'temp' => $request->input('temp'),
                'peso' => $request->input('peso'),
                'altura' => $request->input('altura'),
                'gestante' => $request->input('gestante'),
                'dextro' => $request->input('dextro'),
                'spo2' => $request->input('spo2'),
                'fc' => $request->input('fc'),
                'fr' => $request->input('fr'),
                'acolhimento' => $request->input('acolhimento'),
                'acolhimento1' => $request->input('acolhimento1'),
                'acolhimento2' => $request->input('acolhimento2'),
                'acolhimento3' => $request->input('acolhimento3'),
                'acolhimento4' => $request->input('acolhimento4'),
                'alergia1' => $request->input('alergia1'),
                'alergia2' => $request->input('alergia2'),
                'alergia3' => $request->input('alergia3'),
                'anamnese' => $request->input('anamnese'),
                'paciente_id' => $request->input('paciente_id'),
                'profissional_id' => $request->input('profissional_id'),
            ]);

            return response()->json(['success' => 'Anamnese cadastrada com sucesso']);
        }
    }

    public function verificarAnamnese($paciente_id)
    {
        // Obtenha a data atual
        $dataAtual = now()->toDateString();

        // Verificar se já existe uma anamnese para o paciente na data atual
        $anamnese = Anamnese::where('paciente_id', $paciente_id)
            ->whereDate('created_at', $dataAtual)
            ->first();

        if ($anamnese) {
            // Se a anamnese existe, retornar os dados da anamnese
            return response()->json(['anamnese' => $anamnese]);
        } else {
            // Se a anamnese não existe, retornar uma mensagem de erro
            return response()->json(['error' => 'Anamnese não encontrada'], 404);
        }
    }

    public function storeRemedio(Request $request)
    {
        $paciente_id = $request->input('paciente_id');
        $agenda_id = $request->input('agenda_id');
        $profissional_id = $request->input('profissional_id');

        // Processar os medicamentos
        $medicamento_ids = $request->input('medicamento_id', []);
        $doses = $request->input('dose', []);
        $horas = $request->input('horas', []);

        // Verificar se existem múltiplas linhas e processar cada uma
        foreach ($medicamento_ids as $index => $medicamento_id) {
            if (!empty($medicamento_id)) {
                // Verificar se já existe uma prescrição com esses dados
                $existingPrescricao = Remedio::where('agenda_id', $agenda_id)
                    ->where('profissional_id', $profissional_id)
                    ->where('paciente_id', $paciente_id)
                    ->where('medicamento_id', $medicamento_id)
                    ->first();

                if (!$existingPrescricao) {
                    // Criar uma nova prescrição se não existir
                    Remedio::create([
                        'agenda_id' => $agenda_id,
                        'profissional_id' => $profissional_id,
                        'paciente_id' => $paciente_id,
                        'medicamento_id' => $medicamento_id,
                        'dose' => $doses[$index],
                        'horas' => $horas[$index]
                    ]);
                } else {
                    // Atualizar a prescrição existente
                    $existingPrescricao->update([
                        'dose' => $doses[$index],
                        'horas' => $horas[$index]
                    ]);
                }
            }
        }

        return response()->noContent();
    }


    public function verificarRemedio($agenda_id, $paciente_id)
    {
        // Verificar se existem prescrições de remédio para a agenda e o paciente especificados
        $remedios = Remedio::where('agenda_id', $agenda_id)
            ->where('paciente_id', $paciente_id)
            ->get();

        if ($remedios->isNotEmpty()) {
            // Se as prescrições existirem, retornar os dados das prescrições
            return response()->json(['data' => $remedios]);
        } else {
            // Se as prescrições não existirem, retornar uma mensagem de erro
            return response()->json(['error' => 'Nenhuma prescrição de remédio encontrada'], 404);
        }
    }

    public function storeExame(Request $request)
    {
        $paciente_id = $request->input('paciente_id');
        $agenda_id = $request->input('agenda_id');
        $profissional_id = $request->input('profissional_id');

        // Processar os medicamentos
        $procedimento_ids = $request->input('procedimento_id', []);

        // Verificar se existem múltiplas linhas e processar cada uma
        foreach ($procedimento_ids as $index => $procedimento_id) {
            if (!empty($procedimento_id)) {
                // Verificar se já existe uma prescrição com esses dados
                $existingPrescricao = Exames::where('agenda_id', $agenda_id)
                    ->where('profissional_id', $profissional_id)
                    ->where('paciente_id', $paciente_id)
                    ->where('procedimento_id', $procedimento_id)
                    ->first();

                if (!$existingPrescricao) {
                    // Criar uma nova prescrição se não existir
                    Exames::create([
                        'agenda_id' => $agenda_id,
                        'profissional_id' => $profissional_id,
                        'paciente_id' => $paciente_id,
                        'procedimento_id' => $procedimento_id
                    ]);
                } else {
                    // Atualizar a prescrição existente
                    $existingPrescricao->update([
                        'procedimento_id' => $procedimento_ids[$index]
                    ]);
                }
            }
        }

        return response()->noContent();
    }

    public function verificarExame($agenda_id, $paciente_id)
    {
        // Verificar se existem exames para a agenda e o paciente especificados
        $exames = Exames::where('agenda_id', $agenda_id)
            ->where('paciente_id', $paciente_id)
            ->get();

        if ($exames->isNotEmpty()) {
            // Se os exames existirem, retornar os dados dos exames
            return response()->json(['data' => $exames]);
        } else {
            // Se os exames não existirem, retornar uma mensagem de erro
            return response()->json(['error' => 'Nenhum exame encontrado'], 404);
        }
    }

    public function index1(Request $request)
{
    // Recupera todos os profissionais e pacientes para o dropdown
    $profissional = Profissional::join('users', 'profissionals.id', '=', 'users.profissional_id')
        ->where('users.permisao_id', 1)
        ->get(['profissionals.id', 'profissionals.name']);
    $paciente = Pacientes::all();

    // Filtra os parâmetros de busca da requisição
    $data = $request->input('data', null);  // Permite data vazia
    $profissional_id = $request->input('profissional_id', null);  // Permite profissional_id vazio
    $paciente_id = $request->input('paciente_id', null);  // Permite paciente_id vazio

    // Monta a consulta com joins e leftJoins
    $query = DB::table('agendas as ag')
        ->select(
            'ag.id as consulta', 
            'ag.data',
            'pa.id as paciente_id',
            'pa.name as paciente',
            'pr.name as profissional',
            'prc.procedimento as procedimento',
            DB::raw('STRING_AGG(DISTINCT an.id::text, \',\') as anamneses_ids'),
            DB::raw('STRING_AGG(DISTINCT at.id::text, \',\') as atendimentos_ids'),
            DB::raw('STRING_AGG(DISTINCT ex.id::text, \',\') as exames_ids'),
            DB::raw('STRING_AGG(DISTINCT re.id::text, \',\') as remedios_ids'),
            'an.profissional_id as an_profissional_id',
            'an.pa as an_pa',
            'an.temp as an_temp',
            'an.peso as an_peso',
            'an.altura as an_altura',
            'an.gestante as an_gestante',
            'an.dextro as an_dextro',
            'an.spo2 as an_spo2',
            'an.fc as an_fc',
            'an.fr as an_fr',
            'an.acolhimento as an_acolhimento',
            'an.acolhimento1 as an_acolhimento1',
            'an.acolhimento2 as an_acolhimento2',
            'an.acolhimento3 as an_acolhimento3',
            'an.acolhimento4 as an_acolhimento4',
            'an.alergia1 as an_alergia1',
            'an.alergia2 as an_alergia2',
            'an.alergia3 as an_alergia3',
            'an.anamnese as an_anamnese',
            'at.queixas as at_queixas',
            'at.atestado as at_atestado',
            'at.evolucao as at_evolucao',
            'at.condicao as at_condicao',
            DB::raw('STRING_AGG(DISTINCT proc2.procedimento::text, \',\') as exames'),
            DB::raw('STRING_AGG(DISTINCT med.nome::text, \',\') as remedios'),
            DB::raw('STRING_AGG(DISTINCT re.dose::text, \',\') as doses'),
            DB::raw('STRING_AGG(DISTINCT re.horas::text, \',\') as horas')
        )
        ->join('profissionals as pr', 'ag.profissional_id', '=', 'pr.id')
        ->join('pacientes as pa', 'ag.paciente_id', '=', 'pa.id')
        ->join('procedimentos as prc', 'ag.procedimento_id', '=', 'prc.procedimento')
        ->leftJoin('anamneses as an', function ($join) use ($data) {
            $join->on('an.paciente_id', '=', 'pa.id');
            if (!empty($data)) {
                $join->where(DB::raw('DATE(an.created_at)'), '=', $data);
            }
        })
        ->leftJoin('atendimentos as at', function ($join) use ($data) {
            $join->on('at.paciente_id', '=', 'pa.id');
            if (!empty($data)) {
                $join->where(DB::raw('DATE(at.created_at)'), '=', $data);
            }
        })
        ->leftJoin('exames as ex', function ($join) use ($data) {
            $join->on('ex.paciente_id', '=', 'pa.id');
            if (!empty($data)) {
                $join->where(DB::raw('DATE(ex.created_at)'), '=', $data);
            }
        })
        ->leftJoin('remedios as re', function ($join) use ($data) {
            $join->on('re.paciente_id', '=', 'pa.id');
            if (!empty($data)) {
                $join->where(DB::raw('DATE(re.created_at)'), '=', $data);
            }
        })
        ->leftJoin('procedimentos as proc2', 'ex.procedimento_id', '=', 'proc2.id')
        ->leftJoin('medicamentos as med', 're.medicamento_id', '=', 'med.id');

    // Aplica os filtros apenas se os parâmetros não estiverem vazios
    if (!empty($data)) {
        $query->where('ag.data', $data);
    }
    if (!empty($paciente_id)) {
        $query->where('pa.id', $paciente_id);
    }
    if (!empty($profissional_id)) {
        $query->where('an.profissional_id', $profissional_id);
    }

    // Finaliza a montagem da consulta
    $historico = $query->groupBy(
            'ag.id', 'ag.data', 'pa.id', 'pa.name', 'pr.name', 'prc.procedimento', 'an.profissional_id',
            'an.pa', 'an.temp', 'an.peso', 'an.altura', 'an.gestante', 'an.dextro', 'an.spo2',
            'an.fc', 'an.fr', 'an.acolhimento', 'an.acolhimento1', 'an.acolhimento2', 'an.acolhimento3',
            'an.acolhimento4', 'an.alergia1', 'an.alergia2', 'an.alergia3', 'an.anamnese',
            'at.queixas', 'at.atestado', 'at.evolucao', 'at.condicao'
        )
        ->orderBy('ag.data', 'asc')
        ->get();

    // Convert the grouped strings back to arrays
    foreach ($historico as $h) {
        $h->exames = !empty($h->exames) ? explode(',', $h->exames) : [];
        $h->remedios = !empty($h->remedios) ? explode(',', $h->remedios) : [];
        $h->doses = !empty($h->doses) ? explode(',', $h->doses) : [];
        $h->horas = !empty($h->horas) ? explode(',', $h->horas) : [];
    }

    return view('atendimentos.prontuarios', compact('profissional', 'paciente', 'historico'));
}

    public function ficha_atendimento(Request $request){

        // Obtenha todos os dados do formulário
        $dadosFormulario = $request->all();
        
        // Retorne a view 'ficha' passando os dados
        return view('atendimentos.ficha')->with('dadosFormulario', $dadosFormulario);
    }
}
