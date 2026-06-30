@extends('layouts.admin')

@section('title', 'Veículos')

@section('content')
<div class="page-header mb-4">
    <div>
        <h2><i class="fas fa-car me-2"></i> Veículos</h2>
        <p>Gerencie o estoque de veículos da loja.</p>
    </div>

    <a href="{{ route('admin.veiculos.create') }}" class="btn-add">
        <i class="fas fa-plus me-1"></i> Novo veículo
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <h3>{{ $veiculos->total() }}</h3>
                <p>Total de veículos</p>
            </div>
            <span class="stat-icon blue"><i class="fas fa-car"></i></span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <h3>{{ $veiculos->where('status', 'disponivel')->count() }}</h3>
                <p>Disponíveis</p>
            </div>
            <span class="stat-icon green"><i class="fas fa-check"></i></span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <h3>{{ $veiculos->where('status', 'vendido')->count() }}</h3>
                <p>Vendidos</p>
            </div>
            <span class="stat-icon red"><i class="fas fa-handshake"></i></span>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div>
                <h3>R$ {{ number_format($veiculos->sum('preco'), 0, ',', '.') }}</h3>
                <p>Valor listado</p>
            </div>
            <span class="stat-icon purple"><i class="fas fa-dollar-sign"></i></span>
        </div>
    </div>
</div>

<div class="toolbar-card mb-4">
    <div>
        <strong>Lista de veículos</strong>
        <p class="mb-0 text-muted">Visualize, edite ou remova veículos cadastrados.</p>
    </div>

    <a href="{{ route('admin.veiculos.create') }}" class="btn btn-primary rounded-pill px-4">
        Cadastrar
    </a>
</div>

<div class="row g-4">
    @forelse($veiculos as $veiculo)
        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="vehicle-card">
                <div class="vehicle-image">
                    @if($veiculo->imagem_destaque)
                        <img src="{{ asset('storage/' . $veiculo->imagem_destaque) }}" alt="{{ $veiculo->modelo }}">
                    @elseif($veiculo->fotos->first())
                        <img src="{{ asset('storage/' . ($veiculo->fotos->first()->foto_path ?? $veiculo->fotos->first()->caminho)) }}" alt="{{ $veiculo->modelo }}">
                    @else
                        <div class="no-image">
                            <i class="fas fa-car"></i>
                            <span>Sem foto</span>
                        </div>
                    @endif

                    <span class="status-badge {{ $veiculo->status == 'disponivel' ? 'available' : 'sold' }}">
                        {{ $veiculo->status == 'disponivel' ? 'Disponível' : 'Vendido' }}
                    </span>
                </div>

                <div class="vehicle-body">
                    <div class="brand-row">
                        <span>{{ $veiculo->marca->nome ?? 'Sem marca' }}</span>
                        <small>{{ ucfirst($veiculo->tipo_veiculo ?? 'veículo') }}</small>
                    </div>

                    <h4>{{ $veiculo->modelo }}</h4>

                    <div class="spec-grid">
                        <div>
                            <i class="fas fa-calendar"></i>
                            <strong>{{ $veiculo->ano }}</strong>
                            <small>Ano</small>
                        </div>

                        <div>
                            @if(in_array($veiculo->tipo_veiculo, ['jetski', 'lancha']))
                                <i class="fas fa-clock"></i>
                                <strong>{{ number_format($veiculo->horas_uso ?? 0, 0, ',', '.') }}h</strong>
                                <small>Uso</small>
                            @else
                                <i class="fas fa-road"></i>
                                <strong>{{ number_format($veiculo->km ?? 0, 0, ',', '.') }}</strong>
                                <small>KM</small>
                            @endif
                        </div>

                        <div>
                            <i class="fas fa-gas-pump"></i>
                            <strong>{{ $veiculo->combustivel ?? 'N/I' }}</strong>
                            <small>Comb.</small>
                        </div>
                    </div>

                    <div class="price-area">
                        @if($veiculo->preco_antigo && $veiculo->preco_antigo > $veiculo->preco)
                            <small>R$ {{ number_format($veiculo->preco_antigo, 2, ',', '.') }}</small>
                        @endif

                        <strong>R$ {{ number_format($veiculo->preco, 2, ',', '.') }}</strong>
                    </div>

                    <div class="vehicle-footer">
                        
                        <span><i class="fas fa-palette me-1"></i> {{ $veiculo->cor ?? 'N/I' }}</span>
                    </div>

                    <div class="mb-3">

    <form action="{{ route('admin.veiculos.toggle-ativo',$veiculo->id) }}" method="POST">
        @csrf
        @method('PATCH')

        @if($veiculo->ativo)

            <button class="btn btn-success w-100 rounded-pill fw-bold">
                <i class="fas fa-eye"></i>
                Na vitrine
            </button>

        @else

            <button class="btn btn-secondary w-100 rounded-pill fw-bold">
                <i class="fas fa-eye-slash"></i>
                Oculto
            </button>

        @endif

    </form>

</div>

<div class="card-actions">

    <a href="{{ route('admin.veiculos.edit',$veiculo->id) }}" class="btn-edit">
        <i class="fas fa-edit me-1"></i>
        Editar
    </a>

    <button
        type="button"
        class="btn-delete"
        data-bs-toggle="modal"
        data-bs-target="#deleteModal{{ $veiculo->id }}">
        <i class="fas fa-trash me-1"></i>
        Excluir
    </button>

</div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal{{ $veiculo->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0">
                    <div class="modal-header bg-danger text-white rounded-top-4">
                        <h5 class="modal-title fw-bold">Confirmar exclusão</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        Tem certeza que deseja excluir o veículo <strong>{{ $veiculo->modelo }}</strong>?
                        <p class="text-danger mt-2 mb-0">
                            <small>Essa ação não pode ser desfeita.</small>
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <form action="{{ route('admin.veiculos.destroy', $veiculo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                Sim, excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-car"></i>
                <h4>Nenhum veículo cadastrado</h4>
                <p>Clique no botão abaixo para cadastrar o primeiro veículo.</p>
                <a href="{{ route('admin.veiculos.create') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                    <i class="fas fa-plus me-1"></i> Cadastrar veículo
                </a>
            </div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $veiculos->links() }}
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

    .btn-add {
        background: white;
        color: #1e3c72;
        border-radius: 15px;
        padding: 12px 18px;
        text-decoration: none;
        font-weight: 900;
        transition: .2s;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        color: #1e3c72;
    }

    .stat-card {
        background: white;
        border-radius: 22px;
        padding: 22px;
        border: 1px solid #eef0f5;
        box-shadow: 0 8px 25px rgba(0,0,0,.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 100%;
        transition: .25s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 35px rgba(0,0,0,.08);
    }

    .stat-card h3 {
        margin: 0;
        font-size: 28px;
        font-weight: 900;
        color: #111827;
    }

    .stat-card p {
        margin: 2px 0 0;
        color: #6b7280;
        font-weight: 700;
        font-size: 14px;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 23px;
    }

    .stat-icon.blue { background: linear-gradient(135deg, #1e3c72, #2563eb); }
    .stat-icon.green { background: linear-gradient(135deg, #16a34a, #22c55e); }
    .stat-icon.red { background: linear-gradient(135deg, #dc2626, #f97316); }
    .stat-icon.purple { background: linear-gradient(135deg, #7c3aed, #a855f7); }

    .toolbar-card {
        background: white;
        border-radius: 22px;
        padding: 20px 22px;
        border: 1px solid #eef0f5;
        box-shadow: 0 8px 25px rgba(0,0,0,.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .toolbar-card strong {
        font-size: 18px;
        color: #111827;
    }

    .vehicle-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        height: 100%;
        border: 1px solid #e9eef5;
        box-shadow: 0 14px 35px rgba(15,23,42,.09);
        transition: .25s;
    }

    .vehicle-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 24px 58px rgba(15,23,42,.16);
    }

    .vehicle-image {
        height: 220px;
        position: relative;
        overflow: hidden;
        background: #e5e7eb;
    }

    .vehicle-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: .35s;
    }

    .vehicle-card:hover .vehicle-image img {
        transform: scale(1.06);
    }

    .no-image {
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 6px;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-weight: 800;
    }

    .no-image i {
        font-size: 48px;
    }

    .status-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        color: white;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        backdrop-filter: blur(8px);
    }

    .status-badge.available {
        background: rgba(22,163,74,.95);
    }

    .status-badge.sold {
        background: rgba(220,53,69,.95);
    }

    .vehicle-body {
        padding: 20px;
    }

    .brand-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
    }

    .brand-row span {
        color: #dc3545;
        font-weight: 950;
        font-size: 13px;
        text-transform: uppercase;
    }

    .brand-row small {
        background: #f1f5f9;
        color: #475569;
        border-radius: 999px;
        padding: 5px 9px;
        font-size: 11px;
        font-weight: 800;
    }

    .vehicle-body h4 {
        color: #0f172a;
        font-size: 23px;
        font-weight: 950;
        margin-bottom: 16px;
        line-height: 1.05;
    }

    .spec-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-bottom: 16px;
    }

    .spec-grid div {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 15px;
        padding: 10px 7px;
        text-align: center;
    }

    .spec-grid i {
        color: #1e3c72;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .spec-grid strong {
        display: block;
        color: #0f172a;
        font-size: 13px;
        font-weight: 900;
        line-height: 1.1;
    }

    .spec-grid small {
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
    }

    .price-area {
        border-top: 1px solid #eef2f7;
        padding-top: 14px;
        margin-bottom: 14px;
    }

    .price-area small {
        display: block;
        color: #94a3b8;
        text-decoration: line-through;
        font-weight: 800;
    }

    .price-area strong {
        color: #16a34a;
        font-size: 24px;
        font-weight: 950;
    }

    .vehicle-footer {
        display: flex;
        justify-content: space-between;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        border-top: 1px solid #eef2f7;
        padding-top: 12px;
        margin-bottom: 14px;
    }

    .card-actions {
        display: flex;
        gap: 10px;
    }

    .btn-edit,
    .btn-delete {
        flex: 1;
        border: none;
        border-radius: 14px;
        padding: 11px;
        font-weight: 900;
        text-align: center;
        text-decoration: none;
        transition: .2s;
    }

    .btn-edit {
        background: #1e3c72;
        color: white;
    }

    .btn-edit:hover {
        background: #2563eb;
        color: white;
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-delete:hover {
        background: #dc3545;
        color: white;
    }

    .empty-state {
        background: white;
        border-radius: 24px;
        padding: 60px 20px;
        text-align: center;
        border: 1px solid #eef0f5;
        box-shadow: 0 8px 25px rgba(0,0,0,.05);
        color: #6b7280;
    }

    .empty-state i {
        font-size: 58px;
        color: #cbd5e1;
        margin-bottom: 14px;
    }

    .empty-state h4 {
        color: #111827;
        font-weight: 900;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 22px;
        }

        .spec-grid {
            grid-template-columns: 1fr;
        }

        .vehicle-footer,
        .card-actions {
            flex-direction: column;
        }
    }
</style>
@endsection