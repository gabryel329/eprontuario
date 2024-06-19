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
</head>

<style>
    .app-content {
        height: 100vh;
    }

    .card-body {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
</style>

<body class="app sidebar-mini">
    <!-- Sidebar menu-->
    <aside class="app-sidebar">
        <div class="app-sidebar__user-name" style="text-align: center;">
            <h5 style="color: white; text-transform: uppercase; font-weight: bold;">Pacientes Chamados</h5>
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
