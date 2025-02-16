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
            <h5 style="color: aliceblue">Pacientes Chamados</h5>
            <hr>
        </div>
        <ul class="app-menu" style="text-align: center; text-transform: uppercase; font-weight: bold;">
            <h1></h1>
            @foreach ($painelTudo->sortByDesc('created_at')->take(5) as $item)
            <li>
                <a class="app-menu__item">
                    <span class="app-menu__label">
                        {{ $item->paciente->name ?? 'N/A' }}<br>
                        @if ($item->permisao_id == 1)
                        Consultório {{ $item->sala_id }}
                        @elseif ($item->permisao_id == 2)
                        Guichê {{ $item->sala_id }}
                        @endif
                    </span>
                </a>
            </li>
            <hr>
            @endforeach
        </ul>
    </aside>
    <main class="app-content d-flex justify-content-center align-items-center flex-column">
        <div class="card text-center mb-4 flex-grow-1 w-100">
            <div class="card-body">
                <p id="patient-name" class="card-text" style="font-size: 4rem; text-transform: uppercase; font-weight: bold;">
                    {{ $painelUnico->paciente->name ?? 'Sem Pacientes' }}
                </p>
            </div>
        </div>
        <div class="card text-center flex-grow-1 w-100">
            <div class="card-body">
            @if ($painelUnico)
                <h5 id="location-type" class="card-title" style="font-size: 3rem; text-transform: uppercase; font-weight: bold;">
                    @if ($painelUnico->permisao_id == 1)
                    Consultório
                    @elseif ($painelUnico->permisao_id == 2)
                    Guichê
                    @endif
                </h5>
                <p id="room-number" class="card-text" style="font-size: 4rem; font-weight: bold;">
                    {{ $painelUnico->sala_id ?? 'N/A' }}
                </p>
            @else
                <h5 class="card-title" style="font-size: 3rem; text-transform: uppercase; font-weight: bold;">
                    Informação não disponível
                </h5>
                <p class="card-text" style="font-size: 4rem; font-weight: bold;">
                </p>
            @endif
            </div>
        </div>
    </main>

    <!-- Sound for new patient -->
    <audio id="newPatientSound" src="{{ asset('sounds/new_patient.mp3') }}" preload="auto"></audio>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- Page specific javascripts-->
    <!-- Google analytics script-->
    <script type="text/javascript">

        // Função para recarregar a página
        function recarregarPagina() {
            location.reload();
        }

        // Configura a recarga da página a cada 2 segundos (2000 milissegundos)
        setInterval(recarregarPagina, 2000);

        // Tocar som quando um novo paciente for mostrado
        let lastPatientCreatedAt = localStorage.getItem('lastPatientCreatedAt');
        const currentPatientCreatedAt = "{{ $painelUnico->created_at ?? 'N/A' }}";
        const currentPatientUpdatedAt = "{{ $painelUnico->updated_at ?? 'N/A' }}";

        if (currentPatientCreatedAt !== 'N/A' && lastPatientCreatedAt !== currentPatientCreatedAt) {
            document.getElementById('newPatientSound').play();
            localStorage.setItem('lastPatientCreatedAt', currentPatientCreatedAt);
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            function speak(text) {
                if ('speechSynthesis' in window) {
                    let speech = new SpeechSynthesisUtterance(text);
                    speech.lang = 'pt-BR'; // Define a língua para português do Brasil
                    window.speechSynthesis.speak(speech);
                } else {
                    console.log('Speech Synthesis not supported');
                }
            }

            // Capture the text to be read
            let patientName = document.getElementById('patient-name').innerText;
            let locationType = document.getElementById('location-type').innerText;
            let roomNumber = document.getElementById('room-number').innerText;

            // Construct the full text
            let fullText = `${patientName}, ${locationType}, ${roomNumber}`;

            // Speak the text if updated_at has changed
            let lastPatientUpdatedAt = localStorage.getItem('lastPatientUpdatedAt');
            if (currentPatientUpdatedAt !== 'N/A' && lastPatientUpdatedAt !== currentPatientUpdatedAt) {
                speak(fullText);
                localStorage.setItem('lastPatientUpdatedAt', currentPatientUpdatedAt);
            }
        });
    </script>
</body>

</html>
