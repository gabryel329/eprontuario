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
                if (!is_null($disponibilidade->manha_seg)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('manha_seg')
                        ->pluck('hora');
                }
                break;
            case 2: // Terça-feira
                if (!is_null($disponibilidade->manha_ter)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('manha_ter')
                        ->pluck('hora');
                }
                break;
            case 3: // Quarta-feira
                if (!is_null($disponibilidade->manha_qua)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('manha_qua')
                        ->pluck('hora');
                }
                break;
            case 4: // Quinta-feira
                if (!is_null($disponibilidade->manha_qui)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('manha_qui')
                        ->pluck('hora');
                }
                break;
            case 5: // Sexta-feira
                if (!is_null($disponibilidade->manha_sex)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('manha_sex')
                        ->pluck('hora');
                }
                break;
            case 6: // Sábado
                if (!is_null($disponibilidade->manha_sab)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('manha_sab')
                        ->pluck('hora');
                }
                break;
            case 7: // Domingo
                if (!is_null($disponibilidade->manha_dom)) {
                    $horariosDisponiveis = DB::table('disponibilidades')
                        ->where('profissional_id', $profissionalId)
                        ->where('especialidade_id', $especialidadeId)
                        ->whereNotNull('manha_dom')
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
        $inicio = $request->input('inihonorariomanha'); // Formato: HH:MM
        $intervalo = $request->input('interhonorariomanha'); // Intervalo em minutos
        $fim = $request->input('fimhonorariomanha'); // Formato: HH:MM

        // Coleta dos dados de disponibilidade para os dias da semana
        $manha_dom = $request->input('manha_dom') ? 'S' : null;
        $manha_seg = $request->input('manha_seg') ? 'S' : null;
        $manha_ter = $request->input('manha_ter') ? 'S' : null;
        $manha_qua = $request->input('manha_qua') ? 'S' : null;
        $manha_qui = $request->input('manha_qui') ? 'S' : null;
        $manha_sex = $request->input('manha_sex') ? 'S' : null;
        $manha_sab = $request->input('manha_sab') ? 'S' : null;

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
                'manha_dom' => $manha_dom,
                'manha_seg' => $manha_seg,
                'manha_ter' => $manha_ter,
                'manha_qua' => $manha_qua,
                'manha_qui' => $manha_qui,
                'manha_sex' => $manha_sex,
                'manha_sab' => $manha_sab,
                'inicio' => $inicio->format('H:i'),
                'fim' => $fim->format('H:i'),
                'intervalo' => $intervalo
            ];

            $disponibilidades[] = $disponibilidade;

            // Incrementa o horário pelo intervalo
            $inicio->modify("+{$intervalo} minutes");
        }

        // Verifica se já existem registros para o profissional_id, especialidade_id e turno
        $existingDisponibilidades = \DB::table('disponibilidades')
            ->where('profissional_id', $profissionalId)
            ->where('especialidade_id', $especialidadeId)
            ->where('turno', $turno)
            ->pluck('hora')
            ->toArray(); // Converte a coleção para um array

        // Filtra as novas disponibilidades para remover aquelas que já existem
        $newDisponibilidades = array_filter($disponibilidades, function ($disponibilidade) use ($existingDisponibilidades) {
            return !in_array($disponibilidade['hora'], $existingDisponibilidades);
        });

        // Insere as novas disponibilidades no banco de dados
        \DB::table('disponibilidades')->insert($newDisponibilidades);

        // Redireciona com sucesso
        return redirect()->route('profissional.index1')->with('success', 'Disponibilidade salva com sucesso!');
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
            'domingo' => $profissional->manha_dom,
            'segunda' => $profissional->manha_seg,
            'terca' => $profissional->manha_ter,
            'quarta' => $profissional->manha_qua,
            'quinta' => $profissional->manha_qui,
            'sexta' => $profissional->manha_sex,
            'sabado' => $profissional->manha_sab,
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
