@extends('layouts.app')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

@section('content')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i> Importar tabelas</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Administração</li>
                <li class="breadcrumb-item">Cadastros</li>
                <li class="breadcrumb-item"><a href="#">Importar tabelas</a></li>
            </ul>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-warning">{{ session('error') }}</div>
        @endif
        <div class="timeline-post">
            <div class="col-md-12">
                <ul class="nav nav-tabs user-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#vinculo" data-bs-toggle="tab">Tabelas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabelas" data-bs-toggle="tab">Portes</a></li>
                    <li class="nav-item"><a class="nav-link" href="#ch" data-bs-toggle="tab">CH</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tile tab-pane active" id="vinculo">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs user-tabs">
                                    <li class="nav-item"><a class="nav-link active" href="#xlsx"
                                            data-bs-toggle="tab">XLSX</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#txt" data-bs-toggle="tab">TXT</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tile tab-pane active" id="xlsx">
                                    <h1 class="text-center">Importar Tabela XLSX</h1>
                                    <div class="tile-body">
                                        <form id="pdf-form" enctype="multipart/form-data">
                                            <table class="table table-bordered text-center mt-4">
                                                <thead>
                                                    <tr>
                                                        <th>Brasindice</th>
                                                        <th>AMB 92</th>
                                                        <th>Simpro</th>
                                                        <th>AMB 96</th>
                                                        <th>CBHPM</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input type="radio" name="tabela" value="brasindice"
                                                                required>
                                                        </td>
                                                        <td><input type="radio" name="tabela" value="amb92"></td>
                                                        <td><input type="radio" name="tabela" value="simpro"></td>
                                                        <td><input type="radio" name="tabela" value="amb96"></td>
                                                        <td><input type="radio" name="tabela" value="cbhpm"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="form-group mt-3">
                                                <label for="file" class="form-label">Descrição do Arquivo</label>
                                                <input type="text" name="descricao" id="descricao"
                                                    placeholder="EX:(Edição 5 - 2010)" class="form-control" required>

                                            </div>

                                            <div class="form-group mt-3">
                                                <label for="file" class="form-label">Selecione o Arquivo
                                                    XLSX</label>
                                                <input type="file" name="file" id="file" class="form-control"
                                                    accept=".xlsx, .xls" required>

                                            </div>

                                            <button type="submit" class="btn btn-primary mt-3">Importar XLSX</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="tile tab-pane" id="txt">
                                    <h1 class="text-center">Importar Tabela TXT</h1>
                                    <div class="tile-body">
                                        <form action="{{ route('importarTxt') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <table class="table table-bordered text-center mt-4">
                                                <thead>
                                                    <tr>
                                                        <th>Brasindice</th>
                                                        <th>AMB 92</th>
                                                        <th>Simpro</th>
                                                        <th>AMB 96</th>
                                                        <th>CBHPM</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input type="radio" name="tabela" value="brasindice"
                                                                required></td>
                                                        <td><input type="radio" name="tabela" value="amb92"></td>
                                                        <td><input type="radio" name="tabela" value="simpro"></td>
                                                        <td><input type="radio" name="tabela" value="amb96"></td>
                                                        <td><input type="radio" name="tabela" value="cbhpm"></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!-- Descrição -->
                                            <div class="form-group mt-3">
                                                <label for="descricao" class="form-label">Descrição do Arquivo</label>
                                                <input type="text" name="descricao" id="descricao"
                                                    class="form-control" placeholder="EX:(Edição 5 - 2010)" required>
                                            </div>

                                            <!-- Upload do Arquivo -->
                                            <div class="form-group mt-3">
                                                <label for="file" class="form-label">Selecione o Arquivo TXT</label>
                                                <input type="file" name="file" id="file" class="form-control"
                                                    required>
                                            </div>

                                            <button type="submit" class="btn btn-primary mt-3">Importar TXT</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tile">
                                <h3 class="tile-title">Lista de Tabelas</h3>
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tabelas</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tabelas as $tabela)
                                                <tr>
                                                    <td>{{ $tabela }}</td>
                                                    <td>
                                                        <form action="{{ route('tabela.excluir', $tabela) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Tem certeza que deseja excluir esta tabela?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Excluir</button>
                                                        </form>
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
                <div class="tile tab-pane" id="tabelas">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="tile">
                                <h3 class="tile-title">Tabela de Honorário Médico</h3>
                                <div class="form-group">
                                    <form id="porte-form" action="{{ route('porte.salvar') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf <!-- Token CSRF para segurança -->
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label for="descricao">Descrição da tabela</label>
                                                <input type="text" name="descricao" id="descricao"
                                                    placeholder="EX:(Porte CBHPM (2016_2017))" class="form-control"
                                                    required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="uco">UCO</label>
                                                <input type="text" name="uco" id="uco"
                                                    class="form-control moeda" required>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <table border="1" cellspacing="0" cellpadding="14"
                                                    style="border-collapse: collapse; text-align: center;">
                                                    <tr>
                                                        <td>1A</td>
                                                        <td><input type="text" id="1a" class="moeda"
                                                                name="1a" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>5C</td>
                                                        <td><input type="text" id="5c" class="moeda"
                                                                name="5c" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>10B</td>
                                                        <td><input type="text" id="10b" class="moeda"
                                                                name="10b" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>1B</td>
                                                        <td><input type="text" id="1b" class="moeda"
                                                                name="1b" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>6A</td>
                                                        <td><input type="text" id="6a" class="moeda"
                                                                name="6a" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>10C</td>
                                                        <td><input type="text" id="10c" class="moeda"
                                                                name="10c" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>1C</td>
                                                        <td><input type="text" id="1c" class="moeda"
                                                                name="1c" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>6B</td>
                                                        <td><input type="text" id="6b" class="moeda"
                                                                name="6b" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>11A</td>
                                                        <td><input type="text" id="11a" class="moeda"
                                                                name="11a" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2A</td>
                                                        <td><input type="text" id="2a" class="moeda"
                                                                name="2a" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>6C</td>
                                                        <td><input type="text" id="6c" class="moeda"
                                                                name="6c" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>11B</td>
                                                        <td><input type="text" id="11b" class="moeda"
                                                                name="11b" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2B</td>
                                                        <td><input type="text" id="2b" class="moeda"
                                                                name="2b" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>7A</td>
                                                        <td><input type="text" id="7a" class="moeda"
                                                                name="7a" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>11C</td>
                                                        <td><input type="text" id="11c" class="moeda"
                                                                name="11c" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2C</td>
                                                        <td><input type="text" id="2c" class="moeda"
                                                                name="2c" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>7B</td>
                                                        <td><input type="text" id="7b" class="moeda"
                                                                name="7b" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>12A</td>
                                                        <td><input type="text" id="12a" class="moeda"
                                                                name="12a" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3A</td>
                                                        <td><input type="text" id="3a" class="moeda"
                                                                name="3a" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>7C</td>
                                                        <td><input type="text" id="7c" class="moeda"
                                                                name="7c" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>12B</td>
                                                        <td><input type="text" id="12b" class="moeda"
                                                                name="12b" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3B</td>
                                                        <td><input type="text" id="3b" class="moeda"
                                                                name="3b" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>8A</td>
                                                        <td><input type="text" id="8a" class="moeda"
                                                                name="8a" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>12C</td>
                                                        <td><input type="text" id="12c" class="moeda"
                                                                name="12c" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3C</td>
                                                        <td><input type="text" id="3c" class="moeda"
                                                                name="3c" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>8B</td>
                                                        <td><input type="text" id="8b" class="moeda"
                                                                name="8b" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>13A</td>
                                                        <td><input type="text" id="13a" class="moeda"
                                                                name="13a" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>4A</td>
                                                        <td><input type="text" id="4a" class="moeda"
                                                                name="4a" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>8C</td>
                                                        <td><input type="text" id="8c" class="moeda"
                                                                name="8c" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>13B</td>
                                                        <td><input type="text" id="13b" class="moeda"
                                                                name="13b" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>4B</td>
                                                        <td><input type="text" id="4b" class="moeda"
                                                                name="4b" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>9A</td>
                                                        <td><input type="text" id="9a" class="moeda"
                                                                name="9a" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>13C</td>
                                                        <td><input type="text" id="13c" class="moeda"
                                                                name="13c" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>4C</td>
                                                        <td><input type="text" id="4c" class="moeda"
                                                                name="4c" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>9B</td>
                                                        <td><input type="text" id="9b" class="moeda"
                                                                name="9b" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>14A</td>
                                                        <td><input type="text" id="14a" class="moeda"
                                                                name="14a" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>5A</td>
                                                        <td><input type="text" id="5a" class="moeda"
                                                                name="5a" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>9C</td>
                                                        <td><input type="text" id="9c" class="moeda"
                                                                name="9c" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>14B</td>
                                                        <td><input type="text" id="14b" class="moeda"
                                                                name="14b" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>5B</td>
                                                        <td><input type="text" id="5b" class="moeda"
                                                                name="5b" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>10A</td>
                                                        <td><input type="text" id="10a" class="moeda"
                                                                name="10a" style="width: 80px; text-align: right;">
                                                        </td>
                                                        <td></td>
                                                        <td>14C</td>
                                                        <td><input type="text" id="14c" class="moeda"
                                                                name="14c" style="width: 80px; text-align: right;">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Salvar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tile">
                                <h3 class="tile-title">Lista de Portes</h3>
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Portes</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($portes as $porte)
                                                <tr>
                                                    <td>{{ $porte }}</td>
                                                    <td>
                                                        <form action="{{ route('porte.excluir', $porte) }}" method="POST"
                                                            onsubmit="return confirm('Tem certeza que deseja excluir esta porte?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Excluir</button>
                                                        </form>
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
                <div class="tile tab-pane" id="ch">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="tile">
                                <h3 class="tile-title">Tabela de Honorário Médico</h3>
                                <div class="form-group">
                                    <form id="ch-form" action="{{ route('ch.salvar') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf <!-- Token CSRF para segurança -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="descricao">Descrição da tabela</label>
                                                <input type="text" name="descricao" id="descricao"
                                                    placeholder="EX:(AMB (2016_2017))" class="form-control"
                                                    required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="ch">CH</label>
                                                <input type="text" name="ch" id="ch"
                                                    class="form-control moeda" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="fr">F.R</label>
                                                <input type="text" name="fr" id="fr"
                                                    class="form-control moeda" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Salvar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tile">
                                <h3 class="tile-title">Lista de CH</h3>
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>CH</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ch as $ch)
                                                <tr>
                                                    <td>{{ $ch }}</td>
                                                    <td>
                                                        <form action="{{ route('ch.excluir', $ch) }}" method="POST"
                                                            onsubmit="return confirm('Tem certeza que deseja excluir esta CH?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Excluir</button>
                                                        </form>
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
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script>
        document.getElementById('pdf-form').addEventListener('submit', async function(e) {
            e.preventDefault(); // Impedir o comportamento padrão do formulário

            const fileInput = document.getElementById('file');
            const file = fileInput.files[0];

            if (!file) {
                alert('Por favor, selecione um arquivo Excel.');
                return;
            }

            if (file.type !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                alert('Por favor, selecione um arquivo .xlsx.');
                return;
            }

            const tabelaSelecionada = document.querySelector('input[name="tabela"]:checked');
            if (!tabelaSelecionada) {
                alert('Por favor, selecione uma tabela.');
                return;
            }

            const excelData = await extractExcelData(file);
            enviarParaLaravel(tabelaSelecionada.value, excelData);
        });

        async function extractExcelData(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();

                reader.onload = (e) => {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: 'array'
                    });
                    const allSheetsData = [];

                    workbook.SheetNames.forEach((sheetName) => {
                        const worksheet = workbook.Sheets[sheetName];
                        const sheetData = XLSX.utils.sheet_to_json(worksheet, {
                            header: 1
                        });

                        // Remove a primeira linha (cabeçalho)
                        sheetData.shift();

                        allSheetsData.push(...
                            sheetData); // Adiciona os dados da folha atual ao array total
                    });

                    resolve(allSheetsData);
                };

                reader.onerror = (error) => reject(error);
                reader.readAsArrayBuffer(file);
            });
        }

        function enviarParaLaravel(tabela, excelData) {
            const descricao = document.getElementById('descricao').value;

            fetch('/importar-excel', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        tabela: tabela,
                        descricao: descricao,
                        excel_data: excelData
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(text)
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Erro ao importar Excel.');
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao importar. Verifique a inconsistência.');
                });
        }

        // Função para aplicar máscara de moeda
        function aplicarMascaraMoeda(event) {
            let elemento = event.target;
            let valor = elemento.value;

            // Remove qualquer caractere que não seja dígito
            valor = valor.replace(/\D/g, "");

            // Formata o valor para moeda (2 casas decimais)
            valor = (valor / 100).toFixed(2) + "";
            valor = valor.replace(".", ",");
            valor = valor.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");

            elemento.value = valor;
        }

        // Seleciona todos os campos com a classe 'moeda' e aplica o evento
        document.querySelectorAll('.moeda').forEach(function(input) {
            input.addEventListener('input', aplicarMascaraMoeda);
        });
    </script>

@endsection
