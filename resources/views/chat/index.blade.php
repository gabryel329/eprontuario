<!DOCTYPE html>
<html lang="en">

<head>
    <title>ePRONTUÁRIO</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css') }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO_01_VERDE.png') }}">
    <style>
        /* Ajuste para garantir que o cabeçalho preencha toda a largura da tela */
        .app-header {
            display: flex;
            justify-content: center; /* Alinha o conteúdo horizontalmente no centro */
            align-items: center;     /* Alinha o conteúdo verticalmente no centro */
            height: 60px;            /* Ajuste a altura conforme necessário */
            width: 100%;             /* Faz o cabeçalho ocupar toda a largura da tela */
            background-color: #145046;  /* Adicione uma cor de fundo para contraste */
            position: fixed;         /* Faz o cabeçalho ficar fixo no topo da página */
            top: 0;                  /* Posiciona o cabeçalho no topo da página */
            left: 0;                 /* Posiciona o cabeçalho no lado esquerdo da página */
            z-index: 1000;           /* Garante que o cabeçalho fique acima de outros elementos */
        }

        .app-header__logo {
            display: flex;
            justify-content: center;
            align-items: center;
            width: auto; /* Ajuste a largura do link conforme necessário */
        }

        .header-content {
            display: flex;
            justify-content: center;
            align-items: center; /* Alinha verticalmente o conteúdo dentro do div */
            height: 100%;        /* Faz o conteúdo ocupar toda a altura do cabeçalho */
        }

        .header-image {
            max-height: 50px; /* Ajuste a altura máxima da imagem para se adequar ao cabeçalho */
            max-width: 100%;  /* Garante que a imagem não ultrapasse a largura do cabeçalho */
        }

        .app-content {
            min-height: calc(100vh - 60px); /* Ajusta a altura mínima do conteúdo principal */
            margin-top: 60px;              /* Adiciona margem superior para o cabeçalho fixo */
            padding: 30px;
            background-color: #1D695C;
        }

        .card-body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        /* Outras regras de estilo podem permanecer inalteradas */
    </style>
</head>

<body>
    <header class="app-header">
        <a class="app-header__logo" href="/home">
            <div class="header-content">
                <img src="{{ asset('images/LOGO_01_HORIZONTAL.png') }}" alt="ePRONTUARIO" class="header-image">
            </div>
        </a>
    </header>

    <!-- Sidebar menu-->
    <aside class="app-sidebar" style="background-color: #1D695C">
        <div class="app-sidebar__user-name" style="text-align: center;">
            <h5 style="color: aliceblue">Call Interno</h5>
            <hr>
        </div>
        <ul class="app-menu" style="text-align: center; text-transform: uppercase; font-weight: bold;">
            <h3>Usuários</h3>
            <ul class="list-group">
                @foreach ($users as $user)
                    <li class="list-group-item">
                        <a href="#" class="open-chat" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                            {{ $user->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </ul>
    </aside>
    <main class="app-content d-flex justify-content-center align-items-center flex-column">

    </main>
    <!-- Modal para abrir o chat com iframe -->
    <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chatModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Iframe que será carregado via AJAX -->
                    <iframe id="chatIframe" src="" width="100%" height="400px" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <form id="chatForm">
                        @csrf
                        <input type="hidden" name="destinatario_id" id="destinatario_id">
                        <textarea name="messagem" class="form-control" placeholder="Digite sua mensagem"></textarea>
                        <button type="submit" class="btn btn-primary mt-2">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="js/jquery-3.7.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.open-chat').forEach(item => {
        item.addEventListener('click', function () {
            let userId = this.dataset.userId;
            let userName = this.dataset.userName;
            document.getElementById('chatModalLabel').innerText = "Chat com " + userName;
            document.getElementById('destinatario_id').value = userId;

            // Atualiza o src do iframe para carregar as mensagens do chat
            let iframe = document.getElementById('chatIframe');
            iframe.src = '/chat/' + userId;  // Aqui estamos definindo a URL que será carregada no iframe

            // Exibe o modal com o iframe
            new bootstrap.Modal(document.getElementById('chatModal')).show();
        });
    });

    // Captura o envio do formulário de chat com AJAX
    $('#chatForm').on('submit', function (e) {
        e.preventDefault(); // Previne o comportamento padrão de envio do formulário

        var form = $(this);
        var url = "{{ route('chat.store') }}"; // Rota do seu controlador

        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(), // Serializa os dados do formulário
            success: function (response) {
                // Limpa o campo de mensagem
                $('textarea[name="messagem"]').val('');

                // Atualiza o iframe com as mensagens mais recentes
                var iframe = document.getElementById('chatIframe');
                iframe.src = iframe.src; // Força o recarregamento do iframe

            },
            error: function (xhr, status, error) {
                // Lidar com erros
                alert("Ocorreu um erro ao enviar a mensagem.");
            }
        });
    });
});

</script>


</html>
