@extends('layouts.app')

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
                                <label for="file">Selecione o arquivo PDF</label>
                                <input type="file" name="file" id="file" class="form-control" accept=".pdf"
                                    required>
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
                            @foreach($tabelas as $tabela)
                            <tr>
                                <td>{{ $tabela }}</td>
                                <td>
                                    <form action="{{ route('tabela.excluir', $tabela) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta tabela?');">
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
                alert('Por favor, selecione um arquivo PDF.');
                return;
            }

            const tabelaSelecionada = document.querySelector('input[name="tabela"]:checked');
            if (!tabelaSelecionada) {
                alert('Por favor, selecione uma tabela.');
                return;
            }

            const pdfText = await extractPdfText(file);
            enviarParaLaravel(tabelaSelecionada.value, pdfText);
        });

        async function extractPdfText(file) {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({
                data: arrayBuffer
            }).promise;
            let data = [];
            let isFirstPage = true; // Controla a primeira página para ignorar o cabeçalho

            // Iterar por todas as páginas do PDF
            for (let i = 1; i <= pdf.numPages; i++) {
                const page = await pdf.getPage(i);
                const textContent = await page.getTextContent();

                let pageData = textContent.items.map(item => item.str.trim());

                // Ignorar cabeçalhos repetidos nas páginas seguintes
                if (isFirstPage) {
                    isFirstPage = false;
                } else {
                    // Remover as primeiras linhas que são cabeçalhos repetidos
                    pageData = pageData.slice(1);
                }

                // Combinar itens em uma única linha e dividir por colunas
                let joinedLine = pageData.join(' ');
                let rows = joinedLine.split(/\n/); // Dividir por quebras de linha

                // Processar cada linha separadamente
                rows.forEach(row => {
                    const columns = row.split(/\s{2,}/); // Dividir por espaços múltiplos
                    if (columns.length > 1) { // Inserir apenas se houver dados válidos
                        data.push(columns);
                    }
                });
            }

            console.log(data); // Verificar os dados extraídos no console
            return data;
        }


        function enviarParaLaravel(tabela, pdfText) {
            fetch('/importar-excel', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        tabela: tabela,
                        pdf_text: pdfText
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                    } else {
                        alert('Erro ao importar PDF.');
                    }
                })
                .catch(error => console.error('Erro:', error));
        }
    </script>

@endsection
