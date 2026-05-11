@extends('layouts.admin')

@section('title', 'Observações Internas')

@section('content')
<style>
    .obs-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border-left: 4px solid #ffc107;
    }
    
    .obs-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .obs-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .obs-vehicle {
        font-size: 18px;
        font-weight: 700;
        color: #1e3c72;
    }
    
    .obs-vehicle small {
        font-size: 13px;
        color: #6c757d;
        font-weight: normal;
    }
    
    .obs-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .obs-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin: 15px 0;
        font-style: italic;
        color: #495057;
        line-height: 1.5;
    }
    
    .obs-meta {
        display: flex;
        gap: 20px;
        font-size: 12px;
        color: #6c757d;
        flex-wrap: wrap;
    }
    
    .empty-obs {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 15px;
    }
    
    .empty-obs i {
        font-size: 60px;
        color: #ddd;
        margin-bottom: 20px;
    }
    
    .filter-bar {
        background: white;
        padding: 15px 20px;
        border-radius: 15px;
        margin-bottom: 25px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .filter-bar input {
        flex: 1;
        min-width: 200px;
        padding: 10px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
    }
    
    .filter-bar select {
        padding: 10px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        background: white;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-lock me-2" style="color: #ffc107;"></i>
            Observações Internas
        </h2>
        <p class="text-muted mb-0">Anotações internas da equipe sobre os veículos</p>
    </div>
    <a href="{{ route('admin.veiculos.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Voltar
    </a>
</div>

<!-- Filtros -->
<div class="filter-bar">
    <input type="text" id="searchInput" placeholder="🔍 Buscar veículo..." class="form-control">
    <select id="statusFilter" class="form-select" style="width: auto;">
        <option value="">Todos os status</option>
        <option value="disponivel">Disponíveis</option>
        <option value="vendido">Vendidos</option>
    </select>
</div>

<div id="observacoesList">
    @php
        $veiculosComObs = $veiculos->filter(function($v) {
            return !empty($v->obs_admin);
        });
    @endphp
    
    @forelse($veiculosComObs as $veiculo)
    <div class="obs-card" data-status="{{ $veiculo->status }}" data-modelo="{{ strtolower($veiculo->modelo) }}">
        <div class="obs-header">
            <div class="obs-vehicle">
                <i class="fas fa-car me-2 text-primary"></i>
                {{ $veiculo->modelo }}
                <small>({{ $veiculo->marca->nome ?? 'Sem marca' }} - {{ $veiculo->ano }})</small>
            </div>
            <div>
                <span class="obs-badge bg-{{ $veiculo->status == 'disponivel' ? 'success' : 'danger' }} text-white">
                    {{ $veiculo->status == 'disponivel' ? 'Disponível' : 'Vendido' }}
                </span>
                <a href="{{ route('admin.veiculos.edit', $veiculo->id) }}" class="btn btn-sm btn-outline-primary ms-2">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>
        
        <div class="obs-content">
            <i class="fas fa-quote-left me-2 text-muted"></i>
            {{ $veiculo->obs_admin }}
        </div>
        
        <div class="obs-meta">
            <span>
                <i class="fas fa-tag me-1"></i>
                Preço: R$ {{ number_format($veiculo->preco, 2, ',', '.') }}
            </span>
            <span>
                <i class="fas fa-calendar me-1"></i>
                Cadastrado: {{ $veiculo->created_at->format('d/m/Y H:i') }}
            </span>
            <span>
                <i class="fas fa-edit me-1"></i>
                Última atualização: {{ $veiculo->updated_at->format('d/m/Y H:i') }}
            </span>
        </div>
    </div>
    @empty
    <div class="empty-obs">
        <i class="fas fa-lock"></i>
        <h4>Nenhuma observação interna cadastrada</h4>
        <p class="text-muted">Adicione observações ao editar um veículo no campo "Observações Internas"</p>
        <a href="{{ route('admin.veiculos.index') }}" class="btn btn-primary mt-3">
            <i class="fas fa-car me-1"></i> Ver veículos
        </a>
    </div>
    @endforelse
</div>

<script>
    // Filtro de busca
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const cards = document.querySelectorAll('.obs-card');
    
    function filterCards() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        
        cards.forEach(card => {
            const modelo = card.dataset.modelo || '';
            const status = card.dataset.status || '';
            
            const matchesSearch = modelo.includes(searchTerm);
            const matchesStatus = !statusValue || status === statusValue;
            
            if (matchesSearch && matchesStatus) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    searchInput.addEventListener('keyup', filterCards);
    statusFilter.addEventListener('change', filterCards);
</script>
@endsection