<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use App\Models\User;
use Illuminate\Http\Request;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paciente = Pacientes::all();

        return view('cadastros.pacientes', compact(['paciente']));
    }

    public function index1()
    {
        $paciente = Pacientes::all();

        return view('cadastros.listapacientes', compact(['paciente']));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Capitalize the input
        $nome = ucfirst($request->input('name'));
        $sobrenome = ucfirst($request->input('sobrenome'));

        // Get the other inputs
        $email = $request->input('email');
        $nasc = $request->input('nasc');
        $cpf = $request->input('cpf');
        $genero = $request->input('genero');
        $cep = $request->input('cep');
        $rua = $request->input('rua');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $rg = $request->input('rg');
        $uf = $request->input('uf');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');
        $nomepai = $request->input('nome_pai');
        $nomemae = $request->input('nome_mae');
        $sus = $request->input('sus');
        $convenio = $request->input('convenio');
        $matricula = $request->input('matricula');
        $cor = $request->input('cor');
        $acompanhante = $request->input('acompanhante');
        $celular = $request->input('celular');
        $telefone = $request->input('telefone');
        $certidao = $request->input('certidao');
        $nomesocial = $request->input('nome_social');

        // Check if the user already exists
        $existePacientes = Pacientes::where('cpf', $cpf)->first();

        if ($existePacientes) {
            return redirect()->route('paciente.index')->with('error', 'Paciente já existe!');
        } 

        // Create a new user
            Pacientes::create([
                'name' => $nome,
                'sobrenome' => $sobrenome,
                'email' => $email,
                'nasc' => $nasc,
                'cpf' => $cpf,
                'genero' => $genero,
                'cep' => $cep,
                'rua' => $rua,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'uf' => $uf,
                'numero' => $numero,
                'complemento' => $complemento,
                'nome_pai' => $nomepai,
                'nome_social' => $nomesocial,
                'nome_mae' => $nomemae,
                'sus' => $sus,
                'convenio' => $convenio,
                'matricula' => $matricula,
                'cor' => $cor,
                'acompanhante' => $acompanhante,
                'celular' => $celular,
                'telefone' => $telefone,
                'rg' => $rg,
                'certidao' => $certidao,
            ]);

        return redirect()->route('paciente.index')->with('success', 'Paciente cadastrado com Sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the user by ID
        $paciente = Pacientes::find($id);

        if (!$paciente) {
            return redirect()->route('paciente.index')->with('error', 'Paciente não encontrado!');
        }

        // Return the view with the user data
        return view('paciente.show', compact('paciente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pacientes $pacientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Encontrar o paciente pelo ID
        $paciente = Pacientes::findOrFail($id);
    
        // Capitalizar os campos de nome e sobrenome
        $nome = ucfirst($request->input('name'));
        $sobrenome = ucfirst($request->input('sobrenome'));
    
        // Atualizar os campos do paciente
        $paciente->update([
            'name' => $nome,
            'sobrenome' => $sobrenome,
            'email' => $request->input('email'),
            'nasc' => $request->input('nasc'),
            'cpf' => $request->input('cpf'),
            'genero' => $request->input('genero'),
            'cep' => $request->input('cep'),
            'rua' => $request->input('rua'),
            'bairro' => $request->input('bairro'),
            'cidade' => $request->input('cidade'),
            'uf' => $request->input('uf'),
            'rg' => $request->input('rg'),
            'numero' => $request->input('numero'),
            'complemento' => $request->input('complemento'),
            'nome_pai' => $request->input('nome_pai'),
            'nome_mae' => $request->input('nome_mae'),
            'sus' => $request->input('sus'),
            'convenio' => $request->input('convenio'),
            'matricula' => $request->input('matricula'),
            'cor' => $request->input('cor'),
            'acompanhante' => $request->input('acompanhante'),
            'celular' => $request->input('celular'),
            'telefone' => $request->input('telefone'),
            'certidao' => $request->input('certidao'),
            'nome_social' => $request->input('nome_social'),
        ]);
    
        return redirect()->route('paciente.index')->with('success', 'Paciente atualizado com sucesso!');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the user by ID
        $paciente = Pacientes::find($id);

        if (!$paciente) {
            return redirect()->route('paciente.index')->with('error', 'Paciente não encontrado!');
        }

        // Delete the user
        $paciente->delete();

        return redirect()->route('paciente.index')->with('success', 'Paciente excluído com Sucesso!');
    }
}
