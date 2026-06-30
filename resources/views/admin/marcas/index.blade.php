@extends('layouts.admin')

@section('title', 'Marcas')

@section('content')
<div class="page-header mb-4">
    <div>
        <h2>
            <i class="fas fa-tags me-2"></i>
            Marcas
        </h2>
        <p>Gerencie as marcas usadas no cadastro dos veículos.</p>
    </div>

    <a href="{{ route('admin.marcas.create') }}" class="btn-add">
        <i class="fas fa-plus me-1"></i> Nova marca
    </a>
</div>

<div class="summary-card mb-4">
    <div>
        <strong>{{ $marcas->count() }}</strong>
        <span>marca(s) cadastrada(s)</span>
    </div>

    <div class="summary-icon">
        <i class="fas fa-trademark"></i>
    </div>
</div>

<div class="brands-card">
    @forelse($marcas as $marca)
        <div class="brand-row">
            <div class="brand-info">
                <div class="brand-icon">
                    <i class="fas fa-trademark"></i>
                </div>

                <div>
    <h4>{{ $marca->nome }}</h4>
    <small class="text-muted">
        Marca cadastrada
    </small>
</div>
            </div>

            <div class="brand-meta">
                <span class="vehicle-count">
                    <i class="fas fa-car me-1"></i>
                    {{ $marca->veiculos_count }} veículo(s)
                </span>

                <div class="brand-actions">
                    <a href="{{ route('admin.marcas.edit', $marca->id) }}" class="btn-edit">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="button"
                            class="btn-delete"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal{{ $marca->id }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal{{ $marca->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0">
                    <div class="modal-header bg-danger text-white rounded-top-4">
                        <h5 class="modal-title fw-bold">Confirmar exclusão</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        Tem certeza que deseja excluir a marca <strong>{{ $marca->nome }}</strong>?

                        @if($marca->veiculos_count > 0)
                            <div class="alert alert-warning mt-3 mb-0 rounded-4">
                                <strong>Atenção:</strong> esta marca possui {{ $marca->veiculos_count }} veículo(s) vinculado(s).
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <form action="{{ route('admin.marcas.destroy', $marca->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-trademark"></i>
            <h4>Nenhuma marca cadastrada</h4>
            <p>Cadastre marcas para organizar melhor o estoque.</p>

            <a href="{{ route('admin.marcas.create') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                <i class="fas fa-plus me-1"></i> Cadastrar marca
            </a>
        </div>
    @endforelse
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
        color: #1e3c72;
        transform: translateY(-2px);
    }

    .summary-card,
    .brands-card,
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
        background: linear-gradient(135deg, #1e3c72, #2563eb);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .brands-card {
        padding: 10px;
    }

    .brand-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        padding: 18px;
        border-radius: 18px;
        transition: .2s;
        border-bottom: 1px solid #eef2f7;
    }

    .brand-row:last-child {
        border-bottom: none;
    }

    .brand-row:hover {
        background: #f8fafc;
    }

    .brand-info {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .brand-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        background: #eef4ff;
        color: #1e3c72;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .brand-info h4 {
        margin: 0;
        color: #111827;
        font-size: 19px;
        font-weight: 950;
        word-break: break-word;
    }

    .brand-info p {
        margin: 3px 0 0;
        color: #6b7280;
        font-size: 13px;
        font-weight: 700;
    }

    .brand-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .vehicle-count {
        background: #eef4ff;
        color: #1e3c72;
        padding: 8px 13px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 900;
        white-space: nowrap;
    }

    .brand-actions {
        display: flex;
        gap: 8px;
    }

    .btn-edit,
    .btn-delete {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .2s;
    }

    .btn-edit {
        background: #1e3c72;
        color: white;
        text-decoration: none;
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
        .summary-card {
            padding: 22px;
        }

        .brand-row {
            align-items: flex-start;
            flex-direction: column;
        }

        .brand-meta {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>
@endsection