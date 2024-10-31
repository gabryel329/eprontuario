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

        <div class="row">
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">Novo</h3>
                    <div class="tile-body">
                        <form id="pdf-form" enctype="multipart/form-data">
                            <table class="table table-bordered text-center">
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
                                        <td><input type="radio" name="tabela" value="brasindice" required></td>
                                        <td><input type="radio" name="tabela" value="amb92"></td>
                                        <td><input type="radio" name="tabela" value="simpro"></td>
                                        <td><input type="radio" name="tabela" value="amb96"></td>
                                        <td><input type="radio" name="tabela" value="cbhpm"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <label for="file">Descrição do Arquivo</label>
                                <input type="text" name="descricao" id="descricao" placeholder="EX:(Edição 5 - 2010)"
                                    class="form-control" required>

                            </div>

                            <div class="form-group">
                                <label for="file">Selecione o arquivo Excel</label>
                                <input type="file" name="file" id="file" class="form-control"
                                    accept=".xlsx, .xls" required>

                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">Lista de Tabelas</h3>
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
                                        <form action="{{ route('tabela.excluir', $tabela) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja excluir esta tabela?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                .catch(error => console.error('Erro:', error));
        }
    </script>

@endsection
