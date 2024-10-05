@extends('layouts.app')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-table"></i> Lista de Profissionais</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Administração</li>
                <li class="breadcrumb-item active"><a href="#">Profissionais</a></li>
            </ul>
        </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 col-md-2">
                <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                    data-bs-target="#pacienteModal">Buscar <i class="bi bi-search"></i>
                </button>
            </div>
            <div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pacienteModalLabel">Selecione o Profissional</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <input class="form-control" id="pacienteSearch" type="text"
                                    placeholder="Pesquisar por nome ou CPF...">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover text-center" id="pacienteTable">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($profissioanls as $p)
                                            <tr>
                                                <td>{{ $p->name }}</td>
                                                <td>{{ $p->cpf }}</td>
                                                <td>
                                                    <a href="{{ route('profissional.edit', $p->id) }}" class="btn btn-success">
                                                        Selecionar
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Tipo de Profissional</th>
                                    <th>E-mail</th>
                                    <th>Editar</th>
                                    <th>Deletar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profissioanls as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ optional($item->tipoprof)->nome }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            <div>
                                            <a href="{{ route('profissional.edit', $item->id) }}" class="btn btn-info">
                                                Editar
                                            </a>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('profissional.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Modal for Editing -->
                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Editar Profissional</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('profissional.update', $item->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row">
                                                            <div class="mb-3 col-md-8">
                                                                <label class="form-label">Nome Completo</label>
                                                                <input class="form-control" name="name" type="text" value="{{ old('name', $item->name) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">E-mail</label>
                                                                <input class="form-control" name="email" type="email" value="{{ old('email', $item->email) }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Nascimento</label>
                                                                <input class="form-control" name="nasc" type="date" value="{{ old('nasc', $item->nasc) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">CPF</label>
                                                                <input class="form-control" name="cpf" type="text" value="{{ old('cpf', $item->cpf) }}" required>
                                                            </div>
                                                            <div class="mb-3 col-md-2">
                                                                <label class="form-label">Gênero</label>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="radio" name="genero" value="M" {{ old('genero', $item->genero) == 'M' ? 'checked' : '' }}>Masculino
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="radio" name="genero" value="F" {{ old('genero', $item->genero) == 'F' ? 'checked' : '' }}>Feminino
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Foto</label>
                                                                <input class="form-control" type="file" name="imagem">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Tipo de Profissional</label>
                                                                <select class="form-control" name="tipoprof_id" onchange="mostrarCamposEspecificos()">
                                                                    @foreach ($tipoprof as $tipo)
                                                                        <option value="{{ $tipo->id }}" {{ $item->tipoprof_id == $tipo->id ? 'selected' : '' }} data-conselho="{{ $tipo->conselho }}">
                                                                            {{ $tipo->nome }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>                                                                
                                                            </div>
                                                            <div class="mb-3 col-md-4 hidden" id="campo_conselho">
                                                                <label id="label_conselho" class="form-label">Conselho</label>
                                                                <input type="text" name="conselho" class="form-control" id="input_conselho" value="{{ old('conselho', $item->conselho) }}" placeholder="">
                                                                <div class="invalid-feedback">Por favor, preencha o campo Conselho.</div>
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Especialidades</label>
                                                                @foreach ($especialidades as $especialidade)
                                                                    <div class="form-check">
                                                                        <input 
                                                                            type="checkbox" 
                                                                            class="form-check-input" 
                                                                            id="especialidade_{{ $especialidade->id }}" 
                                                                            name="especialidade_id[]" 
                                                                            value="{{ $especialidade->id }}"
                                                                            {{ $item->especialidades->contains($especialidade->id) ? 'checked' : '' }}
                                                                        >
                                                                        <label class="form-check-label" for="especialidade_{{ $especialidade->id }}">
                                                                            {{ $especialidade->especialidade }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>                                                   
                                                        </div>
                                                        <div class="row" id="campos_comuns">
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">RG</label>
                                                                <input class="form-control" name="rg" type="text" value="{{ old('rg', $item->rg) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Étnia</label>
                                                                <select class="form-control" name="cor">
                                                                    <option disabled selected value="" style="font-size:18px;color: black;">{{ old('cor', $item->cor) }}</option>
                                                                    <option value="Branco" {{ old('cor', $item->cor) == 'Branco' ? 'selected' : '' }}>Branco</option>
                                                                    <option value="Preto" {{ old('cor', $item->cor) == 'Preto' ? 'selected' : '' }}>Preto</option>
                                                                    <option value="Amarelo" {{ old('cor', $item->cor) == 'Amarelo' ? 'selected' : '' }}>Amarelo</option>
                                                                    <option value="Pardo" {{ old('cor', $item->cor) == 'Pardo' ? 'selected' : '' }}>Pardo</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Telefone</label>
                                                                <input class="form-control" name="telefone" type="text" value="{{ old('telefone', $item->telefone) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Celular</label>
                                                                <input class="form-control" name="celular" type="text" value="{{ old('celular', $item->celular) }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">CBO</label>
                                                                <input class="form-control" name="cbo" type="text" id="cbo" value="{{ old('cbo', $item->cbo) }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">CEP</label>
                                                                <input class="form-control" name="cep" type="text" id="cep" value="{{ old('cep', $item->cep) }}" size="10" maxlength="9" onblur="pesquisacep(this.value);">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Rua</label>
                                                                <input class="form-control" name="rua" type="text" id="rua" value="{{ old('rua', $item->rua) }}" size="60">
                                                            </div>
                                                            <div class="mb-3 col-md-2">
                                                                <label class="form-label">Bairro</label>
                                                                <input class="form-control" name="bairro" type="text" id="bairro" value="{{ old('bairro', $item->bairro) }}" size="40">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Cidade</label>
                                                                <input class="form-control" name="cidade" type="text" id="cidade" value="{{ old('cidade', $item->cidade) }}" size="40">
                                                            </div>
                                                            <div class="mb-3 col-md-1">
                                                                <label class="form-label">Estado</label>
                                                                <input class="form-control" name="uf" type="text" id="uf" value="{{ old('uf', $item->uf) }}" size="2">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $profissioanls->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
document.getElementById('pacienteSearch').addEventListener('keyup', function() {
    var input = this.value.toLowerCase();
    var rows = document.getElementById('pacienteTable').getElementsByTagName('tbody')[0]
        .getElementsByTagName('tr');

    for (var i = 0; i < rows.length; i++) {
        var name = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
        var cpf = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
        
        // Verifica se o nome ou CPF contém o valor digitado no input
        if (name.includes(input) || cpf.includes(input)) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
});
$(document).ready(function(){
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 0000-0000');
    $('#celular').mask('(00) 00000-0000');
    $('#corem').mask('0000000-AA', {
        translation: {
            'A': { pattern: /[A-Za-z]/ },
            '0': { pattern: /\d/, optional: true }
        },
        onKeyPress: function(cep, event, currentField, options){
            var masks = ['000000-AA', '0000000-AA'];
            var mask = (cep.length > 5) ? masks[1] : masks[0];
            $('#corem').mask(mask, options);
        }
    });
    $('#crm').mask('000000-AA', {
        translation: {
            'A': { pattern: /[A-Za-z]/ }
        }
    });
    
});

document.addEventListener('DOMContentLoaded', function() {
    var permissoesSelect = document.getElementById('permisoes_id');
    var especialidadeDiv = document.getElementById('especialidade-div');
    var crmDiv = document.getElementById('crm-div');
    var coremDiv = document.getElementById('corem-div');

    permissoesSelect.addEventListener('change', function() {
        var selectedValue = permissoesSelect.value;

        if (selectedValue == '2') { // Certifique-se de que '2' é o ID correspondente a 'médico'
            especialidadeDiv.classList.remove('hidden');
            crmDiv.classList.remove('hidden');
            coremDiv.classList.add('hidden');
        } else if (selectedValue == '3') { // Certifique-se de que '3' é o ID correspondente a 'enfermeiro'
            especialidadeDiv.classList.remove('hidden');
            crmDiv.classList.add('hidden');
            coremDiv.classList.remove('hidden');
        } else {
            especialidadeDiv.classList.add('hidden');
            crmDiv.classList.add('hidden');
            coremDiv.classList.add('hidden');
        }
    });
});

function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('rua').value=("");
        document.getElementById('bairro').value=("");
        document.getElementById('cidade').value=("");
        document.getElementById('uf').value=("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua').value=(conteudo.logradouro);
        document.getElementById('bairro').value=(conteudo.bairro);
        document.getElementById('cidade').value=(conteudo.localidade);
        document.getElementById('uf').value=(conteudo.uf);
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}
    
function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua').value="...";
            document.getElementById('bairro').value="...";
            document.getElementById('cidade').value="...";
            document.getElementById('uf').value="...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};
   
function mostrarCamposEspecificos() {
    var selectElement = document.getElementsByName('tipoprof_id')[0];
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var conselho = selectedOption.getAttribute('data-conselho');
    
    var campoConselho = document.getElementById('campo_conselho');
    var labelConselho = document.getElementById('label_conselho');
    var inputConselho = document.getElementById('input_conselho');
    var campoEspecialidade = document.getElementById('campo_especialidade');
    var especialidadeSelect = document.getElementById('especialidade_id');
    
    if (conselho && conselho !== '') {
        labelConselho.textContent = conselho;
        inputConselho.placeholder = '123456-BA';
        inputConselho.setAttribute('required', true);
        especialidadeSelect.setAttribute('required', true);
        campoConselho.classList.remove('hidden');
        campoEspecialidade.classList.remove('hidden');
    } else {
        inputConselho.removeAttribute('required');
        especialidadeSelect.removeAttribute('required');
        campoConselho.classList.add('hidden');
        campoEspecialidade.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('tipoprof_id');
    const inputConselho = document.getElementById('input_conselho');
    const campoConselho = document.getElementById('campo_conselho');

    function atualizarCampoConselho() {
        const selectedValue = selectElement.value;
        if (selectedValue == 2) {
            inputConselho.disabled = true;
        } else {
            inputConselho.disabled = false;
        }
    }

    // Adiciona o listener de mudança no select
    selectElement.addEventListener('change', atualizarCampoConselho);

    // Inicializa o estado do campo com base no valor atual do select
    atualizarCampoConselho();
});
</script>
@endsection
