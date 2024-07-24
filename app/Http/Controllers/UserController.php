<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Permisoes;
use App\Models\Profissional;
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
    // Capitalize the input
    $nome = ucfirst($request->input('name'));
    $sobrenome = ucfirst($request->input('sobrenome'));

    // Get the other inputs
    $email = $request->input('email');
    $password = bcrypt($request->input('password')); // Encrypt the password
    $profissional_id = $request->input('id');
    $permissoes = $request->input('permisao_id');
    $imagem = $request->file('imagem');

    // Debug: Check the type and value of permissoes
    \Illuminate\Support\Facades\Log::debug('permissoes:', ['permissoes' => $permissoes]);

    // Determine the permisao_id based on the first permissoes value
    $permisao_id = 0; // Default value
    if (is_array($permissoes) && !empty($permissoes)) {
        $firstPermissao = $permissoes[0]; // Get the first permission
        \Illuminate\Support\Facades\Log::debug('First Permissao:', ['firstPermissao' => $firstPermissao]);
        if ($firstPermissao == 1) {
            $permisao_id = 1;
        } elseif ($firstPermissao == 2) {
            $permisao_id = 2;
        }
    }

    // Debug: Check the final value of permisao_id
    \Illuminate\Support\Facades\Log::debug('Final permisao_id:', ['permisao_id' => $permisao_id]);

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

    // Attach permissions
    $user->permissoes()->attach($permissoes);

    // Retrieve the user data
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

            $request->session()->put('question_asked', true);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }
}
