<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Permisoes;
use App\Models\Profissional;
use App\Models\TipoProf;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfissionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profissioanls = Profissional::all();
        $permissoes = Permisoes::all();
        $especialidades = Especialidade::all();
        $tipoprof = TipoProf::all();
    
        return view('cadastros.profissional', compact('profissioanls', 'permissoes', 'especialidades', 'tipoprof'));
    }
    

    public function index1()
    {
        $profissioanls = Profissional::all();
        $permissoes = Permisoes::all();
        $tipoprof = TipoProf::all();
        $especialidades = Especialidade::all();

        return view('cadastros.listaprofissional', compact(['profissioanls', 'permissoes', 'especialidades', 'tipoprof']));
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
        // Capitalize the input
        $nome = ucfirst($request->input('name'));
        $sobrenome = ucfirst($request->input('sobrenome'));

        // Get the other inputs
        $email = $request->input('email');
        $nasc = $request->input('nasc');
        $cpf = $request->input('cpf');
        $genero = $request->input('genero');
        $rg = $request->input('rg');
        $cor = $request->input('cor');
        $imagem = $request->file('imagem');
        $permisoes_id = $request->input('permisoes_id');
        $especialidade_id = $request->input('especialidade_id');
        $tipoprof_id = $request->input('tipoprof_id');
        $conselho = $request->input('conselho');
        $cep = $request->input('cep');
        $rua = $request->input('rua');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');
        $telefone = $request->input('telefone');
        $celular = $request->input('celular');

        // Check if the user already exists
        $existeProfissional = Profissional::where('cpf', $cpf)->first();

        if ($existeProfissional) {
            return redirect()->route('profissional.index')->with('error', 'Profissional já existe!');
        }

        $existeEmail = Profissional::where('email', $email)->first();

        if ($existeEmail) {
            return redirect()->route('profissional.index')->with('error', 'Email já cadastrado!');
        }

        if ($imagem && $imagem->isValid()) {
            $filenameWithExt = $imagem->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $imagem->getClientOriginalExtension();
            // Filename to store
            $imageName = $filename . '.' . $extension;

            // Upload Image to the 'public/images/' directory
            $imagem->move(public_path('images/'), $imageName);

            // Create a new user
            $profissional = Profissional::create([
                'name' => $nome,
                'sobrenome' => $sobrenome,
                'email' => $email,
                'nasc' => $nasc,
                'cpf' => $cpf,
                'genero' => $genero,
                'rg' => $rg,
                'cor' => $cor,
                'imagem' => $imageName,
                'permisoes_id' => $permisoes_id,
                'especialidade_id' => $especialidade_id,
                'conselho' => $conselho,
                'tipoprof_id' => $tipoprof_id,
                'cep' => $cep,
                'rua' => $rua,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'uf' => $uf,
                'numero' => $numero,
                'complemento' => $complemento,
                'telefone' => $telefone,
                'celular' => $celular,
            ]);
        } else {
            // Se nenhuma imagem foi enviada, crie o produto sem o campo de imagem
            $profissional = Profissional::create([
                'name' => $nome,
                'sobrenome' => $sobrenome,
                'email' => $email,
                'nasc' => $nasc,
                'cpf' => $cpf,
                'genero' => $genero,
                'rg' => $rg,
                'cor' => $cor,
                'permisoes_id' => $permisoes_id,
                'especialidade_id' => $especialidade_id,
                'conselho' => $conselho,
                'tipoprof_id' => $tipoprof_id,
                'cep' => $cep,
                'rua' => $rua,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'uf' => $uf,
                'numero' => $numero,
                'complemento' => $complemento,
                'telefone' => $telefone,
                'celular' => $celular,
            ]);
        }

        // Retrieve the company data, including the logo, after it has been saved
        $profissional = Profissional::first();

        return redirect()->route('profissional.index')->with('success', 'Profissional criado(a) com sucesso')->with('profissional', $profissional);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the user by ID
        $profissional = Profissional::find($id);

        if (!$profissional) {
            return redirect()->route('profissional.index')->with('error', 'Profissional não encontrado!');
        }

        // Return the view with the user data
        return view('profissional.show', compact('profissional'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profissional $profissional)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the user by ID
        $profissional = Profissional::findOrFail($id);

        // Capitalize the input
        $nome = ucfirst($request->input('name'));
        $sobrenome = ucfirst($request->input('sobrenome'));

        // Get the other inputs
        $email = $request->input('email');
        $nasc = $request->input('nasc');
        $cpf = $request->input('cpf');
        $genero = $request->input('genero');
        $rg = $request->input('rg');
        $cor = $request->input('cor');
        $imagem = $request->file('imagem');
        $permisoes_id = $request->input('permisoes_id');
        $especialidade_id = $request->input('especialidade_id');
        $conselho = $request->input('conselho');
        $tipoprof_id = $request->input('tipoprof_id');
        $cep = $request->input('cep');
        $rua = $request->input('rua');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');
        $telefone = $request->input('telefone');
        $celular = $request->input('celular');
        $cor = $request->input('cor');
        $rg = $request->input('rg');
        $conselho = $request->input('conselho');
        $tipoprof_id = $request->input('tipoprof_id');

        if ($imagem && $imagem->isValid()) {
            $filenameWithExt = $imagem->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $imagem->getClientOriginalExtension();
            $imageName = $filename . '.' . $extension;

            // Upload Image to the 'public/images/' directory
            $imagem->move(public_path('images/'), $imageName);

            // Remove the old image if exists
            if ($profissional->imagem && file_exists(public_path('images/') . $profissional->imagem)) {
                unlink(public_path('images/') . $profissional->imagem);
            }

            // Update the user with the new image
            $profissional->imagem = $imageName;
        }

        // Update user attributes
        $profissional->name = $nome;
        $profissional->sobrenome = $sobrenome;
        $profissional->email = $email;
        $profissional->nasc = $nasc;
        $profissional->cpf = $cpf;
        $profissional->genero = $genero;
        $profissional->rg = $rg;
        $profissional->cor = $cor;
        $profissional->permisoes_id = $permisoes_id;
        $profissional->especialidade_id = $especialidade_id;
        $profissional->conselho = $conselho;
        $profissional->tipoprof_id = $tipoprof_id;
        $profissional->cep = $cep;
        $profissional->rua = $rua;
        $profissional->bairro = $bairro;
        $profissional->cidade = $cidade;
        $profissional->uf = $uf;
        $profissional->numero = $numero;
        $profissional->complemento = $complemento;
        $profissional->telefone = $telefone;
        $profissional->celular = $celular;
        $profissional->cor = $cor;
        $profissional->rg = $rg;
        $profissional->tipoprof_id = $tipoprof_id;
        $profissional->conselho = $conselho;

        // Save the updated user data
        $profissional->save();

        return redirect()->back()->with('success', 'Profissional atualizado com sucesso')->with('profissional', $profissional);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the user by ID
        $profissional = Profissional::find($id);

        if (!$profissional) {
            return redirect()->route('profissional.index1')->with('error', 'Profissional não encontrado!');
        }

        // Delete the user
        $profissional->delete();

        return redirect()->route('profissional.index1')->with('success', 'Profissional excluído com Sucesso!');
    }
}
