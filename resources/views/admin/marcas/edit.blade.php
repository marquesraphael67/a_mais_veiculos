@extends('layouts.admin')

@section('title', 'Editar Marca')
@section('header', 'Editar Marca')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.marcas.update', $marca->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nome da Marca *</label>
                <input type="text" name="nome" class="form-control" value="{{ $marca->nome }}" required>
            </div>
            
            <div class="text-end">
                <a href="{{ route('admin.marcas.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection