@extends('layouts.app')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-table"></i> Lista de Anamnese</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Atendimento</li>
                <li class="breadcrumb-item active"><a href="#">Histórico de Anamnese</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>CNS</th>
                                        <th>Editar</th>
                                        <th>Deletar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anamnese as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->paciente->name }} {{ $item->paciente->sobrenome }}</td>
                                            <td>{{ $item->paciente->cpf }}</td>
                                            <td>{{ $item->paciente->sus }}</td>
                                            <td>
                                                <div>
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->id }}">
                                                        Editar
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <form action="{{ route('anamnese.destroy', $item->id) }}" method="POST">
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
                                                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">
                                                            Editar Anamnese</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('anamnese.update', $item->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label"><strong>Nome:</strong></label>
                                                                    <input class="form-control" id="name"
                                                                        name="name" type="text" value="{{ $item->paciente->name }}" disabled>
                                                                </div>
                                                                <div class="mb-3 col-md-6">
                                                                    <label
                                                                        class="form-label"><strong>Sobrenome:</strong></label>
                                                                    <input class="form-control" id="sobrenome"
                                                                        name="sobrenome" type="text" value="{{ $item->paciente->sobrenome }}" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label"><strong>Nascimento:</strong></label>
                                                                    <input class="form-control" id="nasc" name="nasc" type="date" onchange="calculateAge()" value="{{ $item->paciente->nasc }}" disabled>
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label"><strong>Idade:</strong></label>
                                                                    <input class="form-control" id="idade" name="idade" type="text" disabled>
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label"><strong>Sexo:</strong></label>
                                                                    <input class="form-control" id="genero" name="genero" type="text" value="{{ $item->paciente->genero == 'M' ? 'Masculino' : 'Feminino' }}" disabled>
                                                                </div>
                                                                
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label"><strong>CNS:</strong></label>
                                                                    <input class="form-control" id="sus"
                                                                        name="sus" type="text" value="{{ $item->paciente->sus }}" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-3">
                                                                    <label
                                                                        class="form-label"><strong>Etnia:</strong></label>
                                                                    <input class="form-control" id="cor"
                                                                        name="cor" type="text" value="{{ $item->paciente->cor }}" disabled>
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label"><strong>CPF:</strong></label>
                                                                    <input class="form-control" id="cpf"
                                                                        name="cpf" type="text" value="{{ $item->paciente->cpf }}" disabled>
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label
                                                                        class="form-label"><strong>Telefone:</strong></label>
                                                                    <input class="form-control" id="telefone"
                                                                        name="telefone" type="text" value="{{ $item->paciente->telefone }}" disabled>
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label
                                                                        class="form-label"><strong>Celular:</strong></label>
                                                                    <input class="form-control" id="celular"
                                                                        name="celular" type="text" value="{{ $item->paciente->celular }}" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-12">
                                                                    <label class="form-label"><strong>Mãe:</strong></label>
                                                                    <input class="form-control" id="nome_mae"
                                                                        name="nome_mae" type="text" value="{{ $item->paciente->nome_mae }}" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-3">
                                                                    <label
                                                                        class="form-label"><strong>Endereço:</strong></label>
                                                                    <input class="form-control" id="rua"
                                                                        name="rua" type="text" value="{{ $item->paciente->rua }}" disabled>
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label
                                                                        class="form-label"><strong>Bairro:</strong></label>
                                                                    <input class="form-control" id="bairro"
                                                                        name="bairro" type="text" value="{{ $item->paciente->bairro }}" disabled>
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label
                                                                        class="form-label"><strong>Município:</strong></label>
                                                                    <input class="form-control" id="cidade"
                                                                        name="cidade" type="text" value="{{ $item->paciente->cidade }}" disabled>
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label"><strong>CEP:</strong></label>
                                                                    <input class="form-control" id="cep"
                                                                        name="cep" type="text" value="{{ $item->paciente->cep }}" disabled>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label"><strong>PA
                                                                            mmHg:</strong></label>
                                                                    <input class="form-control" id="pa"
                                                                        name="pa" type="text" value="{{ $item->pa }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label
                                                                        class="form-label"><strong>Temp(ºC):</strong></label>
                                                                    <input class="form-control" id="temp"
                                                                        name="temp" type="text" value="{{ $item->temp }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label
                                                                        class="form-label"><strong>Peso(Kg):</strong></label>
                                                                    <input class="form-control" id="peso"
                                                                        name="peso" type="text" value="{{ $item->peso }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label
                                                                        class="form-label"><strong>Altura(cm):</strong></label>
                                                                    <input class="form-control" id="altura"
                                                                        name="altura" type="text" value="{{ $item->altura }}">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-2">
                                                                    <label
                                                                        class="form-label"><strong>Gestante:</strong></label>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="gestante"
                                                                                value="S"{{ $item->gestante == 'S' ? 'checked' : '' }}>Sim
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="gestante"
                                                                                value="N"{{ $item->gestante == 'N' ? 'checked' : '' }}>Não
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label"><strong>Dextro
                                                                            (mg/dL):</strong></label>
                                                                    <input class="form-control" id="dextro"
                                                                        name="dextro" type="text" value="{{ $item->dextro }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label
                                                                        class="form-label"><strong>SpO2:</strong></label>
                                                                    <input class="form-control" id="spo2"
                                                                        name="spo2" type="text" value="{{ $item->spo2 }}">
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label
                                                                        class="form-label"><strong>F.C.:</strong></label>
                                                                    <input class="form-control" id="fc"
                                                                        name="fc" type="text" value="{{ $item->fc }}">
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label
                                                                        class="form-label"><strong>F.R.:</strong></label>
                                                                    <input class="form-control" id="fr"
                                                                        name="fr" type="text" value="{{ $item->fr }}">
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row" style="text-align: center">
                                                                <div class="mb-3 col-md-12">
                                                                    <label
                                                                        class="form-label"><strong>Acolhimento</strong></label>
                                                                    <input class="form-control" id="acolhimento"
                                                                        name="acolhimento" type="text" value="{{ $item->acolhimento }}">
                                                                </div>
                                                            </div>
                                                            <div class="row" style="text-align: center">
                                                                <div class="mb-3 col-md-12">
                                                                    <label class="form-label"><strong>Queixas Principais do
                                                                            Acolhimento</strong></label>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-3">
                                                                    <input class="form-control" id="acolhimento1"
                                                                        name="acolhimento1" type="text" value="{{ $item->acolhimento1 }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <input class="form-control" id="acolhimento2"
                                                                        name="acolhimento2" type="text" value="{{ $item->acolhimento2 }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <input class="form-control" id="acolhimento3"
                                                                        name="acolhimento3" type="text" value="{{ $item->acolhimento3 }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <input class="form-control" id="acolhimento4"
                                                                        name="acolhimento4" type="text" value="{{ $item->acolhimento4 }}">
                                                                </div>
                                                            </div>
                                                            <div class="row" style="text-align: center">
                                                                <div class="mb-3 col-md-12">
                                                                    <label
                                                                        class="form-label"><strong>Alergias</strong></label>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-4">
                                                                    <input class="form-control" id="alergia1"
                                                                        name="alergia1" type="text" value="{{ $item->alergia1 }}">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <input class="form-control" id="alergia2"
                                                                        name="alergia2" type="text" value="{{ $item->alergia2 }}">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <input class="form-control" id="alergia3"
                                                                        name="alergia3" type="text" value="{{ $item->alergia3 }}">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3">
                                                                    <label class="form-label"><strong>Anamnese / Exame
                                                                            Fisico:</strong></label>
                                                                    <textarea class="form-control" rows="5" id="anamnese" name="anamnese">{{ $item->anamnese }}</textarea>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
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
    
        // Call the function when the page loads to set the initial value
        window.onload = function() {
            calculateAge();
        }
    </script>
    
@endsection
