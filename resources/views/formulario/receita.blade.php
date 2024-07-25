<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO_01_VERDE.png') }}">
    <title>eProntuario - Receituário</title>
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
            padding: 0;
        }
        .container {
            border: 1px solid #000;
            padding: 20px;
            margin: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100%;
        }
        .section {
            margin-bottom: 20px;
        }
        .section label {
            display: block;
            margin-bottom: 5px;
        }
        .space {
            border: 1px dashed #000;
            height: auto; /* Adjust based on content */
            margin-bottom: 20px;
            padding: 10px; /* Add padding for better visual spacing */
            text-align: center; /* Center the table horizontally */
        }
        .space table {
            border-collapse: collapse; /* Ensure borders are collapsed */
            margin: auto; /* Center the table horizontally */
        }
        .space th, .space td {
            border: 1px solid #000; /* Add border to table cells */
            padding: 8px; /* Add padding inside cells */
            text-align: center; /* Center text inside cells */
        }
        .footer {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
        .footer div {
            width: 48%;
        }
        .print-button {
            display: block;
            margin: 20px 0;
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
    <div class="container">
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
                <h3>RECEITUÁRIO</h3>
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
        <div class="section">
            <label for="paciente">Paciente: {{ $paciente->name }}</label>
            <label for="prescricao">Prescrição:</label>
            <div class="space">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Medicamento</th>
                        <th>Doses</th>
                        <th>H/H</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($remedios as $item)
                            <tr>
                                <td>{{ $item->remedios }}</td>
                                <td>{{ $item->dose }}</td>
                                <td>{{ $item->horas }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p>Obs.:________________________________</p>
        </div>
        <div class="footer">
            <div>
                <h4>IDENTIFICAÇÃO DO COMPRADOR</h4>
                <label>Nome:________________</label><br>
                <label>Ident.:________________</label><br>
                <label>Org. Emissor:______________</label><br>
                <label>End.:____________________</label><br>
                <label>Cidade:________________</label><br>
                <label>Telefone:__________________</label><br>
            </div>
            <div>
                <h4>IDENTIFICAÇÃO DO FORNECEDOR</h4>
                <label>Nome:________________</label><br>
                <label>Ident.:_____________________</label><br>
                <label>Org. Emissor:_________</label><br>
                <label>End.:____________________</label><br>
                <label>Cidade:________________</label><br>
                <label>Ass. do Farma: ___________________</label><br>
                <label>Data: __/__/____</label>
            </div>
        </div>

        <div class="signature">
            <p>___________________________________</p>
            <p>Assinatura/Carimbo {{ $currentDate }}</p>
        </div>
    </div>

    {{-- <button class="print-button" onclick="window.print()">Imprimir</button> --}}
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
