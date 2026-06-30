@extends('layouts.admin')

@section('title', 'Observações Internas')

@section('content')
@php
    $veiculosComObs = $veiculos->filter(function($v) {
        return !empty($v->obs_admin);
    });
@endphp

<div class="page-header mb-4">
    <div>
        <h2>
            <i class="fas fa-lock me-2"></i>
            Observações Internas
        </h2>
        <p>Anotações privadas da equipe sobre veículos, negociação e histórico.</p>
    </div>

    <a href="{{ route('admin.veiculos.index') }}" class="btn-back">
        <i class="fas fa-arrow-left me-1"></i> Voltar
    </a>
</div>

<div class="summary-card mb-4">
    <div>
        <strong>{{ $veiculosComObs->count() }}</strong>
        <span>veículo(s) com observação interna</span>
    </div>

    <div class="summary-icon">
        <i class="fas fa-clipboard-list"></i>
    </div>
</div>

<div class="filter-card mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-8">
            <label class="form-label">Buscar veículo</label>
            <input type="text" id="searchInput" class="form-control" placeholder="Digite modelo, marca ou ano...">
        </div>

        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select id="statusFilter" class="form-select">
                <option value="">Todos os status</option>
                <option value="disponivel">Disponíveis</option>
                <option value="vendido">Vendidos</option>
            </select>
        </div>
    </div>
</div>

<div id="observacoesList">
    @forelse($veiculosComObs as $veiculo)
        <div class="obs-card"
             data-status="{{ $veiculo->status }}"
             data-search="{{ strtolower(($veiculo->modelo ?? '') . ' ' . ($veiculo->marca->nome ?? '') . ' ' . ($veiculo->ano ?? '')) }}">

            <div class="obs-main">
                <div class="obs-icon">
                    <i class="fas fa-car"></i>
                </div>

                <div class="obs-content-wrap">
                    <div class="obs-top">
                        <div>
                            <h4>{{ $veiculo->modelo }}</h4>
                            <p>
                                {{ $veiculo->marca->nome ?? 'Sem marca' }}
                                • {{ $veiculo->ano }}
                                • R$ {{ number_format($veiculo->preco, 2, ',', '.') }}
                            </p>
                        </div>

                        <div class="obs-actions">
                            <span class="status-badge {{ $veiculo->status == 'disponivel' ? 'available' : 'sold' }}">
                                {{ $veiculo->status == 'disponivel' ? 'Disponível' : 'Vendido' }}
                            </span>

                            <a href="{{ route('admin.veiculos.edit', $veiculo->id) }}" class="btn-edit">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                        </div>
                    </div>

                    <div class="obs-text">
                        <i class="fas fa-quote-left"></i>
                        <span>{{ $veiculo->obs_admin }}</span>
                    </div>

                    <div class="obs-meta">
                        <span>
                            <i class="fas fa-calendar-plus me-1"></i>
                            Cadastrado: {{ $veiculo->created_at->format('d/m/Y H:i') }}
                        </span>

                        <span>
                            <i class="fas fa-clock me-1"></i>
                            Atualizado: {{ $veiculo->updated_at->format('d/m/Y H:i') }}
                        </span>

                        
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-lock"></i>
            <h4>Nenhuma observação interna cadastrada</h4>
            <p>Adicione observações ao editar um veículo no campo “Observações Internas”.</p>
            <a href="{{ route('admin.veiculos.index') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                <i class="fas fa-car me-1"></i> Ver veículos
            </a>
        </div>
    @endforelse
</div>

<div id="noResults" class="empty-state d-none">
    <i class="fas fa-search"></i>
    <h4>Nenhum resultado encontrado</h4>
    <p>Tente mudar os filtros da busca.</p>
</div>

<style>
    body {
        background: #f5f7fb;
    }

    .page-header {
        background: linear-gradient(135deg, #111827, #1e3c72);
        color: white;
        border-radius: 24px;
        padding: 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        box-shadow: 0 15px 35px rgba(17,24,39,.18);
    }

    .page-header h2 {
        margin: 0;
        font-weight: 900;
    }

    .page-header p {
        color: rgba(255,255,255,.75);
        margin: 6px 0 0;
    }

    .btn-back {
        background: white;
        color: #1e3c72;
        border-radius: 15px;
        padding: 12px 18px;
        text-decoration: none;
        font-weight: 900;
        transition: .2s;
    }

    .btn-back:hover {
        color: #1e3c72;
        transform: translateY(-2px);
    }

    .summary-card,
    .filter-card,
    .obs-card,
    .empty-state {
        background: white;
        border-radius: 22px;
        border: 1px solid #eef0f5;
        box-shadow: 0 8px 25px rgba(0,0,0,.05);
    }

    .summary-card {
        padding: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .summary-card strong {
        display: block;
        font-size: 34px;
        font-weight: 950;
        color: #111827;
        line-height: 1;
    }

    .summary-card span {
        color: #6b7280;
        font-weight: 700;
    }

    .summary-icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        background: linear-gradient(135deg, #f59e0b, #f97316);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .filter-card {
        padding: 22px;
    }

    .form-label {
        font-weight: 900;
        color: #111827;
        font-size: 14px;
    }

    .form-control,
    .form-select {
        border-radius: 14px;
        border: 1px solid #dce3ee;
        padding: 12px 14px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #1e3c72;
        box-shadow: 0 0 0 4px rgba(30,60,114,.12);
    }

    .obs-card {
        padding: 20px;
        margin-bottom: 16px;
        border-left: 5px solid #f59e0b;
        transition: .2s;
    }

    .obs-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 35px rgba(0,0,0,.08);
    }

    .obs-main {
        display: flex;
        gap: 16px;
    }

    .obs-icon {
        width: 52px;
        height: 52px;
        border-radius: 17px;
        background: #fff7ed;
        color: #f97316;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .obs-content-wrap {
        flex: 1;
        min-width: 0;
    }

    .obs-top {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .obs-top h4 {
        margin: 0;
        color: #111827;
        font-weight: 950;
        font-size: 20px;
    }

    .obs-top p {
        margin: 4px 0 0;
        color: #6b7280;
        font-weight: 700;
        font-size: 14px;
    }

    .obs-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .status-badge {
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
    }

    .status-badge.available {
        background: #dcfce7;
        color: #166534;
    }

    .status-badge.sold {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-edit {
        background: #1e3c72;
        color: white;
        border-radius: 999px;
        padding: 7px 13px;
        text-decoration: none;
        font-weight: 900;
        font-size: 13px;
    }

    .btn-edit:hover {
        background: #2563eb;
        color: white;
    }

    .obs-text {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 18px;
        padding: 16px;
        color: #475569;
        line-height: 1.7;
        display: flex;
        gap: 10px;
        white-space: pre-line;
    }

    .obs-text i {
        color: #94a3b8;
        margin-top: 4px;
    }

    .obs-meta {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        margin-top: 14px;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 58px;
        color: #cbd5e1;
        margin-bottom: 14px;
    }

    .empty-state h4 {
        color: #111827;
        font-weight: 950;
    }

    @media (max-width: 768px) {
        .page-header,
        .summary-card,
        .filter-card,
        .obs-card {
            padding: 20px;
        }

        .obs-main {
            flex-direction: column;
        }

        .obs-actions {
            width: 100%;
        }
    }
</style>

<script>
const searchInput = document.getElementById('searchInput');
const statusFilter = document.getElementById('statusFilter');
const cards = document.querySelectorAll('.obs-card');
const noResults = document.getElementById('noResults');

function filterCards() {
    const searchTerm = searchInput.value.toLowerCase().trim();
    const statusValue = statusFilter.value;
    let visibleCount = 0;

    cards.forEach(card => {
        const search = card.dataset.search || '';
        const status = card.dataset.status || '';

        const matchesSearch = search.includes(searchTerm);
        const matchesStatus = !statusValue || status === statusValue;

        if (matchesSearch && matchesStatus) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    if (noResults) {
        noResults.classList.toggle('d-none', visibleCount !== 0 || cards.length === 0);
    }
}

searchInput?.addEventListener('keyup', filterCards);
statusFilter?.addEventListener('change', filterCards);
</script>
@endsection