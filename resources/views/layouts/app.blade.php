<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>ePRONTUÁRIO</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Select 2    --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css') }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO_01_VERDE.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <style>
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            /* Ajuste a altura conforme necessÃ¡rio */
        }

        .image-container img {
            max-width: 48%;
            /* Garante que a imagem nÃ£o ultrapasse a largura da tela */
            max-height: 100%;
            /* Garante que a imagem nÃ£o ultrapasse a altura da tela */
        }
    </style>

    @stack('css')
</head>
<?php
// Obter a data atual no formato Y-m-d
$currentDate = date('Y-m-d');
?>

<body class="app sidebar-mini">
    @php
        @session_start();
    @endphp

    @include('layouts.header')
    @include('layouts.sidebar')

    @yield('content')

    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('js/main.js') }}"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <!-- JS do Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script type="text/javascript">
        const salesData = {
            xAxis: {
                type: 'category',
                data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    formatter: '${value}'
                }
            },
            series: [{
                data: [150, 230, 224, 218, 135, 147, 260],
                type: 'line',
                smooth: true
            }],
            tooltip: {
                trigger: 'axis',
                formatter: "<b>{b0}:</b> ${c0}"
            }
        }

        const supportRequests = {
            tooltip: {
                trigger: 'item'
            },
            legend: {
                orient: 'vertical',
                left: 'left'
            },
            series: [{
                name: 'Support Requests',
                type: 'pie',
                radius: '50%',
                data: [{
                        value: 300,
                        name: 'In Progress'
                    },
                    {
                        value: 50,
                        name: 'Delayed'
                    },
                    {
                        value: 100,
                        name: 'Complete'
                    }
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }]
        };

        const salesChartElement = document.getElementById('salesChart');
        const salesChart = echarts.init(salesChartElement, null, {
            renderer: 'svg'
        });
        salesChart.setOption(salesData);
        new ResizeObserver(() => salesChart.resize()).observe(salesChartElement);

        const supportChartElement = document.getElementById("supportRequestChart")
        const supportChart = echarts.init(supportChartElement, null, {
            renderer: 'svg'
        });
        supportChart.setOption(supportRequests);
        new ResizeObserver(() => supportChart.resize()).observe(supportChartElement);

        function confirmDeletion(event) {
            if (!confirm('Tem certeza que deseja excluir este item?')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
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
    <!-- Page specific javascripts-->
    <link rel="stylesheet" href="{{ asset('https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css') }}">
    <!-- Data table plugin-->
    <script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>
    <!-- Jquery Others Plugins -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/localization/messages_pt_BR.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     $('#especialidade_id').select2({
        //         placeholder: "Escolha",
        //         allowClear: true
        //     });
        // });
        // $(document).ready(function() {
        //     $('#permisao_id').select2({
        //         placeholder: "Escolha",
        //         allowClear: true
        //     });
        // });
        // $(document).ready(function() {
        //     $('.procedimento_id').select2({
        //         placeholder: "Escolha",
        //         allowClear: true
        //     });
        // });
        //   $(document).ready(function() {
        //       $('.select2').select2({
        //           placeholder: "Selecione",
        //           allowClear: true,
        //           closeOnSelect: true
        //       });
        //   });

        // Fun��o de valida��o de CPF
        function validarCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, ''); // Remove pontos e tra�os
            if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false; // Verifica se todos os d�gitos s�o iguais

            // Valida��o do primeiro d�gito
            var soma = 0;
            for (var i = 0; i < 9; i++) {
                soma += parseInt(cpf.charAt(i)) * (10 - i);
            }
            var resto = 11 - (soma % 11);
            var primeiroDigitoVerificador = resto > 9 ? 0 : resto;
            if (primeiroDigitoVerificador != parseInt(cpf.charAt(9))) return false;

            // Valida��o do segundo d�gito
            soma = 0;
            for (var j = 0; j < 10; j++) {
                soma += parseInt(cpf.charAt(j)) * (11 - j);
            }
            resto = 11 - (soma % 11);
            var segundoDigitoVerificador = resto > 9 ? 0 : resto;
            if (segundoDigitoVerificador != parseInt(cpf.charAt(10))) return false;

            return true;
        }

        // Detecta quando o CPF est� completo e valida
        $('#cpf').on('input', function() {
            var cpf = $(this).val();
            if (cpf.length === 14) { // A m�scara usa 14 caracteres (11 d�gitos + pontos e tra�o)
                if (validarCPF(cpf)) {
                    $('#cpfValidationMessage').hide(); // CPF v�lido
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $('#cpfValidationMessage').show(); // CPF inv�lido
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            }
        });
    </script>
</body>

</html>
