<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Convenio;
use App\Models\Disponibilidade;
use App\Models\Especialidade;
use App\Models\Feriado;
use App\Models\Pacientes;
use App\Models\Painel;
use App\Models\Procedimentos;
use App\Models\Profissional;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $agendas = Agenda::all();
        $pacientes = Pacientes::all();
        $profissional = Profissional::whereNotNull('conselho')->get();
        $procedimentos = Procedimentos::all();
        $feriado = Feriado::all();

        return view('agenda.criar', compact(['agendas', 'pacientes', 'profissional', 'procedimentos', 'feriado']));
    }

    public function geraAgenda(Request $request)
    {
        $profissionais = Profissional::whereNotNull('conselho')->get();

        return view('agenda.geraragenda', compact(['profissionais']));
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

    public function verificarDisponibilidade($profissionalId, $especialidadeId, $data)
    {
        $convenios = Convenio::all(); // Obter todos os convênios
        $pacientes = Pacientes::all();
        $procedimentos = Procedimentos::all();

        $diaDaSemana = date('N', strtotime($data));

        $disponibilidade = Disponibilidade::where('profissional_id', $profissionalId)
            ->where('especialidade_id', $especialidadeId)
            ->first();

        if (!$disponibilidade) {
            return response()->json(['horarios' => [], 'convenios' => $convenios]); // Retorna uma lista vazia se não houver disponibilidade
        }

        $horariosDisponiveis = [];

        switch ($diaDaSemana) {
            case 1: // Segunda-feira
                if (!is_null($disponibilidade->seg)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('seg')
                        ->pluck('hora');
                }
                break;
            case 2: // Terça-feira
                if (!is_null($disponibilidade->ter)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('ter')
                        ->pluck('hora');
                }
                break;
            case 3: // Quarta-feira
                if (!is_null($disponibilidade->qua)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('qua')
                        ->pluck('hora');
                }
                break;
            case 4: // Quinta-feira
                if (!is_null($disponibilidade->qui)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('qui')
                        ->pluck('hora');
                }
                break;
            case 5: // Sexta-feira
                if (!is_null($disponibilidade->sex)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('sex')
                        ->pluck('hora');
                }
                break;
            case 6: // Sábado
                if (!is_null($disponibilidade->sab)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('sab')
                        ->pluck('hora');
                }
                break;
            case 7: // Domingo
                if (!is_null($disponibilidade->dom)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('dom')
                        ->pluck('hora');
                }
                break;
        }

        return response()->json([
            'horarios' => $horariosDisponiveis,
            'convenios' => $convenios,
            'pacientes' => $pacientes,
            'procedimentos' => $procedimentos
        ]);
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
        // Coleta dos dados de disponibilidade para os dias da semana
        $dom = $request->input('dom') ? 'S' : null;
        $seg = $request->input('seg') ? 'S' : null;
        $ter = $request->input('ter') ? 'S' : null;
        $qua = $request->input('qua') ? 'S' : null;
        $qui = $request->input('qui') ? 'S' : null;
        $sex = $request->input('sex') ? 'S' : null;
        $sab = $request->input('sab') ? 'S' : null;
        

        // Convertendo os horários para o formato DateTime
        $inicio = \DateTime::createFromFormat('H:i', $inicio);
        $fim = \DateTime::createFromFormat('H:i', $fim);
        $intervalo = (int) $intervalo;

        // Calcula os horários disponíveis
        $disponibilidades = [];
        while ($inicio <= $fim) {
            $disponibilidade = [
                'profissional_id' => $profissionalId,
                'especialidade_id' => $especialidadeId,
                'turno' => $turno,
                'hora' => $inicio->format('H:i'),
                'material' => null,
                'medicamento' => null,
                'dom' => $dom,
                'seg' => $seg,
                'ter' => $ter,
                'qua' => $qua,
                'qui' => $qui,
                'sex' => $sex,
                'sab' => $sab,
                'inicio' => $inicio->format('H:i'),
                'fim' => $fim->format('H:i'),
                'intervalo' => $intervalo
            ];

            $disponibilidades[] = $disponibilidade;

            // Incrementa o horário pelo intervalo
            $inicio->modify("+{$intervalo} minutes");
        }

        // Verifica se já existem registros para o profissional_id, especialidade_id e turno
        $existingDisponibilidade = \DB::table('disponibilidades')
            ->where('profissional_id', $profissionalId)
            ->where('especialidade_id', $especialidadeId)
            ->where('turno', $turno)
            ->first();

        if ($existingDisponibilidade) {
            // Se existir, faz o update
            \DB::table('disponibilidades')
                ->where('profissional_id', $profissionalId)
                ->where('especialidade_id', $especialidadeId)
                ->where('turno', $turno)
                ->delete(); // Remove as antigas disponibilidades para inserir as novas

            // Insere as novas disponibilidades
            \DB::table('disponibilidades')->insert($disponibilidades);

            // Redireciona com sucesso para update
            return redirect()->route('profissional.index')->with('success', 'Disponibilidades atualizadas com sucesso!');
        } else {
            // Caso não existam registros, faz o insert
            \DB::table('disponibilidades')->insert($disponibilidades);
            
            // Redireciona com sucesso para store
            return redirect()->back()->with('success', 'Disponibilidades cadastradas com sucesso!');
        }
    }

    public function agendar(Request $request)
    {
        // Processar o agendamento
        $agendamento = new Agenda();
        $agendamento->hora = $request->input('horario');
        $agendamento->data = $request->input('data');
        $agendamento->procedimento_id = $request->input('procedimento');
        $agendamento->status = 'MARCADO'; // Definindo o status como MARCADO
        $agendamento->name = $request->input('paciente'); // Assumindo que paciente é o nome
        $agendamento->celular = $request->input('celular');
        $agendamento->profissional_id = $request->input('profissionalId');
        $agendamento->especialidade_id = $request->input('especialidadeId');
        $agendamento->save();

        return response()->json(['success' => true, 'message' => 'Agendamento realizado com sucesso!']);
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
        $procedimentos = Procedimentos::all();
        $pacientes = Pacientes::all();
        $profissionals = Profissional::whereNotNull('conselho')->get();
        $agendas = collect();

        // Store form values in the session
        if ($request->has('data') || $request->has('profissional_id')) {
            $query = Agenda::query();

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

            $agendas = $query->orderBy('hora', 'asc')->get();
        } else {
            // Clear session data if no filter is applied
            session()->forget(['data', 'profissional_id']);
        }

        return view('agenda.lista', compact('profissionals', 'agendas', 'pacientes', 'procedimentos'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Capitalize the input
        $data = $request->input('data');
        $hora = $request->input('hora');
        $name = ucfirst($request->input('name'));
        $sobrenome = ucfirst($request->input('sobrenome'));
        $celular = $request->input('celular');
        $procedimento_id = $request->input('procedimento_id');
        $profissional_id = $request->input('profissional_id');
        $paciente_id = $request->input('paciente_id');

        // Check if the agenda already exists
        $existeAgenda = Agenda::where('data', $data)
            ->where('hora', $hora)
            ->first();

        if ($existeAgenda) {
            if ($request->ajax()) {
                return response()->json(['error' => 'JÃ¡ existe Consulta para este horÃ¡rio.'], 400);
            }

            return redirect()->back()->with('error', 'JÃ¡ existe Consulta para este horÃ¡rio.');
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

        $agenda = Agenda::create($agendaData);

        if ($request->ajax()) {
            return response()->json(['success' => 'Consulta Criada com sucesso!', 'agenda' => $agenda]);
        }

        return redirect()->back()->with('success', 'Consulta Criada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agenda $agenda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request)
    {
        $agenda = Agenda::find($request->id);
        if ($agenda) {
            if ($request->status == 'CHEGOU' && is_null($agenda->paciente_id)) {
                return response()->json(['error' => 'Paciente nÃ£o vinculado.'], 400);
            }
            $agenda->status = $request->status;
            $agenda->save();
            return response()->json(['success' => 'Status atualizado com sucesso.']);
        } else {
            return response()->json(['error' => 'Agenda nÃ£o encontrada.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // Validar os dados do request (opcional, mas recomendado)
        $request->validate([
            'profissional_id' => 'required|exists:profissionals,id',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'paciente_id' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        // Encontrar a agenda pelo ID
        $agenda = Agenda::findOrFail($id);

        // Atualizar os dados da agenda
        $agenda->profissional_id = $request->profissional_id;
        $agenda->data = $request->data;
        $agenda->particular = $request->particular;
        $agenda->hora = $request->hora;
        $agenda->paciente_id = $request->paciente_id;
        $agenda->name = $request->name;
        $agenda->celular = $request->celular;
        $agenda->procedimento_id = $request->procedimento_id;

        // Salvar as mudanÃ§as
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
            ->where('status', 'MARCADO')
            ->whereNotNull('paciente_id')
            ->orderBy('hora', 'asc')
            ->get();

        $agendasEvadio = Agenda::where('profissional_id', $profissionalId)
            ->where('data', $data)
            ->where('status', 'EVADIO')
            ->whereNotNull('paciente_id')
            ->orderBy('hora', 'asc')
            ->get();

        $agendasCancelado = Agenda::where('profissional_id', $profissionalId)
            ->where('data', $data)
            ->where('status', 'CANCELADO')
            ->whereNotNull('paciente_id')
            ->orderBy('hora', 'asc')
            ->get();

        $agendasFinalizado = Agenda::where('profissional_id', $profissionalId)
            ->where('data', $data)
            ->where('status', 'FINALIZADO')
            ->whereNotNull('paciente_id')
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

        // Verificar se jÃ¡ existe um registro com o mesmo agenda_id
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
            // Se nÃ£o existe, crie um novo registro
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

        // Verificar se a data Ã© um domingo
        $isSunday = Carbon::parse($data)->isSunday();

        // Verificar se a data Ã© um feriado
        $isHoliday = Feriado::where('data', $data)->exists();

        return response()->json([
            'isHoliday' => $isHoliday,
            'isSunday' => $isSunday,
            'data' => $data
        ]);
    }
}
