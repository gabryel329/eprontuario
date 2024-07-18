<!DOCTYPE html>
<html>
<head>
    <title>Solicitação de Exame ou Procedimento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            height: 100%;
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
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <img src="logo.png" alt="Logo">
            <h2>Ficha de Atendimento</h2>
        </div>
        <table>
            <tr>
                <td colspan="5"><strong>Dados da Anamnese</strong></td>
            </tr>
            <tr>
                <td colspan="5">NOME DO PACIENTE: ____<u>{{ $dadosFormulario['paciente'] ?? '-' }}</u>___</td>
            </tr>
            <tr>
                <td colspan="5"><strong>Dados da Anamnese</strong></td>
            </tr>
            <tr>
                <td colspan="2">Pressão Arterial (PA): ____<u>{{ $dadosFormulario['pa'] ?? '-' }}</u>___</td>
                <td colspan="3">Temperatura: ____<u>{{ $dadosFormulario['temp'] ?? '-' }}</u>___</td>
            </tr>
            <tr>
                <td colspan="2">Peso: ____<u>{{ $dadosFormulario['peso'] ?? '-' }}</u>___</td>
                <td colspan="3">Altura: ____<u>{{ $dadosFormulario['altura'] ?? '-' }}</u>___</td>
            </tr>
            <tr>
                <td colspan="5">Gestante: {{ $dadosFormulario['gestante'] == 'S' ? 'Sim' : 'Não' }}</td>
            </tr>
            <tr>
                <td colspan="2">Dextro: ____<u>{{ $dadosFormulario['dextro'] ?? '-' }}</u>___</td>
                <td colspan="3">SPO2: ____<u>{{ $dadosFormulario['spo2'] ?? '-' }}</u>___</td>
            </tr>
            <tr>
                <td colspan="2">Frequência Cardíaca (FC): ____<u>{{ $dadosFormulario['fc'] ?? '-' }}</u>___</td>
                <td colspan="3">Frequência Respiratória (FR): ____<u>{{ $dadosFormulario['fr'] ?? '-' }}</u>___</td>
            </tr>
            <tr>
                <td colspan="5"><strong>Acolhimentos</strong></td>
            </tr>
            <tr>
                <td colspan="2">Acolhimento: ____<u>{{ $dadosFormulario['acolhimento'] ?? '-' }}</u>___</td>
                <td colspan="3">Acolhimento-2: ____<u>{{ $dadosFormulario['acolhimento1'] ?? '-' }}</u>___</td>
            </tr>
            <tr>
                <td colspan="2">Acolhimento-3: ____<u>{{ $dadosFormulario['acolhimento2'] ?? '-' }}</u>___</td>
                <td colspan="3">Acolhimento-4: ____<u>{{ $dadosFormulario['acolhimento3'] ?? '-' }}</u>___</td>
            </tr>
            <tr>
                <td colspan="5"><strong>Alergias</strong></td>
            </tr>
            <tr>
                <td colspan="5">Alergias: ____<u>{{ $dadosFormulario['alergia1'] ?? '-' }}</u>___</td>
            </tr>
            <tr>
                <td colspan="2">Alergias-3: ____<u>{{ $dadosFormulario['alergia2'] ?? '-' }}</u>___</td>
                <td colspan="3">Alergias-4: ____<u>{{ $dadosFormulario['alergia3'] ?? '-' }}</u>___</td>
            </tr>
            <tr>
                <td colspan="5"><strong>Anamnese Geral</strong></td>
            </tr>
            <tr>
                <td colspan="5">Anamnese / Exame Fisico: {{ $dadosFormulario['anamnese'] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="5"><strong>Dados do Atendimento</strong></td>
            </tr>
            <tr>
                <td colspan="2">Queixas: ____<u>{{ $dadosFormulario['atendimento']['at_queixas'] ?? '-' }}</u>___</td>
                <td colspan="3">Atestado: ____<u>{{ $dadosFormulario['atendimento']['at_atestado'] ?? '-' }}</u>___</td>
            </tr>
            <tr>
                <td colspan="2">Evolução: ____<u>{{ $dadosFormulario['atendimento']['at_evolucao'] ?? '-' }}</u>___</td>
                <td colspan="3">Condição Física: ____<u>{{ $dadosFormulario['atendimento']['at_condicao'] ?? '-' }}</u>___</td>
            </tr>
            <tr>
                <td colspan="5"><strong>Dados da Prescrição</strong></td>
            </tr>
            <tr>
                <td colspan="5">
                    Exames:
                    @foreach ($dadosFormulario['prescricao']['exames'] ?? [] as $exame)
                        <li>{{ $exame }}</li>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    Remedios:
                    <ul>
                        @foreach ($dadosFormulario['prescricao']['remedios'] ?? [] as $index => $remedio)
                            <li>{{ $remedio }} / Doses:{{ $dadosFormulario['prescricao']['doses'][$index] ?? '-' }} / Horas:{{ $dadosFormulario['prescricao']['horas'][$index] ?? '-' }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>            
        </table>
    </div>
</body>
</html>
