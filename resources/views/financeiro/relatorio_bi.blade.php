@extends('layouts.app')

@section('content')
    <main class="app-content">
        <div class="app-title d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-table"></i> Relatórios </h1>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-warning">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <!-- Cards Estatísticos -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2" style="border-left: .25rem solid #cc3c3e">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#cc3c3e">
                                    Agendamentos Totais</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $formattedData['stats']['totalAgendamentos'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cancelados -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Cancelados</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $formattedData['stats']['totalCancelados'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Médicos -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Médicos</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $formattedData['stats']['totalMedicos'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-md fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pacientes -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pacientes</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $formattedData['stats']['totalPacientes'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-injured fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="col-md-12">
                <div class="tile">
                    <h5 class="tile-title">Análise de Dados</h5>
                    <div class="row">
                        <!-- Gráfico de Agendamentos -->
                        <div class="col-md-6">
                            <canvas id="agendamentosChart"></canvas>
                        </div>

                        <!-- Gráfico de Status -->
                        <div class="col-md-6">
                            <canvas id="pacientesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<!-- Inclua o Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de Agendamentos por Mês
    @if(!empty($formattedData['agendamentos']))
    new Chart(document.getElementById('agendamentosChart'), {
        type: 'bar',
        data: {
            labels: @json($formattedData['labels']), // Agora os meses estão ordenados corretamente
            datasets: [{
                label: 'Agendamentos por Mês',
                data: @json($formattedData['agendamentos']),
                backgroundColor: '#4CAF50',
                borderColor: '#388E3C',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: {
                        autoSkip: false, // Mantém todos os meses visíveis
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0 // Evita valores decimais
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.raw} agendamentos`;
                        }
                    }
                }
            }
        }
    });
    @endif



        // Gráfico de Status de Pacientes
        @if(!empty($formattedData['status']['values']))
        new Chart(document.getElementById('pacientesChart'), {
            type: 'pie',
            data: {
                labels: @json($formattedData['status']['labels']),
                datasets: [{
                    label: 'Distribuição de Pacientes por Status',
                    data: @json($formattedData['status']['values']),
                    backgroundColor: @json($formattedData['status']['colors']),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percent = Math.round((context.raw / total) * 100);
                                return `${context.label}: ${context.raw} (${percent}%)`;
                            }
                        }
                    }
                }
            }
        });
        @endif

    });
    </script>
@endsection
