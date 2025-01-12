<header class="app-header">
    <a class="app-header__logo" href="/home">
        <img src="{{ asset('images/LOGO_01_HORIZONTAL.png') }}" alt="ePRONTUARIO" style="height: 35px;">
    </a>
    <!-- Sidebar toggle button-->
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
        <!--Notification Menu-->
        <!-- User Menu-->
        <li class="dropdown d-flex align-items-center">
            <!-- Exibe a data e hora -->
            <span id="current-date-time" class="me-3 text-white"></span>
            <a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu">
                <i class="bi bi-person fs-4"></i>
            </a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="http://esuporte.com.br:8090"><i class="bi bi-headset"></i> Suporte</a></li>
                @if (Auth::user()->permissoes->contains('id', 3))
                    <li><a type="button" onclick="abrirNovaJanela1();" class="dropdown-item"><i class="bi bi-person-vcard"></i> Tela de Chamado</a></li>
                @endif
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2 fs-5"></i> Sair
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</header>

<script>
    // Função para formatar a data e hora de forma mais limpa
    function updateDateTime() {
        const dateTimeElement = document.getElementById('current-date-time');
        const now = new Date();

        // Formata a data e hora de forma dinâmica
        const day = String(now.getDate()).padStart(2, '0'); // Dia com dois dígitos
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Mês com dois dígitos
        const year = now.getFullYear(); // Ano completo
        const hours = String(now.getHours()).padStart(2, '0'); // Hora com dois dígitos
        const minutes = String(now.getMinutes()).padStart(2, '0'); // Minutos com dois dígitos

        // Exibição no formato: 10/01/2025 - 14:36
        const formattedDate = `${day}/${month}/${year}`;
        const formattedTime = `${hours}:${minutes}`;

        dateTimeElement.textContent = `${formattedDate} - ${formattedTime}`;
    }

    // Atualiza a cada segundo
    setInterval(updateDateTime, 1000);
    updateDateTime(); // Atualiza imediatamente ao carregar a página
</script>

<style>
    #current-date-time {
        color: white; /* Define o texto em branco */
        font-size: 14px; /* Ajusta o tamanho do texto */
    }
</style>
''
