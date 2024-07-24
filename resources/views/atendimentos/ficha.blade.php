<!DOCTYPE html>
<html>
<head>
    <title>Ficha Médica</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        .form-container {
            width: 800px;
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
        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 210mm;
                height: 297mm;
                font-size: 12pt;
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
        <div class="form-header">
            <h2>Ficha de Atendimento</h2>
        </div>
        <table>
            <table border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center"><strong>Dados do Paciente</strong></th>
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
                        <td class="equal-width">Data de Nascimento: {{ $dadosFormulario['nasc'] ?? '-' }}</td>
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
                        <td colspan="9" style="text-align: center"><strong>Dados da Anamnese</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
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
                    </tr>
                </tbody>
            </table>
        <table>
            <thead>
                <tr>
                    <td colspan="5" style="text-align: center"><strong>Acolhimentos</strong></td>
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
                    <td colspan="5" style="text-align: center"><strong>Alergias</strong></td>
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
                <td colspan="5" style="text-align: center"><strong>Anamnese Geral</strong></td>
            </thead>
            <tbody>
                <td colspan="5">{{ $dadosFormulario['anamnese'] ?? '-' }}</td>
            </tbody>
        </table>
        <table>
            <thead>
                <td colspan="5" style="text-align: center"><strong>Dados do Atendimento</strong></td>
            </thead>
            <tbody>
                <td colspan="1">Queixas: {{ $dadosFormulario['atendimento']['at_queixas'] ?? '-' }}</td>
                <td colspan="1">Atestado: {{ $dadosFormulario['atendimento']['at_atestado'] ?? '-' }}</td>
                <td colspan="1">Evolução: {{ $dadosFormulario['atendimento']['at_evolucao'] ?? '-' }}</td>
                <td colspan="1">Condição Física: {{ $dadosFormulario['atendimento']['at_condicao'] ?? '-' }}</td>
            </tbody>
        </table>
        <table>
            <thead>
                <td colspan="5" style="text-align: center"><strong>Dados da Prescrição</strong></td>
            </thead>
            <tbody>
                <td colspan="1">
                    Exames:
                    @foreach ($dadosFormulario['prescricao']['exames'] ?? [] as $exame)
                        <li>{{ $exame }}</li>
                    @endforeach
                </td>
                <td colspan="1">
                    Remedios:
                    <ul>
                        @foreach ($dadosFormulario['prescricao']['remedios'] ?? [] as $index => $remedio)
                        <li>{{ $remedio }} / Doses:{{ $dadosFormulario['prescricao']['doses'][$index] ?? '-' }} / Horas:{{ $dadosFormulario['prescricao']['horas'][$index] ?? '-' }}</li>
                        @endforeach
                    </ul>
                </td>
            </tbody>
        </table>
    </div>  
</body>
<script>
// window.onload = function() {
// window.print();
// window.close(); // Opcional: fechar automaticamente a janela após a impressão
// }
</script>
</html>