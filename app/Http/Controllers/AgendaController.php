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

    return view('agenda.lista', compact('profissionals', 'agendas'));
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
            $agenda->status = $request->status;
            $agenda->save();
            return response()->json(['success' => 'Status atualizado com sucesso.']);
        } else {
            return response()->json(['error' => 'Agenda não encontrada.'], 404);
        }
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
        return response()->json(['success' => 'Consulta deletada com sucesso.']);
    }

}
