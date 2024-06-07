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
    <link rel="stylesheet" type="text/css"
        href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css') }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO_01_VERDE.png') }}">
</head>

<body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo">Vali</a>

    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user-name" style="text-align: center; ">
            <h4 style="color: white">Pacientes</h4>
        </div>
        <ul class="app-menu" style="text-align: center">
            <h1></h1>
            @foreach ($painelTudo as $item)
            <li>
                <a class="app-menu__item">
                    <span class="app-menu__label">{{$item->paciente->name}} {{$item->paciente->sobrenome}}<br>{{$item->created_at}}</span>
                </a>    
            </li>
            @endforeach
        </ul>
    </aside>
    <main class="app-content d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col-md-12"> <!-- Defina o tamanho do tile-body -->
                <div class="tile">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card" style="font-size: 2rem; padding: 2rem; border: 2px solid #000;">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 3rem;">Nome do Paciente</h5>
                                    <p class="card-text" style="font-size: 2.5rem;">
                                        {{ $painelUnico->paciente->name ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card" style="font-size: 2rem; padding: 2rem; border: 2px solid #000;">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 3rem;">
                                        @if ($painelUnico->permisao_id == 1)
                                            Guichê
                                        @elseif ($painelUnico->permisao_id == 2)
                                            Consultório
                                        @endif
                                    </h5>
                                    <p class="card-text" style="font-size: 2.5rem;">
                                        {{ $painelUnico->sala_id ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- Page specific javascripts-->
    <!-- Google analytics script-->
    <script type="text/javascript">
        if (document.location.hostname == 'pratikborsadiya.in') {
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-72504830-1', 'auto');
            ga('send', 'pageview');
        }
    // Função para recarregar a página
    function recarregarPagina() {
        location.reload();
    }

    // Configura a recarga da página a cada 2 segundos (2000 milissegundos)
    setInterval(recarregarPagina, 2000);

    </script>
</body>

</html>
