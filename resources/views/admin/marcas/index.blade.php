@extends('layouts.admin')

@section('title', 'Marcas')
@section('header', 'Gerenciar Marcas')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Marcas</h5>
        <a href="{{ route('admin.marcas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Nova Marca
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 10%">ID</th>
                        <th style="width: 50%">Nome da Marca</th>
                        <th style="width: 20%">Qtd. Veículos</th>
                        <th style="width: 20%">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($marcas as $marca)
                    <tr>
                        <td class="text-center">{{ $marca->id }}</td>
                        <td>
                            <i class="fas fa-trademark text-primary me-2"></i>
                            <strong>{{ $marca->nome }}</strong>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $marca->veiculos->count() }} veículos</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.marcas.edit', $marca->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('admin.marcas.destroy', $marca->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Excluir esta marca?')">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $marcas->links() }}
        </div>
    </div>
</div>
@endsection