@extends('layouts.admin')

@section('title', 'Veículos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">
            <i class="fas fa-car me-2" style="color: #1e3c72;"></i>
            Todos os Veículos
        </h2>
        <p class="text-muted mt-2">Gerencie todos os veículos da sua frota</p>
    </div>
    <a href="{{ route('admin.veiculos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Novo Veículo
    </a>
</div>

<!-- Cards de Resumo -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="info-card bg-primary">
            <div class="info-icon">
                <i class="fas fa-car"></i>
            </div>
            <div class="info-content">
                <h3>{{ $veiculos->total() }}</h3>
                <span>Total de Veículos</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-card bg-success">
            <div class="info-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="info-content">
                <h3>{{ $veiculos->where('status', 'disponivel')->count() }}</h3>
                <span>Disponíveis</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-card bg-danger">
            <div class="info-icon">
                <i class="fas fa-sold-out"></i>
            </div>
            <div class="info-content">
                <h3>{{ $veiculos->where('status', 'vendido')->count() }}</h3>
                <span>Vendidos</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-card bg-info">
            <div class="info-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="info-content">
                <h3>R$ {{ number_format($veiculos->sum('preco'), 0, ',', '.') }}</h3>
                <span>Valor Total</span>
            </div>
        </div>
    </div>
</div>

<!-- Grid de Cards de Veículos -->
<div class="row">
    @forelse($veiculos as $veiculo)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="vehicle-card">
            <div class="vehicle-image">
                @if($veiculo->imagem_destaque)
                    <img src="{{ Storage::url($veiculo->imagem_destaque) }}" alt="{{ $veiculo->modelo }}">
                @elseif($veiculo->fotos->first())
                    <img src="{{ Storage::url($veiculo->fotos->first()->caminho) }}" alt="{{ $veiculo->modelo }}">
                @else
                    <img src="https://placehold.co/600x400/1e3c72/white?text=Sem+Foto" alt="Sem foto">
                @endif
                
                <div class="vehicle-badge {{ $veiculo->status == 'disponivel' ? 'badge-available' : 'badge-sold' }}">
                    {{ $veiculo->status == 'disponivel' ? 'DISPONÍVEL' : 'VENDIDO' }}
                </div>
                
                <div class="vehicle-actions">
                    <a href="{{ route('admin.veiculos.edit', $veiculo->id) }}" class="action-btn edit-btn" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $veiculo->id }}" title="Excluir">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            
            <div class="vehicle-info">
                <div class="vehicle-header">
                    <h4>{{ $veiculo->modelo }}</h4>
                    <span class="vehicle-type">
                        {!! $veiculo->tipo_veiculo_label !!}
                    </span>
                </div>
                
                <div class="vehicle-details">
                    <div class="detail-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $veiculo->ano }}</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>{{ $veiculo->getKmOuHorasAttribute() }}</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-palette"></i>
                        <span>{{ $veiculo->cor ?? 'Não informada' }}</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-gas-pump"></i>
                        <span>{{ $veiculo->combustivel ?? 'N/I' }}</span>
                    </div>
                </div>
                
                <div class="vehicle-price">
                    <span class="current-price">R$ {{ number_format($veiculo->preco, 2, ',', '.') }}</span>
                    @if($veiculo->preco_antigo)
                        <span class="old-price">R$ {{ number_format($veiculo->preco_antigo, 2, ',', '.') }}</span>
                    @endif
                </div>
                
                <div class="vehicle-footer">
                    <small class="text-muted">
                        <i class="fas fa-trademark"></i> {{ $veiculo->marca->nome ?? 'Sem marca' }}
                    </small>
                    <small class="text-muted">
                        <i class="fas fa-id-card"></i> ID: {{ $veiculo->id }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="deleteModal{{ $veiculo->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir o veículo <strong>{{ $veiculo->modelo }}</strong>?
                    <p class="text-danger mt-2 mb-0"><small>Esta ação não pode ser desfeita!</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('admin.veiculos.destroy', $veiculo->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Sim, excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            <i class="fas fa-car fa-4x mb-3"></i>
            <h4>Nenhum veículo cadastrado</h4>
            <p>Clique no botão "Novo Veículo" para começar</p>
            <a href="{{ route('admin.veiculos.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-1"></i> Cadastrar primeiro veículo
            </a>
        </div>
    </div>
    @endforelse
</div>

<!-- Paginação -->
<div class="d-flex justify-content-center mt-4">
    {{ $veiculos->links() }}
</div>

<style>
    /* Cards de Informação */
    .info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 20px;
        color: white;
        display: flex;
        align-items: center;
        transition: transform 0.3s;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .info-card:hover {
        transform: translateY(-5px);
    }
    
    .info-card.bg-primary {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    }
    
    .info-card.bg-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    
    .info-card.bg-danger {
        background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
    }
    
    .info-card.bg-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    
    .info-icon i {
        font-size: 24px;
    }
    
    .info-content h3 {
        font-size: 28px;
        margin: 0;
        font-weight: bold;
    }
    
    .info-content span {
        font-size: 12px;
        opacity: 0.9;
    }
    
    /* Cards de Veículos */
    .vehicle-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .vehicle-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .vehicle-image {
        position: relative;
        overflow: hidden;
        height: 220px;
        background: #f5f5f5;
    }
    
    .vehicle-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    
    .vehicle-card:hover .vehicle-image img {
        transform: scale(1.1);
    }
    
    .vehicle-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 1;
    }
    
    .badge-available {
        background: #28a745;
        color: white;
    }
    
    .badge-sold {
        background: #dc3545;
        color: white;
    }
    
    .vehicle-actions {
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 10px;
        padding: 10px;
        background: rgba(0,0,0,0.8);
        transition: bottom 0.3s;
    }
    
    .vehicle-card:hover .vehicle-actions {
        bottom: 0;
    }
    
    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .edit-btn {
        background: #ffc107;
        color: #000;
    }
    
    .edit-btn:hover {
        background: #ff9800;
        transform: scale(1.1);
    }
    
    .delete-btn {
        background: #dc3545;
        color: white;
    }
    
    .delete-btn:hover {
        background: #c82333;
        transform: scale(1.1);
    }
    
    .vehicle-info {
        padding: 20px;
    }
    
    .vehicle-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .vehicle-header h4 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
        color: #1e3c72;
    }
    
    .vehicle-type {
        font-size: 20px;
    }
    
    .vehicle-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #666;
    }
    
    .detail-item i {
        width: 16px;
        color: #1e3c72;
    }
    
    .vehicle-price {
        margin-bottom: 15px;
    }
    
    .current-price {
        font-size: 22px;
        font-weight: bold;
        color: #28a745;
        display: block;
    }
    
    .old-price {
        font-size: 14px;
        color: #999;
        text-decoration: line-through;
        margin-left: 10px;
    }
    
    .vehicle-footer {
        display: flex;
        justify-content: space-between;
        padding-top: 10px;
        border-top: 1px solid #eee;
        font-size: 12px;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 15px;
        color: #999;
    }
    
    .empty-state i {
        color: #ddd;
    }
    
    /* Paginação */
    .pagination {
        margin-top: 20px;
    }
</style>
@endsection