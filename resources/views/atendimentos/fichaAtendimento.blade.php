<!DOCTYPE html>
<html>
<head>
    <title>Ficha Médica</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO_01_VERDE.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            width: 1000px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-header img {
            max-width: 150px;
            vertical-align: middle;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .title {
            font-weight: bold;
            text-align: center;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header-section .empresa-info {
            display: flex;
            align-items: center;
        }
        .header-section .empresa-info img {
            max-width: 100px;
            margin-right: 10px; /* Espaço entre a imagem e o nome */
        }
        .header-section .empresa-info .name {
            margin: 0;
        }
        .header-section .address {
            text-align: right;
        }
        @media print {
            body {
                width: 90%;
                height: 100%;
                font-size: 13pt;
            }
            .form-container {
                border: none;
                width: 100%;
                padding: 0;
                margin: 0;
            }
            .form-header img {
                max-width: 100px;
            }
            table, th, td {
                border: 1px solid black;
                padding: 8px;
            }
            .btn {
                display: none;
            }
            .equal-width {
                width: 50%;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        @if($empresa->isNotEmpty())
        <div class="header-section">
            <!-- Divisão da empresa (imagem e nome) -->
            <div class="empresa-info">
                @foreach($empresa as $emp)
                    <img src="{{ asset('images/' . $emp->imagem) }}" alt="{{ $emp->nome }}">
                    <div class="name">
                        <h4>{{ $emp->name }}</h4>
                    </div>
                @endforeach
            </div>

            <!-- Divisão do título central -->
            <div class="text-center flex-grow">
                <h3>Ficha de Atendimento</h3>
            </div>

            <!-- Divisão do endereço -->
            <div class="address">
                @if($empresa->isNotEmpty())
                    @foreach($empresa as $emp)
                        <p>{{ $emp->rua }}
                            <br>
                            {{ $emp->bairro }}, Nº {{ $emp->numero }}
                            <br>
                            {{ $emp->cep }}, {{ $emp->cidade }}/{{ $emp->uf }}
                        </p>
                    @endforeach
                @endif
            </div>
        </div>
        @else
            <p style="text-align: center;">Nenhuma empresa encontrada.</p>
        @endif
        @php
        use Carbon\Carbon;
    
        // Verifica se o valor de nascimento está definido e é válido
        $dataNascimento = isset($registro->nasc) ? new Carbon($registro->nasc) : null;
        $idade = $dataNascimento ? $dataNascimento->age : '-';
    @endphp

        @foreach($historico as $registro)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="title"><strong>Dados do Paciente</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">
                            Nome do Paciente: {{ $registro->paciente }}<br>
                            CPF: {{ $registro->cpf }}<br>
                            Cód. de Cadastro: {{ $registro->paciente_id }}<br>
                        </td>
                    </tr>
                    <tr>
                        <td class="equal-width">Data de Nascimento: {{ $registro->nasc }}</td>
                        <td class="equal-width">Idade: {{ $idade }} anos</td>
                    </tr>
                    <tr>
                        <td class="equal-width">Gênero: {{ $registro->genero }}</td>
                        <td class="equal-width">Nome da mãe: {{ $registro->mae }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="9" class="title"><strong>Dados da Anamnese</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="1">Pressão Arterial (PA): {{ $registro->an_pa }}</td>
                        <td colspan="1">Temperatura: {{ $registro->an_temp }}ºC</td>
                        <td colspan="1">Peso: {{ $registro->an_peso }}Kg</td>
                        <td colspan="1">Altura: {{ $registro->an_altura }}cm</td>
                        <td colspan="1">Gestante: {{ $registro->an_gestante }}</td>
                    </tr>
                    <tr>
                        <td colspan="1">Dextro: {{ $registro->an_dextro }}</td>
                        <td colspan="1">SPO2: {{ $registro->an_spo2 }}</td>
                        <td colspan="1">Frequência Cardíaca (FC): {{ $registro->an_fc }}</td>
                        <td colspan="2">Frequência Respiratória (FR): {{ $registro->an_fr }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="5" class="title"><strong>Acolhimentos</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="1">{{ $registro->an_acolhimento }}</td>
                        <td colspan="1">{{ $registro->an_acolhimento1 }}</td>
                        <td colspan="1">{{ $registro->an_acolhimento2 }}</td>
                        <td colspan="1">{{ $registro->an_acolhimento3 }}</td>
                        <td colspan="1">{{ $registro->an_acolhimento4 }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="5" class="title"><strong>Alergias</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="1">{{ $registro->an_alergia1 }}</td>
                        <td colspan="1">{{ $registro->an_alergia2 }}</td>
                        <td colspan="1">{{ $registro->an_alergia3 }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="5" class="title"><strong>Anamnese Geral</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">{{ $registro->an_anamnese }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="5" class="title"><strong>Dados do Atendimento</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Queixas: {{ $registro->at_queixas }}</td>
                        <td>Evolução: {{ $registro->at_evolucao }}</td>
                        <td>Condição Física: {{ $registro->at_condicao }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="title"><strong>Dados da Prescrição</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Procedimentos:</strong>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><strong>Código</strong></th>
                                        <th><strong>Procedimento</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $codigos = explode(',', $registro->codigos);
                                        $procedimentos = explode(',', $registro->procedimentos);
                                        $maxLength = max(count($codigos), count($procedimentos));
                                    @endphp
            
                                    @for ($i = 0; $i < $maxLength; $i++)
                                        <tr>
                                            <td>{{ $codigos[$i] ?? '' }}</td>
                                            <td>{{ $procedimentos[$i] ?? '' }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <strong>Medicação:</strong>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><strong>Medicamento</strong></th>
                                        <th><strong>Dose</strong></th>
                                        <th><strong>Hora</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $medicamentos = explode(',', $registro->medicamentos);
                                        $doses = explode(',', $registro->doses);
                                        $horas = explode(',', $registro->horas);
                                        $maxLength = max(count($medicamentos), count($doses), count($horas));
                                    @endphp
            
                                    @for ($i = 0; $i < $maxLength; $i++)
                                        <tr>
                                            <td>{{ $medicamentos[$i] ?? '' }}</td>
                                            <td>{{ $doses[$i] ?? '' }}</td>
                                            <td>{{ $horas[$i] ?? '' }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    </div>
</body>
<script>
    window.onload = function() {
        window.print();
    }
</script>
</html>
