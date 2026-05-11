@extends('layouts.admin')

@section('title', 'Marcas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="mb-0">
            <i class="fas fa-trademark me-2" style="color: #1e3c72;"></i>
            Marcas
        </h2>
        <p class="text-muted mt-1 mb-0">Gerencie as marcas dos veículos</p>
    </div>
    
    <a href="{{ route('admin.marcas.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Nova Marca
    </a>
</div>

<!-- SEM table-responsive para evitar arraste lateral -->
<div class="card">
    <div class="card-body p-0">
        <table class="table table-marcas mb-0" style="width: 100%; table-layout: fixed;">
            <thead>
                <tr>
                    <th style="width: 70px">ID</th>
                    <th>Marca</th>
                    <th style="width: 100px">Veículos</th>
                    <th style="width: 100px">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($marcas as $marca)
                <tr>
                    <td class="fw-bold text-primary">{{ $marca->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="marca-icon-small">
                                <i class="fas fa-trademark"></i>
                            </div>
                            <strong>{{ $marca->nome }}</strong>
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $marca->veiculos_count > 0 ? 'bg-primary' : 'bg-secondary' }} rounded-pill px-3 py-2">
                            <i class="fas fa-car me-1"></i> {{ $marca->veiculos_count }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm gap-1">
                            <a href="{{ route('admin.marcas.edit', $marca->id) }}" class="btn btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $marca->id }}" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Modal Exclusão -->
                <div class="modal fade" id="deleteModal{{ $marca->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Confirmar Exclusão</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Tem certeza que deseja excluir a marca <strong>{{ $marca->nome }}</strong>?
                                @if($marca->veiculos_count > 0)
                                    <div class="alert alert-warning mt-2 mb-0">
                                        ⚠️ Esta marca possui {{ $marca->veiculos_count }} veículo(s) vinculado(s).
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form action="{{ route('admin.marcas.destroy', $marca->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4">
                        <i class="fas fa-trademark fa-3x text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">Nenhuma marca cadastrada</h5>
                        <a href="{{ route('admin.marcas.create') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-plus me-1"></i> Cadastrar primeira marca
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .table-marcas {
        border-collapse: collapse;
        width: 100%;
        table-layout: fixed;
    }
    
    .table-marcas td, 
    .table-marcas th {
        padding: 15px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }
    
    .table-marcas tr:hover {
        background-color: #f8f9fa;
    }
    
    .marca-icon-small {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }
    
    @media (max-width: 768px) {
        .table-marcas td, 
        .table-marcas th {
            padding: 12px 8px;
            font-size: 13px;
        }
        
        .btn-group .btn {
            padding: 4px 8px;
        }
        
        .badge {
            font-size: 10px;
        }
    }
</style>
@endsection