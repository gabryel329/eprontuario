@extends('layouts.app')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-ui-checks"></i> Anamnese</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Atendimento</li>
            <li class="breadcrumb-item"><a href="#">Anamnese</a></li>
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
            <div class="tile">
                <h3 class="tile-title">Ficha de Anamnese</h3>
                <div class="tile-body">
                    <form method="POST" action="{{ route('anamnese.store') }}">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#pacienteModal">
                                    Selecionar Paciente
                                </button>
                            </div>
                            <div class="mb-3 col-md-9">
                                <label class="form-label"><strong>Nome Completo:</strong></label>
                                <input class="form-control" id="paciente_id" name="paciente_id" type="text" hidden>
                                <input class="form-control" id="name" name="name" type="text" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Nascimento:</strong></label>
                                <input class="form-control" id="nasc" name="nasc" type="date" onchange="calculateAge()" disabled>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Idade:</strong></label>
                                <input class="form-control" id="idade" name="idade" type="text" disabled>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Sexo:</strong></label>
                                <input class="form-control" id="genero" name="genero" type="text" disabled>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>CNS:</strong></label>
                                <input class="form-control" id="sus" name="sus" type="text" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Etnia:</strong></label>
                                <input class="form-control" id="cor" name="cor" type="text" disabled>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>CPF:</strong></label>
                                <input class="form-control" id="cpf" name="cpf" type="text" disabled>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Telefone:</strong></label>
                                <input class="form-control" id="telefone" name="telefone" type="text" disabled>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Celular:</strong></label>
                                <input class="form-control" id="celular" name="celular" type="text" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label"><strong>Mãe:</strong></label>
                                <input class="form-control" id="nome_mae" name="nome_mae" type="text" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Endereço:</strong></label>
                                <input class="form-control" id="rua" name="rua" type="text" disabled>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Bairro:</strong></label>
                                <input class="form-control" id="bairro" name="bairro" type="text" disabled>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Município:</strong></label>
                                <input class="form-control" id="cidade" name="cidade" type="text" disabled>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>CEP:</strong></label>
                                <input class="form-control" id="cep" name="cep" type="text" disabled>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Peso (Kg):</strong></label>
                                <input class="form-control" id="peso" name="peso" type="text" oninput="calcularIMC()">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Altura (m):</strong></label>
                                <input class="form-control" id="altura" name="altura" type="text" oninput="calcularIMC()">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>IMC:</strong></label>
                                <input class="form-control" id="imc" name="imc" type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Classificação:</strong></label>
                                <input class="form-control" id="classificacao" name="classificacao" type="text" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label"><strong>PA mmHg:</strong></label>
                                <input class="form-control" id="pa" name="pa" type="text">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label"><strong>Temp(ºC):</strong></label>
                                <input class="form-control" id="temp" name="temp" type="text">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label"><strong>Gestante:</strong></label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="gestante" value="S">Sim
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="gestante" value="N">Não
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>Dextro (mg/dL):</strong></label>
                                <input class="form-control" id="dextro" name="dextro" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>SpO2:</strong></label>
                                <input class="form-control" id="spo2" name="spo2" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>F.C.:</strong></label>
                                <input class="form-control" id="fc" name="fc" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label"><strong>F.R.:</strong></label>
                                <input class="form-control" id="fr" name="fr" type="text">
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="text-align: center">
                            <div class="mb-3 col-md-12">
                                <label class="form-label"><strong>Acolhimento</strong></label>
                                <input class="form-control" id="acolhimento" name="acolhimento" type="text">
                            </div>
                        </div>
                        <div class="row" style="text-align: center">
                            <div class="mb-3 col-md-12">
                                <label class="form-label"><strong>Queixas Principais do Acolhimento</strong></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <input class="form-control" id="acolhimento1" name="acolhimento1" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <input class="form-control" id="acolhimento2" name="acolhimento2" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <input class="form-control" id="acolhimento3" name="acolhimento3" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <input class="form-control" id="acolhimento4" name="acolhimento4" type="text">
                            </div>
                        </div>
                        <div class="row" style="text-align: center">
                            <div class="mb-3 col-md-12">
                                <label class="form-label"><strong>Alergias</strong></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <input class="form-control" id="alergia1" name="alergia1" type="text">
                            </div>
                            <div class="mb-3 col-md-4">
                                <input class="form-control" id="alergia2" name="alergia2" type="text">
                            </div>
                            <div class="mb-3 col-md-4">
                                <input class="form-control" id="alergia3" name="alergia3" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label"><strong>Anamnese / Exame Fisico:</strong></label>
                                <textarea class="form-control" rows="5" id="anamnese" name="anamnese"></textarea>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i
                                    class="bi bi-check-circle-fill me-2"></i>Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pacienteModalLabel">Selecione o Paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input class="form-control" id="pacienteSearch" type="text" placeholder="Pesquisar por nome ou CPF...">
                </div>
                <table class="table table-hover" id="pacienteTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Nome Social</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pacientes as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->name }}</td>
                                <td>{{ $p->cpf }}</td>
                                <td>{{ $p->nome_social }}</td>
                                <td>
                                    <button class="btn btn-primary" type="button" onclick="selectPaciente('{{ $p->id }}', '{{ $p->name }}', '{{ $p->nasc }}', '{{ $p->genero }}', '{{ $p->sus }}', '{{ $p->cor }}', '{{ $p->cpf }}', '{{ $p->telefone }}', '{{ $p->celular }}', '{{ $p->nome_mae }}', '{{ $p->rua }}', '{{ $p->bairro }}', '{{ $p->cidade }}', '{{ $p->cep }}')">Selecionar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function calcularIMC() {
    const peso = parseFloat(document.getElementById('peso').value);
    const altura = parseFloat(document.getElementById('altura').value);

    if (!isNaN(peso) && !isNaN(altura) && altura > 0) {
        const imc = peso / (altura * altura);
        document.getElementById('imc').value = imc.toFixed(2);

        let classificacao = '';
        if (imc < 18.5) {
            classificacao = 'Peso baixo';
        } else if (imc >= 18.5 && imc <= 24.9) {
            classificacao = 'Peso normal';
        } else if (imc >= 25 && imc <= 29.9) {
            classificacao = 'Acima do peso';
        } else {
            classificacao = 'Obesidade';
        }
        document.getElementById('classificacao').value = classificacao;
    } else {
        document.getElementById('imc').value = '';
        document.getElementById('classificacao').value = '';
    }
}

// Aplica máscaras aos campos de peso e altura
document.addEventListener('DOMContentLoaded', function() {
    Inputmask({
        alias: 'numeric',
        groupSeparator: '.',
        autoGroup: true,
        digits: 1,
        digitsOptional: false,
        placeholder: '0'
    }).mask(document.getElementById('peso'));

    Inputmask({
        alias: 'numeric',
        groupSeparator: '.',
        autoGroup: true,
        digits: 2,
        digitsOptional: false,
        placeholder: '0'
    }).mask(document.getElementById('altura'));
});

    document.getElementById('pacienteSearch').addEventListener('keyup', function() {
        var input = this.value.toLowerCase();
        var rows = document.getElementById('pacienteTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (var i = 0; i < rows.length; i++) {
            var name = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
            var cpf = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
            if (name.indexOf(input) > -1 || cpf.indexOf(input) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    });
    
    function calculateAge() {
        var birthDate = document.getElementById('nasc').value;
        if (birthDate) {
            var today = new Date();
            var birthDate = new Date(birthDate);
            var age = today.getFullYear() - birthDate.getFullYear();
            var monthDifference = today.getMonth() - birthDate.getMonth();

            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            document.getElementById('idade').value = age;
        }
    }

    function selectPaciente(id, name, nasc, genero, sus, cor, cpf, telefone, celular, nome_mae, rua, bairro, cidade, cep) {
        document.getElementById('name').value = name;
        document.getElementById('paciente_id').value = id;
        document.getElementById('nasc').value = nasc;
        document.getElementById('genero').value = genero;
        document.getElementById('sus').value = sus;
        document.getElementById('cor').value = cor;
        document.getElementById('cpf').value = cpf;
        document.getElementById('telefone').value = telefone;
        document.getElementById('celular').value = celular;
        document.getElementById('nome_mae').value = nome_mae;
        document.getElementById('rua').value = rua;
        document.getElementById('bairro').value = bairro;
        document.getElementById('cidade').value = cidade;
        document.getElementById('cep').value = cep;

        calculateAge();
        
        // Fecha o modal
        var modal = bootstrap.Modal.getInstance(document.getElementById('pacienteModal'));
        modal.hide();
    }
    </script>
@endsection
