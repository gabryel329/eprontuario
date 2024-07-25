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
                margin: 0;
                padding: 0;
                width: 100%;
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
@php
    use Carbon\Carbon;

    $dataNascimento = isset($dadosFormulario['nasc']) ? new Carbon($dadosFormulario['nasc']) : null;
    $idade = $dataNascimento ? $dataNascimento->age : '-';
@endphp
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


        <table>
            <thead>
                <tr>
                    <th colspan="2" class="title"><strong>Dados do Paciente</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">
                        Nome do Paciente: {{ $dadosFormulario['paciente'] ?? '-' }}<br>
                        CPF: {{ $dadosFormulario['cpf'] ?? '-' }}<br>
                        Número de referência: {{ $dadosFormulario['consulta'] ?? '-' }}<br>
                    </td>
                </tr>
                <tr>
                    <td class="equal-width">Data de Nascimento: {{ isset($dadosFormulario['nasc']) ? (new Carbon($dadosFormulario['nasc']))->format('d/m/Y') : '-' }}</td>
                    <td class="equal-width">Idade: {{ $idade }} anos</td>
                </tr>
                <tr>
                    <td class="equal-width">Gênero: {{ $dadosFormulario['genero'] ?? '-' }}</td>
                    <td class="equal-width">Nome da mãe: {{ $dadosFormulario['mae'] ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="9" class="title"><strong>Dados da Anamnese</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="1">Pressão Arterial (PA): {{ $dadosFormulario['pa'] ?? '-' }}</td>
                    <td colspan="1">Temperatura: {{ $dadosFormulario['temp'] ?? '-' }}ºC</td>
                    <td colspan="1">Peso: {{ $dadosFormulario['peso'] ?? '-' }}Kg</td>
                    <td colspan="1">Altura: {{ $dadosFormulario['altura'] ?? '-' }}cm</td>
                    <td colspan="1">Gestante: {{ $dadosFormulario['gestante'] == 'S' ? 'Sim' : 'Não' }}</td>
                </tr>
                <tr>
                    <td colspan="1">Dextro: {{ $dadosFormulario['dextro'] ?? '-' }}</td>
                    <td colspan="1">SPO2: {{ $dadosFormulario['spo2'] ?? '-' }}</td>
                    <td colspan="1">Frequência Cardíaca (FC): {{ $dadosFormulario['fc'] ?? '-' }}</td>
                    <td colspan="2">Frequência Respiratória (FR): {{ $dadosFormulario['fr'] ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="5" class="title"><strong>Acolhimentos</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="1">{{ $dadosFormulario['acolhimento'] ?? '-' }}</td>
                    <td colspan="1">{{ $dadosFormulario['acolhimento1'] ?? '-' }}</td>
                    <td colspan="1">{{ $dadosFormulario['acolhimento2'] ?? '-' }}</td>
                    <td colspan="1">{{ $dadosFormulario['acolhimento3'] ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="5" class="title"><strong>Alergias</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="1"> {{ $dadosFormulario['alergia1'] ?? '-' }}</td>
                    <td colspan="1"> {{ $dadosFormulario['alergia2'] ?? '-' }}</td>
                    <td colspan="1"> {{ $dadosFormulario['alergia3'] ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="5" class="title"><strong>Anamnese Geral</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5">{{ $dadosFormulario['anamnese'] ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="5" class="title"><strong>Dados do Atendimento</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td >Queixas: {{ $dadosFormulario['atendimento']['at_queixas'] ?? '-' }}</td>
                    <td c>Evolução: {{ $dadosFormulario['atendimento']['at_evolucao'] ?? '-' }}</td>
                    <td >Condição Física: {{ $dadosFormulario['atendimento']['at_condicao'] ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="5" class="title"><strong>Dados da Prescrição</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="1">
                        Exames:
                        @foreach ($dadosFormulario['prescricao']['exames'] ?? [] as $exame)
                            <li>{{ $exame }}</li>
                        @endforeach
                    </td>
                    <td colspan="1">
                        Medicação:
                        <ul>
                            @foreach ($dadosFormulario['prescricao']['remedios'] ?? [] as $index => $remedio)
                                <li>{{ $remedio }} / Doses: {{ $dadosFormulario['prescricao']['doses'][$index] ?? '-' }} / Horas: {{ $dadosFormulario['prescricao']['horas'][$index] ?? '-' }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>  
</body>
<script>
    // window.onload = function() {
    //     window.print();
    //     window.close(); // Opcional: fechar automaticamente a janela após a impressão
    // }
</script>
</html>
