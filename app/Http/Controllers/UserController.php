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
         // Validate the request inputs, including the image size
         $request->validate([
             'name' => 'required|string|max:255',
             'sobrenome' => 'required|string|max:255',
             'email' => 'required|email|unique:users,email',
             'password' => 'required|string|min:8',
         ]);
     
         // Capitalize the input
         $nome = ucfirst($request->input('name'));
         $sobrenome = ucfirst($request->input('sobrenome'));
     
         // Get the other inputs
         $email = $request->input('email');
         $password = bcrypt($request->input('password')); // Encrypt the password
         $profissional_id = $request->input('id');
         $permissoes = $request->input('permisao_id');
         $imagem = $request->file('imagem');
     
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
                 'profissional_id' => $profissional_id,
                 'imagem' => $imageName,
                 'permisao_id' => $permissoes,
             ]);
         } else {
             $user = User::create([
                 'name' => $nome,
                 'sobrenome' => $sobrenome,
                 'email' => $email,
                 'password' => $password,
                 'profissional_id' => $profissional_id,
                 'permisao_id' => $permissoes,
             ]);
         }
     
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
    // Validate the request inputs, including the image size
    $request->validate([
        'name' => 'required|string|max:255',
        'sobrenome' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|string|min:8',
        'imagem' => 'nullable|image|mimes:jpg,jpeg,png|max:204800', // Max size 200MB (204800 KB)
    ]);

    // Find the user by ID
    $user = User::findOrFail($id);

    // Capitalize the input
    $nome = ucfirst($request->input('name'));
    $sobrenome = ucfirst($request->input('sobrenome'));
    $profissional_id = $request->input('profissional_id');
    $permissoes = $request->input('permisao_id');
    $email = $request->input('email');
    $imagem = $request->file('imagem');
    $password = $request->input('password') ? bcrypt($request->input('password')) : $user->password;

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
    $user->permisao_id = $permissoes;
    $user->profissional_id = $profissional_id;

    // oesthe updated user data
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
