@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<style>
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.03);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }
    
    .stat-info h3 {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 5px 0;
    }
    
    .stat-info p {
        margin: 0;
        color: #6c757d;
        font-size: 14px;
    }
    
    .chart-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .chart-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #1e3c72;
        border-left: 4px solid #1e3c72;
        padding-left: 12px;
    }
    
    .recent-table {
        width: 100%;
    }
    
    .recent-table tr {
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s;
    }
    
    .recent-table tr:hover {
        background: #f8f9fa;
    }
    
    .recent-table td {
        padding: 12px 5px;
        vertical-align: middle;
    }
    
    .vehicle-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .badge-available {
        background: #d4edda;
        color: #155724;
    }
    
    .badge-sold {
        background: #f8d7da;
        color: #721c24;
    }
    
    .top-marca-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .top-marca-item:last-child {
        border-bottom: none;
    }
    
    .marca-nome {
        font-weight: 600;
        color: #333;
    }
    
    .marca-count {
        background: #1e3c72;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
    }
</style>

<div class="dashboard-container">
    <!-- Título -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-chart-line me-2" style="color: #1e3c72;"></i>
                Dashboard
            </h2>
            <p class="text-muted mb-0">Bem-vindo de volta, {{ Auth::user()->name ?? 'Admin' }}!</p>
        </div>
        <div>
            <span class="badge bg-primary px-3 py-2">
                <i class="fas fa-calendar-alt me-1"></i>
                {{ now()->format('d/m/Y') }}
            </span>
        </div>
    </div>
    
    <!-- Cards Estatísticos -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div class="stat-info">
                    <h3>{{ $totalVeiculos ?? 0 }}</h3>
                    <p>Total de Veículos</p>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
                    <i class="fas fa-car"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div class="stat-info">
                    <h3>{{ $disponiveis ?? 0 }}</h3>
                    <p>Disponíveis</p>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #28a745, #20c997);">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div class="stat-info">
                    <h3>{{ $vendidos ?? 0 }}</h3>
                    <p>Vendidos</p>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #dc3545, #fd7e14);">
                    <i class="fas fa-sold-out"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card d-flex align-items-center justify-content-between">
                <div class="stat-info">
                    <h3>{{ $totalMarcas ?? 0 }}</h3>
                    <p>Marcas</p>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #6f42c1, #8b5cf6);">
                    <i class="fas fa-trademark"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Único Gráfico: Status dos Veículos (Pizza) -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="chart-card">
                <div class="chart-title">
                    <i class="fas fa-chart-pie me-2"></i> Status dos Veículos
                </div>
                <canvas id="statusChart" height="280"></canvas>
                <div class="mt-3 text-center">
                    <span class="badge bg-success me-3 px-3 py-2">
                        <i class="fas fa-circle me-1"></i> Disponível: {{ $disponiveis ?? 0 }}
                    </span>
                    <span class="badge bg-danger px-3 py-2">
                        <i class="fas fa-circle me-1"></i> Vendido: {{ $vendidos ?? 0 }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Top Marcas -->
        <div class="col-md-6">
            <div class="chart-card">
                <div class="chart-title">
                    <i class="fas fa-trophy me-2"></i> Top Marcas
                </div>
                <div class="top-marcas-list">
                    @forelse($topMarcas ?? [] as $marca)
                    <div class="top-marca-item">
                        <span class="marca-nome">
                            <i class="fas fa-trademark me-2 text-primary"></i>
                            {{ $marca->nome }}
                        </span>
                        <span class="marca-count">{{ $marca->veiculos_count }} veículo(s)</span>
                    </div>
                    @empty
                    <p class="text-muted text-center py-3">Nenhuma marca cadastrada</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <!-- Últimos Veículos -->
    <div class="chart-card">
        <div class="chart-title mb-3">
            <i class="fas fa-clock me-2"></i> Últimos Veículos Cadastrados
        </div>
        <div class="table-responsive">
            <table class="recent-table w-100">
                <thead>
                    <tr style="border-bottom: 2px solid #e9ecef;">
                        <th>ID</th>
                        <th>Veículo</th>
                        <th>Ano</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimosVeiculos ?? [] as $veiculo)
                    <tr>
                        <td class="fw-bold">#{{ $veiculo->id }}</td>
                        <td>
                            <strong>{{ $veiculo->modelo }}</strong><br>
                            <small class="text-muted">{{ $veiculo->marca->nome ?? 'Sem marca' }}</small>
                        </td>
                        <td>{{ $veiculo->ano }}</td>
                        <td class="fw-bold text-success">R$ {{ number_format($veiculo->preco, 2, ',', '.') }}</td>
                        <td>
                            <span class="vehicle-badge {{ $veiculo->status == 'disponivel' ? 'badge-available' : 'badge-sold' }}">
                                {{ $veiculo->status == 'disponivel' ? 'Disponível' : 'Vendido' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.veiculos.edit', $veiculo->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            Nenhum veículo cadastrado ainda
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de Status (Pizza)
        const ctx = document.getElementById('statusChart')?.getContext('2d');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Disponíveis', 'Vendidos'],
                    datasets: [{
                        data: [{{ $disponiveis ?? 0 }}, {{ $vendidos ?? 0 }}],
                        backgroundColor: ['#28a745', '#dc3545'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { size: 14, weight: 'bold' },
                                padding: 20
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percent = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${value} (${percent}%)`;
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        }
    });
</script>
@endsection