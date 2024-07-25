<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Anamnese;
use App\Models\Atendimentos;
use App\Models\Empresas;
use App\Models\Exames;
use App\Models\Medicamento;
use App\Models\Pacientes;
use App\Models\Procedimentos;
use App\Models\Profissional;
use App\Models\Remedio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->leftJoin('anamneses as an', 'an.agenda_id', '=', 'ag.id')
            ->leftJoin('atendimentos as at', 'at.agenda_id', '=', 'ag.id')
            ->leftJoin('exames as ex', 'ex.agenda_id', '=', 'ag.id')
            ->leftJoin('remedios as re', 're.agenda_id', '=', 'ag.id')
            ->leftJoin('procedimentos as proc2', 'ex.procedimento_id', '=', 'proc2.id')
            ->leftJoin('medicamentos as med', 're.medicamento_id', '=', 'med.id')
            ->select(
                'ag.data',
                'pa.id as paciente_id',
                DB::raw('STRING_AGG(DISTINCT proc2.procedimento::text, \',\') as procedimentos'),
                DB::raw('STRING_AGG(DISTINCT med.nome::text, \',\') as medicamentos'),
                DB::raw('STRING_AGG(DISTINCT re.dose::text, \',\') as dose'),
                DB::raw('STRING_AGG(DISTINCT re.horas::text, \',\') as horas'),
                'pro.name as an_profissional_id',
                'an.pa as an_pa',
                'an.imc as imc',
                'an.classificacao as classificacao',
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
                'an.fc',
                'an.imc',
                'an.classificacao'
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
                'imc' => $request->input('imc'),
                'classificacao' => $request->input('classificacao'),
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
                'agenda_id' => $request->input('agenda_id'),
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
                'imc' => $request->input('imc'),
                'classificacao' => $request->input('classificacao'),
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
                'agenda_id' => $request->input('agenda_id'),
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
        ->leftJoin('permissao_user', 'users.id', '=', 'permissao_user.user_id')
        ->where('permissao_user.user_id', 1)
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
                'pa.cpf as cpf',
                'pa.nasc as nasc',
                'pa.nome_mae as mae',
                'pa.genero as genero',
                'pa.id as paciente_id',
                'pa.name as paciente',
                'pr.name as profissional',
                'ag.procedimento_id as procedimento',
                'an.profissional_id as an_profissional_id',
                'an.pa as an_pa',
                'an.imc as imc',
                'an.classificacao as classificacao',
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
            ->leftJoin('anamneses as an', 'an.agenda_id', '=', 'ag.id')
            ->leftJoin('atendimentos as at', 'at.agenda_id', '=', 'ag.id')
            ->leftJoin('exames as ex', 'ex.agenda_id', '=', 'ag.id')
            ->leftJoin('remedios as re', 're.agenda_id', '=', 'ag.id')
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
                'ag.id', 'ag.data', 'ag.procedimento_id', 'pa.id', 'pa.name', 'pr.name', 'an.profissional_id',
                'an.pa', 'an.temp', 'an.peso', 'an.altura', 'an.gestante', 'an.dextro', 'an.spo2',
                'an.fc', 'an.fr', 'an.acolhimento', 'an.acolhimento1', 'an.acolhimento2', 'an.acolhimento3',
                'an.acolhimento4', 'an.alergia1', 'an.alergia2', 'an.alergia3', 'an.anamnese',
                'at.queixas', 'at.atestado', 'at.evolucao', 'at.condicao','an.imc','an.classificacao'
            )
            ->orderBy('ag.data', 'desc')
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

    public function ficha_atendimento(Request $request)
    {
        // Obtenha todos os dados do formulário
        $dadosFormulario = $request->all();
        
        // Obtenha todos os dados das empresas
        $empresa = Empresas::all();
        
        // Retorne a view 'ficha' passando os dados do formulário e os dados das empresas
        return view('atendimentos.ficha', compact('dadosFormulario', 'empresa'));
    }

    public function processarFormulario(Request $request)
    {
        $agendaId = $request->input('agenda_id'); // Certifique-se de que o ID da agenda está sendo enviado no formulário
    
        // Atualiza o status na tabela agendas
        DB::table('agendas')
            ->where('id', $agendaId)
            ->update(['status' => 'FINALIZADO']);
    
        // Salva os dados na sessão
        $dadosFormulario = $request->only([
            'peso', 'altura', 'imc', 'classificacao', 'pa', 'temp', 'gestante', 'dextro', 'spo2',
            'fc', 'fr', 'acolhimento', 'acolhimento1', 'acolhimento2', 'acolhimento3', 'acolhimento4',
            'alergia1', 'alergia2', 'alergia3', 'anamnese', 'evolucao', 'queixas', 'condicao', 'agenda_id'
        ]);
    
        // Adiciona exames e medicamentos aos dados do formulário
        $dadosFormulario['exames'] = $request->input('exames', []);
        $dadosFormulario['medicamentos'] = $request->input('medicamentos', []);
    
        $request->session()->put('dadosFormulario', $dadosFormulario);
    
        // Retorna uma resposta JSON indicando sucesso
        return response()->json(['success' => true]);
    }
    
    public function mostrarFicha2(Request $request)
    {
        $empresa = Empresas::all();
        // Recupera os dados da sessão
        $dadosFormulario = $request->session()->get('dadosFormulario', []);

        // Retorna a view com os dados
        return view('atendimentos.fichaAtendimento', [
            'dadosFormulario' => $dadosFormulario,
            'empresa' => $empresa
        ]);
    }


    public function solicitacoes(Request $request)
    {
        $selectedOption = $request->input('selectedOption');
        $pacienteId = $request->input('paciente_id');
        $agendaId = $request->input('agenda_id');
        $profissionalId = $request->input('profissional_id');
        $dia = $request->input('dia_id');

        // Debugging output
        if (!$dia && $selectedOption === 'atestado') {
            return response()->json(['error' => 'Missing parameter dia'], 400);
        }

        // Determine the redirect URL based on the selected option
        $redirectUrl = '';
        switch ($selectedOption) {
            case 'atestado':
                $redirectUrl = route('formulario.atestado', [
                    'paciente_id' => $pacienteId,
                    'agenda_id' => $agendaId,
                    'profissional_id' => $profissionalId,
                    'dia' => $dia
                ]);
                break;
            case 'receita':
                $redirectUrl = route('formulario.receita', [
                    'paciente_id' => $pacienteId,
                    'agenda_id' => $agendaId,
                    'profissional_id' => $profissionalId
                ]);
                break;
            case 'solicitacao_exame':
                $redirectUrl = route('formulario.exame', [
                    'paciente_id' => $pacienteId,
                    'agenda_id' => $agendaId,
                    'profissional_id' => $profissionalId
                ]);
                break;
            default:
                return response()->json(['error' => 'Opção inválida'], 400);
        }

        return response()->json(['redirect_url' => $redirectUrl]);
    }

    public function atestadoView($paciente_id, $agenda_id, $profissional_id, $dia, Request $request)
    {
        $empresas = Empresas::all();
        
        $paciente = Pacientes::where('name', $paciente_id)->first();
        if (!$paciente) {
            abort(404, 'Paciente não encontrado');
        }

        $profissional = DB::table('profissionals')
            ->select('profissionals.name', 'tp.nome as tipo', 'tp.conselho as conselho2', 'profissionals.conselho', 'e.especialidade')
            ->join('especialidade_profissional as ep', 'ep.profissional_id', '=', 'profissionals.id')
            ->join('tipo_profs as tp', 'tp.id', '=', 'profissionals.tipoprof_id')
            ->leftJoin('especialidades as e', 'ep.especialidade_id', '=', 'e.id')
            ->where('profissionals.name', $profissional_id)
            ->first();

        if (!$profissional) {
            abort(404, 'Profissional não encontrado');
        }

        $currentDate = now()->format('Y-m-d');

        return view('formulario.atestado', compact('paciente_id', 'agenda_id', 'profissional_id', 'dia', 'empresas', 'paciente', 'profissional', 'currentDate'));
    }

    public function receitaView($paciente_id, $agenda_id, $profissional_id, Request $request)
    {
        $empresas = Empresas::all();
        
        $paciente = Pacientes::where('name', $paciente_id)->first();
        if (!$paciente) {
            abort(404, 'Paciente não encontrado');
        }
    
        $profissional = DB::table('profissionals')
            ->select('profissionals.name', 'tp.nome as tipo', 'tp.conselho as conselho2', 'profissionals.conselho', 'e.especialidade')
            ->join('especialidade_profissional as ep', 'ep.profissional_id', '=', 'profissionals.id')
            ->join('tipo_profs as tp', 'tp.id', '=', 'profissionals.tipoprof_id')
            ->leftJoin('especialidades as e', 'ep.especialidade_id', '=', 'e.id')
            ->where('profissionals.name', $profissional_id)
            ->first();
    
        if (!$profissional) {
            abort(404, 'Profissional não encontrado');
        }
    
        $remedios = DB::table('remedios as re')
            ->select('med.nome as remedios', 're.dose', 're.horas')
            ->join('medicamentos as med', 're.medicamento_id', '=', 'med.id')
            ->join('profissionals as pro', 're.profissional_id', '=', 'pro.id')
            ->join('pacientes as pac', 're.paciente_id', '=', 'pac.id')
            ->join('agendas as ag', 're.agenda_id', '=', 'ag.id')
            ->where('pro.name', $profissional_id)
            ->where('pac.name', $paciente_id)
            ->where('re.agenda_id', $agenda_id)
            ->get();
    
        $currentDate = now()->format('Y-m-d');
    
        return view('formulario.receita', compact('paciente_id', 'agenda_id', 'profissional_id', 'empresas', 'paciente', 'profissional', 'currentDate', 'remedios'));
    }
    

    public function exameView($paciente_id, $agenda_id, $profissional_id, Request $request)
    {
        $empresas = Empresas::all();
        
        $paciente = Pacientes::where('name', $paciente_id)->first();
        if (!$paciente) {
            abort(404, 'Paciente não encontrado');
        }
    
        $profissional = DB::table('profissionals')
            ->select('profissionals.name', 'tp.nome as tipo', 'tp.conselho as conselho2', 'profissionals.conselho', 'e.especialidade')
            ->join('especialidade_profissional as ep', 'ep.profissional_id', '=', 'profissionals.id')
            ->join('tipo_profs as tp', 'tp.id', '=', 'profissionals.tipoprof_id')
            ->leftJoin('especialidades as e', 'ep.especialidade_id', '=', 'e.id')
            ->where('profissionals.name', $profissional_id)
            ->first();
    
        if (!$profissional) {
            abort(404, 'Profissional não encontrado');
        }
    
        $exames = DB::table('exames as re')
            ->select('proc.procedimento', 'proc.codigo')
            ->join('procedimentos as proc', 're.procedimento_id', '=', 'proc.id')
            ->join('profissionals as pro', 're.profissional_id', '=', 'pro.id')
            ->join('pacientes as pac', 're.paciente_id', '=', 'pac.id')
            ->join('agendas as ag', 're.agenda_id', '=', 'ag.id')
            ->where('pro.name', $profissional_id)
            ->where('pac.name', $paciente_id)
            ->where('re.agenda_id', $agenda_id)
            ->get();
    
        $currentDate = now()->format('Y-m-d');
    
        return view('formulario.exame', compact('paciente_id', 'agenda_id', 'profissional_id', 'empresas', 'paciente', 'profissional', 'currentDate', 'exames'));
    }
}
