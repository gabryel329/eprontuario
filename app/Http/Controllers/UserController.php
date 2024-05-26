<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Permisoes;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $permissoes = Permisoes::all();
        $especialidades = Especialidade::all(); // Corrigido o nome da variável

        return view('cadastros.usuarios', compact(['users', 'permissoes', 'especialidades']));
    }

    public function index1()
    {
        $users = User::all();
        $permissoes = Permisoes::all();
        $especialidades = Especialidade::all(); // Corrigido o nome da variável

        return view('cadastros.listausuarios', compact(['users', 'permissoes', 'especialidades']));
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
        $password = bcrypt($request->input('password')); // Encrypt the password
        $nasc = $request->input('nasc');
        $cpf = $request->input('cpf');
        $genero = $request->input('genero');
        $imagem = $request->file('imagem');
        $permisoes_id = $request->input('permisoes_id');
        $especialidade_id = $request->input('especialidade_id');
        $crm = $request->input('crm');
        $corem = $request->input('corem');
        $cep = $request->input('cep');
        $rua = $request->input('rua');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');

        // Check if the user already exists
        $existeUser = User::where('cpf', $cpf)->first();

        if ($existeUser) {
            return redirect()->route('usuario.index')->with('error', 'Usuário já existe!');
        }

        $existeEmail = User::where('email', $email)->first();

        if ($existeEmail) {
            return redirect()->route('usuario.index')->with('error', 'Email já cadastrado!');
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
            $user = User::create([
                'name' => $nome,
                'sobrenome' => $sobrenome,
                'email' => $email,
                'password' => $password,
                'nasc' => $nasc,
                'cpf' => $cpf,
                'genero' => $genero,
                'imagem' => $imageName,
                'permisoes_id' => $permisoes_id,
                'especialidade_id' => $especialidade_id,
                'crm' => $crm,
                'corem' => $corem,
                'cep' => $cep,
                'rua' => $rua,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'uf' => $uf,
                'numero' => $numero,
                'complemento' => $complemento,
            ]);
        } else {
            // Se nenhuma imagem foi enviada, crie o produto sem o campo de imagem
            $user = User::create([
                'name' => $nome,
                'sobrenome' => $sobrenome,
                'email' => $email,
                'password' => $password,
                'nasc' => $nasc,
                'cpf' => $cpf,
                'genero' => $genero,
                'permisoes_id' => $permisoes_id,
                'especialidade_id' => $especialidade_id,
                'crm' => $crm,
                'corem' => $corem,
                'cep' => $cep,
                'rua' => $rua,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'uf' => $uf,
                'numero' => $numero,
                'complemento' => $complemento,
            ]);
        }

        // Retrieve the company data, including the logo, after it has been saved
        $user = User::first();

        return redirect()->route('usuario.index')->with('success', 'Usuario criada com sucesso')->with('user', $user);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('usuario.index')->with('error', 'Usuário não encontrado!');
        }

        // Return the view with the user data
        return view('usuarios.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Capitalize the input
        $nome = ucfirst($request->input('name'));
        $sobrenome = ucfirst($request->input('sobrenome'));

        // Get the other inputs
        $email = $request->input('email');
        $password = $request->input('password') ? bcrypt($request->input('password')) : $user->password;
        $nasc = $request->input('nasc');
        $cpf = $request->input('cpf');
        $genero = $request->input('genero');
        $imagem = $request->file('imagem');
        $permisoes_id = $request->input('permisoes_id');
        $especialidade_id = $request->input('especialidade_id');
        $crm = $request->input('crm');
        $corem = $request->input('corem');
        $cep = $request->input('cep');
        $rua = $request->input('rua');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');

        if ($imagem && $imagem->isValid()) {
            $filenameWithExt = $imagem->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $imagem->getClientOriginalExtension();
            $imageName = $filename . '.' . $extension;

            // Upload Image to the 'public/images/' directory
            $imagem->move(public_path('images/'), $imageName);

            // Remove the old image if exists
            if ($user->imagem && file_exists(public_path('images/') . $user->imagem)) {
                unlink(public_path('images/') . $user->imagem);
            }

            // Update the user with the new image
            $user->imagem = $imageName;
        }

        // Update user attributes
        $user->name = $nome;
        $user->sobrenome = $sobrenome;
        $user->email = $email;
        $user->password = $password;
        $user->nasc = $nasc;
        $user->cpf = $cpf;
        $user->genero = $genero;
        $user->permisoes_id = $permisoes_id;
        $user->especialidade_id = $especialidade_id;
        $user->crm = $crm;
        $user->corem = $corem;
        $user->cep = $cep;
        $user->rua = $rua;
        $user->bairro = $bairro;
        $user->cidade = $cidade;
        $user->uf = $uf;
        $user->numero = $numero;
        $user->complemento = $complemento;

        // Save the updated user data
        $user->save();

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso')->with('user', $user);
    }




    //     /**
//      * Remove the specified resource from storage.
//      */
    public function destroy($id)
    {
        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('usuario.index')->with('error', 'Usuário não encontrado!');
        }

        // Delete the user
        $user->delete();

        return redirect()->route('usuario.index')->with('success', 'Usuário excluído com Sucesso!');
    }

}
