<!DOCTYPE html>
<html>
<head>
    <title>Ficha Médica</title>
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

    $dataNascimento = isset($paciente->nasc) ? new Carbon($paciente->nasc) : null;
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
                        <h4>{{ $emp->nome }}</h4>
                    </div>
                @endforeach
            </div>

            <!-- Divisão do título central -->
            <div class="text-center flex-grow">
                <h3>Ficha de Atendimento</h3>
            </div>

            <!-- Divisão do endereço -->
            <div class="address">
                @foreach($empresa as $emp)
                    <p>{{ $emp->rua }}
                        <br>
                        {{ $emp->bairro }}, Nº {{ $emp->numero }}
                        <br>
                        {{ $emp->cep }}, {{ $emp->cidade }}/{{ $emp->uf }}
                    </p>
                @endforeach
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
        <td colspan="21" style="position: relative;">
            @if(isset($paciente->imagem))
                <img src="{{ asset('images/' . $paciente->imagem) }}" alt="Imagem de {{ $paciente->name }}" style="max-width: 150px; position: absolute; top: 50%; right: 0; transform: translateY(-50%);">
            @else
                <p>Imagem não disponível</p>
            @endif
            Nome do Paciente: {{ $paciente->name ?? '-' }}<br>
            Nome Social: {{ $paciente->nome_social ?? '-' }}<br>
            CPF: {{ $paciente->cpf ?? '-' }}<br>
            RG: {{ $paciente->rg ?? '-' }}<br>
            Certidão de Nascimento: {{ $paciente->certidao ?? '-' }}<br>
            SUS: {{ $paciente->sus ?? '-' }}<br>
            Convênio: {{ $nomeConvenio }}<br>
            Matrícula: {{ $paciente->matricula ?? '-' }}<br>
            Número de referência: {{ $paciente->consulta ?? '-' }}<br>
        </td>
        </tr>
        <tr>
            <td class="equal-width">Data de Nascimento: {{ isset($paciente->nasc) ? (new Carbon($paciente->nasc))->format('d/m/Y') : '-' }}</td>
            <td class="equal-width">Idade: {{ $idade }} anos</td>
        </tr>
        <tr>
            <td class="equal-width">Gênero: {{ $paciente->genero ?? '-' }}</td>
            <td class="equal-width">Cor: {{ $paciente->cor ?? '-' }}</td>
        </tr>
        <tr>
            <td class="equal-width">Nome do Pai: {{ $paciente->nome_pai ?? '-' }}</td>
            <td class="equal-width">Nome da Mãe: {{ $paciente->nome_mae ?? '-' }}</td>
        </tr>
        <tr>
            <td class="equal-width">Acompanhante: {{ $paciente->acompanhante ?? '-' }}</td>
            <td class="equal-width">Estado Civil: {{ $paciente->estado_civil ?? '-' }}</td>
        </tr>
        <tr>
            <td class="equal-width">Telefone: {{ $paciente->telefone ?? '-' }}</td>
            <td class="equal-width">Celular: {{ $paciente->celular ?? '-' }}</td>
        </tr>
        <tr>
            <td class="equal-width">Rua: {{ $paciente->rua ?? '-' }}, Nº {{ $paciente->numero ?? '-' }}</td>
            <td class="equal-width">Bairro: {{ $paciente->bairro ?? '-' }}</td>
        </tr>
        <tr>
            <td class="equal-width">CEP: {{ $paciente->cep ?? '-' }}</td>
            <td class="equal-width">Cidade/UF: {{ $paciente->cidade ?? '-' }}/{{ $paciente->uf ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="2">PCD: {{ $paciente->pcd ?? '-' }}</td>
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
