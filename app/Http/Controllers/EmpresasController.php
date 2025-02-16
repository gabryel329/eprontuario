<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Verifica se o usuário tem a permissão '3'
        if (!Auth::user()->permissoes->contains('id', 3)) {
            return redirect()->back()->with('error', 'Você não tem permissão para atualizar os dados da empresa.');
        }

        // Encontra a empresa pelo ID
        $empresa = Empresas::findOrFail($id);

        // Capitaliza o nome e o fantasia
        $name = ucfirst($request->input('name'));
        $fantasia = ucfirst($request->input('fantasia'));

        // Obter os outros inputs
        $telefone = $request->input('telefone');
        $cnpj = $request->input('cnpj');
        $email = $request->input('email');
        $cep = $request->input('cep');
        $cnes = $request->input('cnes');
        $rua = $request->input('rua');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $numero = $request->input('numero');
        $celular = $request->input('celular');
        $medico = $request->input('medico');
        $crm = $request->input('crm');
        $imagem = $request->file('imagem');
        $contrato = $request->input('contrato');
        $licenca = $request->input('licenca');

        // Verifica se uma nova imagem foi enviada e é válida
        if ($imagem && $imagem->isValid()) {
            $filenameWithExt = $imagem->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $imagem->getClientOriginalExtension();
            $imageName = $filename . '_' . time() . '.' . $extension;

            // Faz o upload da imagem para o diretório 'public/images/'
            $imagem->move(public_path('images/'), $imageName);

            // Remove a imagem antiga, se existir
            if ($empresa->imagem && file_exists(public_path('images/') . $empresa->imagem)) {
                unlink(public_path('images/') . $empresa->imagem);
            }

            // Atualiza a empresa com a nova imagem
            $empresa->imagem = $imageName;
        }

        // Atualiza os atributos da empresa
        $empresa->name = $name;
        $empresa->fantasia = $fantasia;
        $empresa->telefone = $telefone;
        $empresa->cnpj = $cnpj;
        $empresa->email = $email;
        $empresa->cep = $cep;
        $empresa->cnes = $cnes;
        $empresa->rua = $rua;
        $empresa->bairro = $bairro;
        $empresa->cidade = $cidade;
        $empresa->uf = $uf;
        $empresa->numero = $numero;
        $empresa->celular = $celular;
        $empresa->medico = $medico;
        $empresa->crm = $crm;
        $empresa->licenca = $licenca;
        $empresa->contrato = $contrato;

        // Salva os dados atualizados da empresa
        $empresa->save();

        return redirect()->back()->with('success', 'Empresa atualizada com sucesso')->with('empresa', $empresa);
    }

}