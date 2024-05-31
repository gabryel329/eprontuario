<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the company with ID 1
        $empresa = Empresas::all();
        return view('empresas', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the company by ID
        $empresa = Empresas::findOrFail($id);

        // Capitalize the input where appropriate
        $name = ucfirst($request->input('name'));
        $fantasia = ucfirst($request->input('fantasia'));

        // Get the other inputs
        $telefone = $request->input('telefone');
        $cnpj = $request->input('cnpj');
        $email = $request->input('email');
        $cep = $request->input('cep');
        $rua = $request->input('rua');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $numero = $request->input('numero');
        $celular = $request->input('celular');
        $medico = $request->input('medico');
        $crm = $request->input('crm');
        $imagem = $request->file('imagem');

        // Check if a new image is uploaded and is valid
        if ($imagem && $imagem->isValid()) {
            $filenameWithExt = $imagem->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $imagem->getClientOriginalExtension();
            $imageName = $filename . '_' . time() . '.' . $extension;

            // Upload Image to the 'public/images/' directory
            $imagem->move(public_path('images/'), $imageName);

            // Remove the old image if it exists
            if ($empresa->imagem && file_exists(public_path('images/') . $empresa->imagem)) {
                unlink(public_path('images/') . $empresa->imagem);
            }

            // Update the company with the new image
            $empresa->imagem = $imageName;
        }

        // Update company attributes
        $empresa->name = $name;
        $empresa->fantasia = $fantasia;
        $empresa->telefone = $telefone;
        $empresa->cnpj = $cnpj;
        $empresa->email = $email;
        $empresa->cep = $cep;
        $empresa->rua = $rua;
        $empresa->bairro = $bairro;
        $empresa->cidade = $cidade;
        $empresa->uf = $uf;
        $empresa->numero = $numero;
        $empresa->celular = $celular;
        $empresa->medico = $medico;
        $empresa->crm = $crm;

        // Save the updated company data
        $empresa->save();

        return redirect()->back()->with('success', 'Empresa atualizada com sucesso')->with('empresa', $empresa);
    }
}