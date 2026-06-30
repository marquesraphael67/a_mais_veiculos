@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    $veiculosNaVitrine = $veiculosNaVitrine ?? 0;
    $veiculosOcultos = $veiculosOcultos ?? 0;
@endphp

<style>
    body { background: #f5f7fb; }

    .dash-hero {
        background: linear-gradient(135deg, #111827, #1e3c72);
        color: white;
        border-radius: 24px;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 15px 35px rgba(17, 24, 39, .18);
    }

    .dash-hero h2 {
        font-weight: 950;
        margin: 0;
    }

    .dash-hero p {
        color: rgba(255,255,255,.75);
        margin: 6px 0 0;
    }

    .quick-btn {
        border: 1px solid rgba(255,255,255,.25);
        background: rgba(255,255,255,.12);
        color: white;
        border-radius: 14px;
        padding: 11px 15px;
        text-decoration: none;
        font-weight: 900;
        transition: .2s;
    }

    .quick-btn:hover {
        background: white;
        color: #1e3c72;
    }

    .stat-card,
    .panel-card {
        background: white;
        border-radius: 22px;
        border: 1px solid #eef0f5;
        box-shadow: 0 8px 25px rgba(0,0,0,.05);
    }

    .stat-card {
        padding: 22px;
        height: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: .25s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 35px rgba(0,0,0,.08);
    }

    .stat-number {
        font-size: 32px;
        font-weight: 950;
        margin: 0;
        color: #111827;
    }

    .stat-label {
        color: #6b7280;
        margin: 0;
        font-size: 14px;
        font-weight: 800;
    }

    .stat-icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
    }

    .panel-card {
        padding: 24px;
        height: 100%;
    }

    .panel-title {
        font-weight: 950;
        color: #111827;
        font-size: 18px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .action-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px;
        border-radius: 18px;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        text-decoration: none;
        color: #111827;
        transition: .2s;
        margin-bottom: 12px;
    }

    .action-card:hover {
        background: #eef4ff;
        color: #1e3c72;
        transform: translateX(4px);
    }

    .action-icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: #1e3c72;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .alert-item {
        padding: 15px;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        border-radius: 18px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: center;
    }

    .alert-item strong {
        color: #111827;
    }

    .alert-badge {
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        white-space: nowrap;
    }

    .badge-green { background: #dcfce7; color: #166534; }
    .badge-gray { background: #e5e7eb; color: #374151; }
    .badge-red { background: #fee2e2; color: #991b1b; }
    .badge-blue { background: #dbeafe; color: #1e40af; }

    .vehicle-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .vehicle-table thead th {
        color: #6b7280;
        font-size: 13px;
        font-weight: 900;
        padding: 0 14px 8px;
    }

    .vehicle-table tbody tr {
        background: #f9fafb;
    }

    .vehicle-table tbody td {
        padding: 14px;
        vertical-align: middle;
    }

    .vehicle-table tbody td:first-child { border-radius: 16px 0 0 16px; }
    .vehicle-table tbody td:last-child { border-radius: 0 16px 16px 0; }

    .status-badge {
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
    }

    .status-disponivel { background: #dcfce7; color: #166534; }
    .status-vendido { background: #fee2e2; color: #991b1b; }

    .empty-box {
        text-align: center;
        padding: 35px;
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .dash-hero { padding: 22px; }
        .vehicle-table { min-width: 760px; }
    }
</style>

<div class="dash-hero">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2><i class="fas fa-gauge-high me-2"></i> Dashboard</h2>
            <p>Resumo rápido da vitrine, estoque e veículos cadastrados.</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.veiculos.create') }}" class="quick-btn">
                <i class="fas fa-plus me-1"></i> Novo veículo
            </a>

            <a href="{{ route('admin.veiculos.index') }}" class="quick-btn">
                <i class="fas fa-car me-1"></i> Gerenciar veículos
            </a>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <h3 class="stat-number">{{ $totalVeiculos ?? 0 }}</h3>
                <p class="stat-label">Total de veículos</p>
            </div>
            <div class="stat-icon" style="background: linear-gradient(135deg, #1e3c72, #2563eb);">
                <i class="fas fa-car"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <h3 class="stat-number">{{ $veiculosNaVitrine }}</h3>
                <p class="stat-label">Na vitrine</p>
            </div>
            <div class="stat-icon" style="background: linear-gradient(135deg, #16a34a, #22c55e);">
                <i class="fas fa-eye"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <h3 class="stat-number">{{ $veiculosOcultos }}</h3>
                <p class="stat-label">Ocultos</p>
            </div>
            <div class="stat-icon" style="background: linear-gradient(135deg, #64748b, #94a3b8);">
                <i class="fas fa-eye-slash"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <h3 class="stat-number">{{ $vendidos ?? 0 }}</h3>
                <p class="stat-label">Vendidos</p>
            </div>
            <div class="stat-icon" style="background: linear-gradient(135deg, #dc2626, #f97316);">
                <i class="fas fa-handshake"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="panel-card">
            <div class="panel-title">
                <i class="fas fa-bolt text-warning"></i>
                Ações rápidas
            </div>

            <a href="{{ route('admin.veiculos.create') }}" class="action-card">
                <div class="action-icon"><i class="fas fa-plus"></i></div>
                <div>
                    <strong>Cadastrar veículo</strong>
                    <div class="text-muted small">Adicionar novo veículo ao estoque.</div>
                </div>
            </a>

            <a href="{{ route('admin.veiculos.index') }}" class="action-card">
                <div class="action-icon"><i class="fas fa-list"></i></div>
                <div>
                    <strong>Gerenciar vitrine</strong>
                    <div class="text-muted small">Ativar ou ocultar veículos do site.</div>
                </div>
            </a>

            <a href="{{ route('admin.marcas.index') }}" class="action-card">
                <div class="action-icon"><i class="fas fa-tags"></i></div>
                <div>
                    <strong>Gerenciar marcas</strong>
                    <div class="text-muted small">Organizar marcas cadastradas.</div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="panel-card">
            <div class="panel-title">
                <i class="fas fa-circle-info text-primary"></i>
                Situação do estoque
            </div>

            <div class="alert-item">
                <div>
                    <strong>Veículos disponíveis</strong>
                    <div class="text-muted small">Podem ser anunciados na vitrine.</div>
                </div>
                <span class="alert-badge badge-green">{{ $disponiveis ?? 0 }}</span>
            </div>

            <div class="alert-item">
                <div>
                    <strong>Veículos ocultos</strong>
                    <div class="text-muted small">Estão no painel, mas não aparecem para clientes.</div>
                </div>
                <span class="alert-badge badge-gray">{{ $veiculosOcultos }}</span>
            </div>

            <div class="alert-item">
                <div>
                    <strong>Valor total listado</strong>
                    <div class="text-muted small">Soma dos veículos cadastrados.</div>
                </div>
                <span class="alert-badge badge-blue">
                    R$ {{ number_format($valorTotalEstoque ?? 0, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="panel-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div class="panel-title mb-0">
            <i class="fas fa-clock text-primary"></i>
            Últimos veículos cadastrados
        </div>

        <a href="{{ route('admin.veiculos.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">
            Ver todos
        </a>
    </div>

    <div class="table-responsive">
        <table class="vehicle-table">
            <thead>
                <tr>
                    <th>Veículo</th>
                    <th>Ano</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Vitrine</th>
                    <th class="text-end">Ação</th>
                </tr>
            </thead>

            <tbody>
                @forelse($ultimosVeiculos ?? [] as $veiculo)
                    <tr>
                        <td>
                            <strong>{{ $veiculo->modelo }}</strong>
                            <div class="text-muted small">{{ $veiculo->marca->nome ?? 'Sem marca' }}</div>
                        </td>

                        <td>{{ $veiculo->ano }}</td>

                        <td class="fw-bold text-success">
                            R$ {{ number_format($veiculo->preco, 2, ',', '.') }}
                        </td>

                        <td>
                            <span class="status-badge {{ $veiculo->status == 'disponivel' ? 'status-disponivel' : 'status-vendido' }}">
                                {{ $veiculo->status == 'disponivel' ? 'Disponível' : 'Vendido' }}
                            </span>
                        </td>

                        <td>
                            @if($veiculo->ativo)
                                <span class="alert-badge badge-green">
                                    <i class="fas fa-eye me-1"></i> Na vitrine
                                </span>
                            @else
                                <span class="alert-badge badge-gray">
                                    <i class="fas fa-eye-slash me-1"></i> Oculto
                                </span>
                            @endif
                        </td>

                        <td class="text-end">
                            <a href="{{ route('admin.veiculos.edit', $veiculo->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-box">
                                <i class="fas fa-car fa-2x mb-2"></i>
                                <p class="mb-0">Nenhum veículo cadastrado ainda.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection