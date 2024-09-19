<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\Pacientes;
use App\Models\Empresas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paciente = Pacientes::all();
        $convenios = Convenio::all();

        return view('cadastros.pacientes', compact(['paciente', 'convenios']));
    }

    public function index1()
    {
        $paciente = Pacientes::orderBy('id', 'asc')->paginate(10);
        $convenios = Convenio::all();

        return view('cadastros.listapacientes', compact(['paciente', 'convenios']));
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
            return redirect()->back()->withInput()->with('error', "CPF já cadastrado: <strong> Código: {$existeCpf->id} / Nome: {$existeCpf->name}. </strong> Tente novamente.");
        }

        // Verifica se já existe um paciente com o mesmo RG
        $rg = $request->input('rg');
        $existeRG = Pacientes::where('rg', $rg)->first();
        if ($existeRG) {
            return redirect()->back()->withInput()->with('error', "RG já cadastrado: <strong> Código: {$existeRG->id} / Nome: {$existeRG->name}. </strong> Tente novamente.");
        }

        // Verifica se já existe um paciente com o mesmo SUS, se o campo foi preenchido
        $sus = $request->input('sus');
        if (!empty($sus)) {
            $existeSUS = Pacientes::where('sus', $sus)->first();
            if ($existeSUS) {
                return redirect()->back()->withInput()->with('error', "SUS já cadastrado: <strong> Código: {$existeSUS->id} / Nome: {$existeSUS->name}. </strong> Tente novamente.");
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
        $estado_civil = $request->input('estado_civil');
        $pcd = $request->input('pcd');
        $acompanhante = $request->input('acompanhante');
        $genero = $request->input('genero');
        $certidao = $request->input('certidao');
        $convenio_id = $request->input('convenio_id');
        $matricula = $request->input('matricula');
        $plano = $request->input('plano');
        $titular = $request->input('titular');
        $produto = $request->input('produto');
        $cor = $request->input('cor');
        $imagem = $request->file('imagem');
    
        $imagem_base64 = $request->input('imagem');
    
        if ($imagem_base64) {
            // Remove o prefixo "data:image/jpeg;base64," ou "data:image/png;base64," da string base64
            $image_parts = explode(";base64,", $imagem_base64);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];  // Obtém o tipo da imagem (jpeg, png, etc.)
            $image_base64 = base64_decode($image_parts[1]);  // Decodifica a string base64

            // Cria um nome único para a imagem e define o caminho onde será salva
            $imageName = uniqid() . '.' . $image_type;
            $filePath = public_path('images/') . $imageName;

            // Salva a imagem no diretório 'public/images'
            $result = file_put_contents($filePath, $image_base64);
            
            // Verifica se houve erro ao salvar o arquivo
            if ($result === false) {
                return redirect()->back()->with('error', 'Erro ao salvar a imagem.');
            }
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
            'estado_civil' => $estado_civil,
            'pcd' => $pcd,
            'acompanhante' => $acompanhante,
            'genero' => $genero,
            'rg' => $rg,
            'certidao' => $certidao,
            'sus' => $sus,
            'convenio_id' => $convenio_id,
            'matricula' => $matricula,
            'plano' => $plano,
            'titular' => $titular,
            'produto' => $produto,
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
        $estado_civil = $request->input('estado_civil');
        $pcd = $request->input('pcd');
        $acompanhante = $request->input('acompanhante');
        $genero = $request->input('genero');
        $rg = $request->input('rg');
        $certidao = $request->input('certidao');
        $sus = $request->input('sus');
        $convenio_id = $request->input('convenio_id');
        $matricula = $request->input('matricula');
        $plano = $request->input('plano');
        $titular = $request->input('titular');
        $produto = $request->input('produto');
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
        $paciente->estado_civil = $estado_civil;
        $paciente->pcd = $pcd;
        $paciente->acompanhante = $acompanhante;
        $paciente->genero = $genero;
        $paciente->rg = $rg;
        $paciente->certidao = $certidao;
        $paciente->sus = $sus;
        $paciente->convenio_id = $convenio_id;
        $paciente->matricula = $matricula;
        $paciente->plano = $plano;
        $paciente->titular = $titular;
        $paciente->produto = $produto;
        $paciente->cor = $cor;

        // Save the updated paciente data
        $paciente->save();

        // Redirect with success message
        return redirect()->route('paciente.index1')->with('success', 'Paciente atualizado com sucesso')->with('paciente', $paciente);
    }




    // PacienteController.php
    public function fichaPaciente($id)
{
    // Busque os dados do paciente pelo id
    $paciente = Pacientes::find($id);

    // Verifique se o paciente foi encontrado
    if (!$paciente) {
        return redirect()->back()->with('error', 'Paciente não encontrado.');
    }

    // Busque os dados da empresa
    $empresa = Empresas::all();

    // Verifique se o paciente tem um convenio_id
    $nomeConvenio = '-'; // Defina um valor padrão caso o convênio não seja encontrado

    if ($paciente->convenio_id) {
        // Busque o convênio correspondente ao convenio_id do paciente
        $convenio = Convenio::find($paciente->convenio_id);

        // Se o convênio for encontrado, atribua o nome do convênio
        if ($convenio) {
            $nomeConvenio = $convenio->nome;
        }
    }
    
    // Retorne a view 'ficha' com os dados do paciente, da empresa e do nome do convênio
    return view('formulario.fichapaciente', compact('paciente', 'empresa', 'nomeConvenio'));
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

    public function handleWebcamError(Request $request)
    {
        session()->flash('error', 'Webcam não foi encontrada');
        return response()->json(['message' => 'Error message stored in session']);
    }

    public function checkWebcam(Request $request)
    {
        // Verifica se o erro foi enviado
        if ($request->has('error')) {
            // Armazena o erro na sessão
            Session::flash('error', $request->error);
            
            // Retorna uma resposta de erro
            return response()->json([
                'status' => 'error'
            ], 200); // 200 para garantir que o Ajax entenda que foi bem sucedido
        }

        return response()->json(['status' => 'success']);
    }
}
