@extends('layouts.admin')

@section('title', 'Nova Marca')
@section('header', 'Cadastrar Nova Marca')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.marcas.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Nome da Marca *</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            
            <div class="text-end">
                <a href="{{ route('admin.marcas.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection