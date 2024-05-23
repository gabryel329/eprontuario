<?php

namespace App\Http\Controllers;

use App\Models\Anamnese;
use App\Models\Pacientes;
use Illuminate\Http\Request;

class AnamneseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anamnese = Anamnese::all();
        $pacientes = Pacientes::all();
        return view('atendimentos.anamnese', compact(['anamnese', 'pacientes']));
    }

    public function index1()
    {
        $anamnese = Anamnese::all();
        $pacientes = Pacientes::all();
        return view('atendimentos.listaanamnese', compact(['anamnese', 'pacientes']));
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
            $paciente_id = $request->input('paciente_id');
            $pa = $request->input('pa');
            $temp = $request->input('temp');
            $peso = $request->input('peso');
            $altura = $request->input('altura');
            $gestante = $request->input('gestante');
            $dextro = $request->input('dextro');
            $spo2 = $request->input('spo2');
            $fc = $request->input('fc');
            $fr = $request->input('fr');
            $acolhimento = $request->input('acolhimento');
            $acolhimento1 = $request->input('acolhimento1');
            $acolhimento2 = $request->input('acolhimento2');
            $acolhimento3 = $request->input('acolhimento3');
            $acolhimento4 = $request->input('acolhimento4');
            $alergia1 = $request->input('alergia1');
            $alergia2 = $request->input('alergia2');
            $alergia3 = $request->input('alergia3');
            $anamnese = $request->input('anamnese');
        
            // Create a new permission
            Anamnese::create([
                'paciente_id' => $paciente_id,
                'pa' => $pa,
                'temp' => $temp,
                'peso' => $peso,
                'altura' => $altura,
                'gestante' => $gestante,
                'dextro' => $dextro,
                'spo2' => $spo2,
                'fc' => $fc,
                'fr' => $fr,
                'acolhimento' => $acolhimento,
                'acolhimento1' => $acolhimento1,
                'acolhimento2' => $acolhimento2,
                'acolhimento3' => $acolhimento3,
                'acolhimento4' => $acolhimento4,
                'alergia1' => $alergia1,
                'alergia2' => $alergia2,
                'alergia3' => $alergia3,
                'anamnese' => $anamnese,
            ]);
        
            return redirect()->route('anamnese.index')->with('success', 'Anamnese criada com sucesso.');
    }

    public function update(Request $request, Anamnese $anamnese)
    {
        $validatedData = $request->validate([
            'paciente_id' => 'nullable|integer|exists:pacientes,id',
            'pa' => 'nullable|string',
            'temp' => 'nullable|string',
            'peso' => 'nullable|string',
            'altura' => 'nullable|string',
            'gestante' => 'nullable|string',
            'dextro' => 'nullable|string',
            'spo2' => 'nullable|string',
            'fc' => 'nullable|string',
            'fr' => 'nullable|string',
            'acolhimento' => 'nullable|string',
            'acolhimento1' => 'nullable|string',
            'acolhimento2' => 'nullable|string',
            'acolhimento3' => 'nullable|string',
            'acolhimento4' => 'nullable|string',
            'alergia1' => 'nullable|string',
            'alergia2' => 'nullable|string',
            'alergia3' => 'nullable|string',
            'anamnese' => 'nullable|string',
        ]);

        $anamnese->update($validatedData);

        return redirect()->route('anamnese.index')->with('success', 'Anamnese atualizada com sucesso.');
    }

    
    public function destroy(Anamnese $anamnese)
    {
        $anamnese->delete();

        return redirect()->route('anamnese.index')->with('success', 'Anamnese excluída com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anamnese $anamnese)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anamnese $anamnese)
    {
        //
    }

}
