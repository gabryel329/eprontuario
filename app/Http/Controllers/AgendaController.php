<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Pacientes;
use App\Models\Painel;
use App\Models\Procedimentos;
use App\Models\Profissional;
use App\Models\User;
use Carbon\Carbon;
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

        return view('agenda.criar', compact(['agendas', 'pacientes', 'profissional', 'procedimentos']));
    }

    public function index1(Request $request)
    {
        $procedimentos = Procedimentos::all();
        $pacientes = Pacientes::all();
        $profissionals = Profissional::whereNotNull('conselho')->get();
        $agendas = collect();

        // Store form values in the session
        if ($request->has('data') && $request->has('profissional_id')) {
            session([
                'data' => $request->data,
                'profissional_id' => $request->profissional_id
            ]);

            $agendas = Agenda::where('profissional_id', $request->profissional_id)
                ->where('data', $request->data)
                ->orderBy('hora', 'asc')
                ->get();
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
        $particular = $request->input('particular');
        $procedimento_id = $request->input('procedimento_id');
        $profissional_id = $request->input('profissional_id');
        $paciente_id = $request->input('paciente_id');

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
            'particular' => $particular,
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

        // Verificar se já existe um registro com o mesmo agenda_id
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
            // Se não existe, crie um novo registro
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

}
