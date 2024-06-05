<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Pacientes;
use App\Models\Profissional;
use App\Models\User;
use Illuminate\Http\Request;

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
        $profissional = Profissional::all();

        return view('agenda.criar', compact(['agendas', 'pacientes', 'profissional']));
    }

    public function index1(Request $request)
    {
        $pacientes = Pacientes::all();
        $profissionals = Profissional::all();
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

        return view('agenda.lista', compact('profissionals', 'agendas', 'pacientes'));
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
        $consulta_id = $request->input('consulta_id');
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
            'sobrenome' => $sobrenome,
            'consulta_id' => $consulta_id,
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
                return response()->json(['error' => 'Paciente não tem Cadastro.'], 400);
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
            
            'consulta_id' => 'required|integer',
        ]);

        // Encontrar a agenda pelo ID
        $agenda = Agenda::findOrFail($id);

        // Atualizar os dados da agenda
        $agenda->profissional_id = $request->profissional_id;
        $agenda->data = $request->data;
        $agenda->hora = $request->hora;
        $agenda->paciente_id = $request->paciente_id;
        $agenda->consulta_id = $request->consulta_id;

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
        // Encontrar o item da agenda pelo ID e deletar
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        // Retornar uma resposta JSON com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Agenda atualizada com sucesso.');
    }

    public function agendaMedica(Request $request)
    {
        $pacientes = Pacientes::all();

        // Get the currently logged-in user
        $user = auth()->user();

        // Check if user has a linked professional ID
        if ($user && $user->profissional_id) {
            $profissionalId = $user->profissional_id;
        } else {
            // Handle the case where user doesn't have a linked professional ID
            // (consider returning an appropriate error message or view)
            return view('agenda.error', [ // Replace 'error' with appropriate view name
                'message' => 'Usuário não possui vínculo com um profissional'
            ]);
        }

        $agendas = collect();

        // Filter agendas based on logged-in user's linked professional ID
        if ($request->has('data')) {
            $agendas = Agenda::where('profissional_id', $profissionalId)
                ->where('data', $request->data)
                ->whereNotNull('paciente_id')
                ->orderBy('hora', 'asc')
                ->get();

            // Store form values in the session (optional, adjust based on your needs)
            session([
                'data' => $request->data,
            ]);
        } else {
            // Clear session data if no filter is applied (optional)
            session()->forget('data');
        }

        return view('agenda.agendamedica', compact('agendas', 'pacientes'));
    }



}
