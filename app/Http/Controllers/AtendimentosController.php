<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Anamnese;
use App\Models\Atendimentos;
use App\Models\Pacientes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AtendimentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($agenda_id, $paciente_id)
    {
        $agenda = Agenda::findOrFail($agenda_id);
        
        // Obtenha a data atual
        $dataAtual = now()->format('Y-m-d');

        // Busque a anamnese com base na data atual e no paciente_id
        $anamnese = Anamnese::where('created_at', $dataAtual)
                            ->where('paciente_id', $paciente_id)
                            ->first();

        $paciente = Pacientes::findOrFail($paciente_id);
        
        return view('atendimentos.atendimentomedico', compact('agenda', 'paciente', 'anamnese'));
    }

    public function storeAtendimento(Request $request)
    {
        // Verificar se já existe um registro com o mesmo agenda_id
        $atendimento = Atendimentos::where('agenda_id', $request->input('agenda_id'))->first();

        if ($atendimento) {
            // Se o registro já existe, atualize os dados
            $atendimento->update([
                'queixas' => $request->input('queixas'),
                'exame' => $request->input('exame'),
                'plano' => $request->input('plano'),
                'hipoteses' => $request->input('hipoteses'),
                'condicao' => $request->input('condicao'),
                'paciente_id' => $request->input('paciente_id'),
                'profissional_id' => $request->input('profissional_id'),
            ]);

            return response()->json(['success' => 'Atendimento atualizado com sucesso']);
        } else {
            // Se não existe, crie um novo registro
            $atendimento = Atendimentos::create([
                'queixas' => $request->input('queixas'),
                'exame' => $request->input('exame'),
                'plano' => $request->input('plano'),
                'hipoteses' => $request->input('hipoteses'),
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Atendimentos $atendimentos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Atendimentos $atendimentos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Atendimentos $atendimentos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Atendimentos $atendimentos)
    {
        //
    }
}