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
        <ul class="app-menu" style="text-align: center">
            @foreach ($painelTudo as $item)
                <li><a class="app-menu__item"><span class="app-menu__label">{{$item->paciente->name}} {{$item->paciente->sobrenome}}</span></a></li>
            @endforeach
        </ul>
    </aside>
    <main class="app-content d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col-md-12"> <!-- Defina o tamanho do tile-body -->
                <div class="tile">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2">
                                <img src="logo.png" alt="Logo" style="height: 50px;">
                                Secretaria de Saúde
                            </td>
                            <td colspan="3" style="text-align: center;">SOLICITAÇÃO DE EXAME OU PROCEDIMENTO</td>
                        </tr>
                        <tr>
                            <td colspan="2">NOME DO PACIENTE: <input type="text" name="nome_paciente"></td>
                            <td colspan="3">DOC. IDENTIDADE: <input type="text" name="doc_identidade"></td>
                        </tr>
                        <tr>
                            <td colspan="5">ENDEREÇO: <input type="text" name="endereco"></td>
                        </tr>
                        <tr>
                            <td colspan="5">MOTIVO DA SOLICITAÇÃO: <input type="text" name="motivo_solicitacao"></td>
                        </tr>
                        <tr>
                            <td colspan="3">EXAME OU PROCEDIMENTO SOLICITADO: <input type="text" name="procedimento_solicitado"></td>
                            <td colspan="2">CÓDIGO: <input type="text" name="codigo"></td>
                        </tr>
                        <tr>
                            <td colspan="3">PROFISSIONAL SOLICITANTE: <input type="text" name="profissional_solicitante"></td>
                            <td colspan="2">AUTORIZAÇÃO: <input type="text" name="autorizacao"></td>
                        </tr>
                        <tr>
                            <td>DATA: <input type="date" name="data_solicitacao"></td>
                            <td colspan="2"></td>
                            <td>PACIENTE: <input type="text" name="paciente"></td>
                            <td>DATA: <input type="date" name="data_paciente"></td>
                        </tr>
                    </table>
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
    </script>
</body>

</html>
