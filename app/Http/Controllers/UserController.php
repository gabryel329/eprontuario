<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use App\Models\Especialidade;
use App\Models\Permisoes;
use App\Models\Profissional;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $profissioanls = Profissional::all();
        $permissoes = Permisoes::all();

        return view('cadastros.usuarios', compact(['users', 'profissioanls', 'permissoes']));
    }

    public function index1()
    {
        $users = User::all();
        $profissioanls = Profissional::all();
        $permissoes = Permisoes::all();

        return view('cadastros.listausuarios', compact(['users', 'profissioanls', 'permissoes']));
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
         $contrato = Empresas::first();
     
         // Definir os limites de usuários por tipo de contrato
         $limitesUsuarios = [
             'Bronze' => 5,
             'Prata' => 7,
             'Ouro' => 10,
         ];
     
         // Verificar o tipo de contrato da empresa
         $tipoContrato = $contrato->contrato; // Supondo que o nome do contrato esteja no campo 'nome'
     
         // Obter o número total de usuários cadastrados
         $numeroTotalUsuarios = User::count();
     
         // Verificar se o número total de usuários é maior ou igual ao limite do contrato
         if (isset($limitesUsuarios[$tipoContrato]) && $numeroTotalUsuarios >= $limitesUsuarios[$tipoContrato]) {
             return redirect()->back()->with('error', 'Limite de usuários atingido para o contrato ' . $tipoContrato);
         }
     
         // Capitalize o input
         $nome = ucfirst($request->input('name'));
         $sobrenome = ucfirst($request->input('sobrenome'));
     
         // Obter os outros inputs
         $email = $request->input('email');
         $password = bcrypt($request->input('password'));
         $profissional_id = $request->input('id');
         $permissoes = $request->input('permisao_id');
         $imagem = $request->file('imagem');
     
         // Debug: Verificar o tipo e valor de permissoes
         Log::debug('permissoes:', ['permissoes' => $permissoes]);
     
         // Determinar permisao_id com base na primeira permissao
         $permisao_id = 0; // Valor padrão
         if (is_array($permissoes) && !empty($permissoes)) {
             $firstPermissao = $permissoes[0]; // Pega a primeira permissao
             Log::debug('First Permissao:', ['firstPermissao' => $firstPermissao]);
             if ($firstPermissao == 1) {
                 $permisao_id = 1;
             } elseif ($firstPermissao == 2) {
                 $permisao_id = 2;
             }
         }
     
         // Debug: Verificar o valor final de permisao_id
         Log::debug('Final permisao_id:', ['permisao_id' => $permisao_id]);
     
         if ($imagem && $imagem->isValid()) {
             $filenameWithExt = $imagem->getClientOriginalName();
             $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
             $extension = $imagem->getClientOriginalExtension();
             $imageName = $filename . '.' . $extension;
     
             $imagem->move(public_path('images/'), $imageName);
     
             // Criar o novo usuário
             $user = User::create([
                 'name' => $nome,
                 'sobrenome' => $sobrenome,
                 'email' => $email,
                 'permisao_id' => $permisao_id,
                 'password' => $password,
                 'profissional_id' => $profissional_id,
                 'imagem' => $imageName,
             ]);
         } else {
             $user = User::create([
                 'name' => $nome,
                 'sobrenome' => $sobrenome,
                 'email' => $email,
                 'permisao_id' => $permisao_id,
                 'password' => $password,
                 'profissional_id' => $profissional_id,
             ]);
         }
     
         // Anexar permissões
         $user->permissoes()->attach($permissoes);
     
         // Recuperar os dados do usuário
         $user = User::find($user->id);
     
         return redirect()->route('usuario.index')->with('success', 'Usuário criado com sucesso')->with('user', $user);
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
        $email = $request->input('email');
        $permissoes = $request->input('permisao_id'); // Correctly capture permisao_id
        $password = $request->input('password') ? bcrypt($request->input('password')) : $user->password;
        $imagem = $request->file('imagem');

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

        // Save the updated user data
        $user->save();

        // Sync especialidades
        $user->permissoes()->sync($permissoes);

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


    public function salvarSala(Request $request)
    {
        $user = User::find($request->input('user_id'));

        if ($user) {
            $user->sala = $request->input('sala');
            $user->save();

            // Marca a pergunta como respondida na sessão
            $request->session()->put('question_asked', true);

            // Retorna uma resposta JSON com uma mensagem de sucesso
            return response()->json(['success' => true, 'message' => 'Resposta salva com sucesso!']);
        }

        // Retorna uma resposta JSON com uma mensagem de erro
        return response()->json(['success' => false, 'message' => 'Usuário não encontrado'], 404);
    }

}
