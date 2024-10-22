@php
    use Carbon\Carbon;

    // Obtemos a data de licen�a e a data atual
    $empresa = \App\Models\Empresas::first();
    $dataLicenca = $empresa ? Carbon::parse($empresa->licenca)->startOfDay() : null;
    $dataAtual = Carbon::now()->startOfDay(); // Usamos apenas a data, sem o hor�rio

    // Calculamos a diferen�a de dias entre a data atual e a data de licen�a
    $diasRestantes = $dataLicenca ? $dataAtual->diffInDays($dataLicenca, false) : null;
@endphp
<style>
    .license-message {
        position: fixed;
        right: 20px;
        bottom: 20px;
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 5px;
        font-size: 14px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
</style>
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
        {{-- <li class="app-search">
            <input class="app-search__input" type="search" placeholder="Search">
            <button class="app-search__button"><i class="bi bi-search"></i></button>
        </li> --}}
        <li class="dropdown">
            <a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu">
                <i class="bi bi-person fs-4"></i>
            </a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                {{-- <li><a class="dropdown-item" href="page-user.html"><i class="bi bi-gear me-2 fs-5"></i> Settings</a></li> --}}
                {{-- <li><a class="dropdown-item" href="page-user.html"><i class="bi bi-person me-2 fs-5"></i> Perfil</a></li> --}}
                <li><a class="dropdown-item" href="http://esuporte.com.br:8090"><i class="bi bi-headset"></i>
                        Suporte</a></li>
                @if (Auth::user()->permissoes->contains('id', 3))
                    <li><a type="button" onclick="abrirNovaJanela1();" class="dropdown-item"><i
                                class="bi bi-person-vcard"></i> Tela de Chamado</a></li>
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
    <!-- Verifica as condi��es e exibe a mensagem -->
    @if ($dataLicenca && $diasRestantes !== null)
        @if ($diasRestantes > 2)
            <!-- N�o exibe mensagem, data futura -->
        @elseif ($diasRestantes <= 2 && $diasRestantes >= 0)
            <div class="license-message">
                Sua licença expira em {{ $dataLicenca->format('d/m/Y') }}.
            </div>
        @elseif ($diasRestantes < 0)
            <div class="license-message">
                Sua licença expirou em {{ $dataLicenca->format('d/m/Y') }}.
            </div>
        @endif
    @endif
    <script>
        function abrirNovaJanela1() {
            // Abrir uma nova janela popup com o ID da consulta
            window.open('/consultorio/', '_blank',
                'toolbar=no,scrollbars=yes,resizable=yes,width=1000,height=800');
        }
    </script>
</header>
