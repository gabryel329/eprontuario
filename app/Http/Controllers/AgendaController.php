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
use Log;

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
                    ->whereNotNull('seg')
                    ->orderBy('hora', 'asc')
                    ->get();
                break;
            case 2: // Terça-feira
                $disponibilidades = Disponibilidade::where('profissional_id', $profissionalId)
                    ->where('especialidade_id', $especialidadeId)
                    ->whereNotNull('ter')
                    ->orderBy('hora', 'asc')
                    ->get();
                break;
            case 3: // Quarta-feira
                $disponibilidades = Disponibilidade::where('profissional_id', $profissionalId)
                    ->where('especialidade_id', $especialidadeId)
                    ->whereNotNull('qua')
                    ->orderBy('hora', 'asc')
                    ->get();
                break;
            case 4: // Quinta-feira
                $disponibilidades = Disponibilidade::where('profissional_id', $profissionalId)
                    ->where('especialidade_id', $especialidadeId)
                    ->whereNotNull('qui')
                    ->orderBy('hora', 'asc')
                    ->get();
                break;
            case 5: // Sexta-feira
                $disponibilidades = Disponibilidade::where('profissional_id', $profissionalId)
                    ->where('especialidade_id', $especialidadeId)
                    ->whereNotNull('sex')
                    ->orderBy('hora', 'asc')
                    ->get();
                break;
            case 6: // Sábado
                $disponibilidades = Disponibilidade::where('profissional_id', $profissionalId)
                    ->where('especialidade_id', $especialidadeId)
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
                'procedimento_id' => $disponibilidade->procedimento_id,
                'name' => $disponibilidade->name,
                'celular' => $disponibilidade->celular,
                'matricula' => $disponibilidade->matricula,
                'codigo' => $disponibilidade->codigo,
                'convenio_id' => $disponibilidade->convenio_id
            ];
        }

        return response()->json([
            'horarios' => $horariosDisponiveis,
            'convenios' => $convenios,
            'pacientes' => $pacientes,
            'procedimentos' => $procedimentos
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
            $procedimentoId = $agendamentoData['procedimento'];
            $paciente = $agendamentoData['paciente'];
            $celular = $agendamentoData['celular'];
            $matricula = $agendamentoData['matricula'];
            $codigo = $agendamentoData['codigo'];
            $convenioId = $agendamentoData['convenio'];
    
            // Verifica se já existe uma agenda com a mesma data, hora, profissional e especialidade
            $existeAgenda = Agenda::where('data', $data)
                ->where('hora', $hora)
                ->where('profissional_id', $profissionalId)
                ->first();
    
            if ($existeAgenda) {
                // Atualiza a agenda existente
                $existeAgenda->procedimento_id = $procedimentoId;
                $existeAgenda->status = "MARCADO";
                $existeAgenda->name = $paciente;
                $existeAgenda->celular = $celular;
                $existeAgenda->matricula = $matricula;
                $existeAgenda->convenio_id = $convenioId;
                $existeAgenda->codigo = $codigo;
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
                $novoAgendamento->celular = $celular;
                $novoAgendamento->matricula = $matricula;
                $novoAgendamento->profissional_id = $profissionalId;
                $novoAgendamento->convenio_id = $convenioId;
                $novoAgendamento->especialidade_id = $especialidadeId;
                $novoAgendamento->codigo = $codigo;
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
                        'convenio_id' => $convenioId,
                        'data' => $data // Certifique-se de usar o formato correto aqui
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
        $diasSemana = ['dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sab'];

        // Convertendo os horários para o formato DateTime
        $inicio = DateTime::createFromFormat('H:i', $inicio);
        $fim = DateTime::createFromFormat('H:i', $fim);
        $intervalo = (int) $intervalo;

        // Calcula os horários disponíveis para cada dia selecionado
        $disponibilidades = [];
        foreach ($diasSemana as $dia) {
            if ($request->input($dia)) { // Verifica se o dia foi selecionado
                $tempInicio = clone $inicio; // Clonar o objeto DateTime para não alterar a referência original
                while ($tempInicio <= $fim) {
                    $disponibilidade = [
                        'profissional_id' => $profissionalId,
                        'especialidade_id' => $especialidadeId,
                        'turno' => $turno,
                        'hora' => $tempInicio->format('H:i'),
                        'material' => null,
                        'medicamento' => null,
                        'inicio' => $inicio->format('H:i'),
                        'fim' => $fim->format('H:i'),
                        'intervalo' => $intervalo
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

        // Verifica se já existem registros para o profissional_id, especialidade_id e turno
        $existingDisponibilidade = DB::table('disponibilidades')
            ->where('profissional_id', $profissionalId)
            ->where('especialidade_id', $especialidadeId)
            ->where('turno', $turno)
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
            return response()->json(['error' => 'Profissional nÃ£o encontrado.'], 404);
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
                return response()->json(['error' => 'JÃÂ¡ existe Consulta para este horÃÂ¡rio.'], 400);
            }

            return redirect()->back()->with('error', 'JÃÂ¡ existe Consulta para este horÃÂ¡rio.');
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
                return response()->json(['error' => 'Paciente nÃÂ£o vinculado.'], 400);
            }
            $agenda->status = $request->status;
            $agenda->save();
            return response()->json(['success' => 'Status atualizado com sucesso.']);
        } else {
            return response()->json(['error' => 'Agenda nÃÂ£o encontrada.'], 404);
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
        $agenda->hora = $request->hora;
        $agenda->paciente_id = $request->paciente_id;
        $agenda->name = $request->name;
        $agenda->celular = $request->celular;
        $agenda->procedimento_id = $request->procedimento_id;

        // Salvar as mudanÃÂ§as
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
            ->where('status', 'EVADIO')
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
