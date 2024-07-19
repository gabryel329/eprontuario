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
        // Verifica se já existe um paciente com o mesmo CPF
        $cpf = $request->input('cpf');
        $existeCpf = Pacientes::where('cpf', $cpf)->first();
        if ($existeCpf) {
            return redirect()->back()->withInput()->with('error', 'CPF já cadastrado, tente novamente');
        }
    
        // Verifica se já existe um paciente com o mesmo RG
        $rg = $request->input('rg');
        $existeRG = Pacientes::where('rg', $rg)->first();
        if ($existeRG) {
            return redirect()->back()->withInput()->with('error', 'RG já cadastrado, tente novamente');
        }
    
        // Verifica se já existe um paciente com o mesmo SUS, se o campo foi preenchido
        $sus = $request->input('sus');
        if (!empty($sus)) {
            $existeSUS = Pacientes::where('sus', $sus)->first();
            if ($existeSUS) {
                return redirect()->back()->withInput()->with('error', 'SUS já cadastrado, tente novamente');
            }
        }
    
        // Capitalize the input where appropriate
        $name = ucfirst($request->input('name'));
        $sobrenome = ucfirst($request->input('sobrenome'));
    
        // Get the other inputs
        $email = $request->input('email');
        $nasc = $request->input('nasc');
        $cep = $request->input('cep');
        $rua = $request->input('rua');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');
        $telefone = $request->input('telefone');
        $celular = $request->input('celular');
        $nome_social = $request->input('nome_social');
        $nome_pai = $request->input('nome_pai');
        $nome_mae = $request->input('nome_mae');
        $acompanhante = $request->input('acompanhante');
        $genero = $request->input('genero');
        $certidao = $request->input('certidao');
        $convenio = $request->input('convenio');
        $matricula = $request->input('matricula');
        $cor = $request->input('cor');
        $imagem = $request->file('imagem');
    
        if ($imagem && $imagem->isValid()) {
            $filenameWithExt = $imagem->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $imagem->getClientOriginalExtension();
            $imageName = $filename . '.' . $extension;
            $imagem->move(public_path('images/'), $imageName);
        } else {
            $imageName = null;
        }
    
        $paciente = Pacientes::create([
            'name' => $name,
            'sobrenome' => $sobrenome,
            'email' => $email,
            'nasc' => $nasc,
            'cpf' => $cpf,
            'cep' => $cep,
            'rua' => $rua,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'uf' => $uf,
            'numero' => $numero,
            'complemento' => $complemento,
            'telefone' => $telefone,
            'celular' => $celular,
            'nome_social' => $nome_social,
            'nome_pai' => $nome_pai,
            'nome_mae' => $nome_mae,
            'acompanhante' => $acompanhante,
            'genero' => $genero,
            'rg' => $rg,
            'certidao' => $certidao,
            'sus' => $sus,
            'convenio' => $convenio,
            'matricula' => $matricula,
            'cor' => $cor,
            'imagem' => $imageName,
        ]);
    
        return redirect()->route('paciente.index1')->with('success', 'Paciente criado com sucesso')->with('paciente', $paciente);
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
        // Find the paciente by ID
        $paciente = Pacientes::findOrFail($id);

        // Capitalize the input where appropriate
        $name = ucfirst($request->input('name'));
        $sobrenome = ucfirst($request->input('sobrenome'));

        // Get the other inputs
        $email = $request->input('email');
        $nasc = $request->input('nasc');
        $cpf = $request->input('cpf');
        $cep = $request->input('cep');
        $rua = $request->input('rua');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');
        $telefone = $request->input('telefone');
        $celular = $request->input('celular');
        $nome_social = $request->input('nome_social');
        $nome_pai = $request->input('nome_pai');
        $nome_mae = $request->input('nome_mae');
        $acompanhante = $request->input('acompanhante');
        $genero = $request->input('genero');
        $rg = $request->input('rg');
        $certidao = $request->input('certidao');
        $sus = $request->input('sus');
        $convenio = $request->input('convenio');
        $matricula = $request->input('matricula');
        $cor = $request->input('cor');
        $imagem = $request->file('imagem');

        if ($imagem && $imagem->isValid()) {
            $filenameWithExt = $imagem->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $imagem->getClientOriginalExtension();
            $imageName = $filename . '.' . $extension;

            // Upload Image to the 'public/images/' directory
            $imagem->move(public_path('images/'), $imageName);

            // Remove the old image if exists
            if ($paciente->imagem && file_exists(public_path('images/') . $paciente->imagem)) {
                unlink(public_path('images/') . $paciente->imagem);
            }

            // Update the paciente with the new image
            $paciente->imagem = $imageName;
        }

        // Update paciente attributes
        $paciente->name = $name;
        $paciente->sobrenome = $sobrenome;
        $paciente->email = $email;
        $paciente->nasc = $nasc;
        $paciente->cpf = $cpf;
        $paciente->cep = $cep;
        $paciente->rua = $rua;
        $paciente->bairro = $bairro;
        $paciente->cidade = $cidade;
        $paciente->uf = $uf;
        $paciente->numero = $numero;
        $paciente->complemento = $complemento;
        $paciente->telefone = $telefone;
        $paciente->celular = $celular;
        $paciente->nome_social = $nome_social;
        $paciente->nome_pai = $nome_pai;
        $paciente->nome_mae = $nome_mae;
        $paciente->acompanhante = $acompanhante;
        $paciente->genero = $genero;
        $paciente->rg = $rg;
        $paciente->certidao = $certidao;
        $paciente->sus = $sus;
        $paciente->convenio = $convenio;
        $paciente->matricula = $matricula;
        $paciente->cor = $cor;

        // Save the updated paciente data
        $paciente->save();

        // Redirect with success message
        return redirect()->route('paciente.index1')->with('success', 'Paciente atualizado com sucesso')->with('paciente', $paciente);
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the user by ID
        $paciente = Pacientes::find($id);

        if (!$paciente) {
            return redirect()->back()->with('error', 'Paciente não encontrado!');
        }

        // Delete the user
        $paciente->delete();

        return redirect()->back()->with('success', 'Paciente excluído com Sucesso!');
    }
}
