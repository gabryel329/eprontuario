<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO_01_VERDE.png') }}">
    <title>eProntuario - Atestado</title>
    <style>
        @media print {
            @page {
                size: A4 landscape;
                margin: 0;
            }
            body {
                width: 50%;
                margin: 0;
                padding: 0;
                transform: scale(1);
                transform-origin: top left;
                position: absolute;
                top: 0;
                left: 0;
            }
            .print-button {
                display: none;
            }
        }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            position: relative; /* For the footer positioning */
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .signature {
            margin-top: 20px;
            text-align: right;
        }
        .print-button {
            display: block;
            margin: 20px 0;
        }
        .footer {
            position: absolute;
            bottom: 0; /* Position at the very bottom */
            left: 0; /* Align to the left */
            width: 100%;
            text-align: left;
            font-size: 10px; /* Smaller font size */
            padding: 5px 0;
            border-top: 1px solid #ccc; /* Border on top */
            background-color: #f9f9f9; /* Match the background */
        }
        .footer p {
            margin: 0;
            display: inline-block;
            margin-right: 15px; /* Space between items */
        }
        .company-logo {
            position: absolute;
            top: 20px; /* Adjust as needed */
            left: 20px; /* Adjust as needed */
            max-width: 50px; /* Adjust as needed */
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
            max-width: 50px;
            margin-right: 10px; /* Espaço entre a imagem e o nome */
        }
        .header-section .empresa-info .name {
            margin: 0;
        }
        .header-section .address {
            text-align: right;
        }
    </style>
</head>
<body>
    @if($empresas->isNotEmpty())
        <div class="header-section">
            <!-- Divisão da empresa (imagem e nome) -->
            <div class="empresa-info">
                @foreach($empresas as $emp)
                    <img src="{{ asset('images/' . $emp->imagem) }}" alt="{{ $emp->nome }}">
                    <div class="name">
                        <h4>{{ $emp->name }}</h4>
                    </div>
                @endforeach
            </div>

            <!-- Divisão do título central -->
            <div class="text-center flex-grow">
                <h3>ATESTADO</h3>
            </div>

            <!-- Divisão do endereço -->
            <div class="address">
                @if($empresas->isNotEmpty())
                    @foreach($empresas as $emp)
                        <p>{{ $emp->rua }}</p>
                        <p>{{ $emp->bairro }}, {{ $emp->cep }}</p>
                    @endforeach
                @endif
            </div>
        </div>
        @else
            <p style="text-align: center;">Nenhuma empresa encontrada.</p>
        @endif
    
    <h3>Dr(a). {{ $profissional->name }}</h3>
    <p>{{ $profissional->tipo }} - {{ $profissional->especialidade }} - {{ $profissional->conselho2 }}: {{ $profissional->conselho }}</p>
    <p>Atesto para os devidos fins, que o(a):</p>
    <table>
        <tr>
            <th>Sr(a)</th>
            <td>{{ $paciente->name }}</td>
        </tr>
        <tr>
            <th>Portador do CPF:</th>
            <td>{{ $paciente->cpf }}</td>
        </tr>
        <tr>
            <th>Esteve sob meus cuidados profissionais no período das:</th>
            <td>____ às ____ horas</td>
        </tr>
        <tr>
            <th>Do dia:</th>
            <td>{{ $currentDate }}</td>
        </tr>
        <tr>
            <th>Necessitando o(a) mesmo(a) de:</th>
            <td>{{ $dia }} dias afastados das suas atividades.</td>
        </tr>
    </table>
    <p>Obs: {{ $obs }}</p>
    <br>
    <div class="signature">
        <p>___________________________________</p>
        <p>Assinatura/Carimbo</p>
    </div>

    {{-- Assuming the first company in the list is the one to display the logo
    @if(count($empresas) > 0)
        <img src="{{ asset('images/' . $empresas[0]->imagem) }}" alt="Logo da Empresa" class="company-logo">
    @endif

    <div class="footer">
        @foreach ($empresas as $empresa)
            <p>{{ $empresa->name }} - {{ $empresa->telefone }}/{{ $empresa->celular }}</p>
            <p>{{ $empresa->bairro }} - {{ $empresa->rua }}</p>
            <p>{{ $empresa->cidade }} - {{ $empresa->uf }}</p>
        @endforeach
    </div> --}}

    {{-- <button class="print-button" onclick="window.print()">Imprimir</button> --}}
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
