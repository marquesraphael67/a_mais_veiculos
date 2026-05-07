@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6>Total Veículos</h6>
                <h2>{{ $totalVeiculos }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6>Disponíveis</h6>
                <h2 class="text-success">{{ $totalDisponiveis }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6>Vendidos</h6>
                <h2 class="text-danger">{{ $totalVendidos }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6>Marcas</h6>
                <h2>{{ $totalMarcas }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Últimos Veículos</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr><th>ID</th><th>Veículo</th><th>Ano</th><th>Preço</th><th>Status</th></tr>
            </thead>
            <tbody>
                @foreach($ultimosVeiculos as $veiculo)
                <tr>
                    <td>{{ $veiculo->id }}</td>
                    <td>{{ $veiculo->marca->nome ?? '' }} {{ $veiculo->modelo }}</td>
                    <td>{{ $veiculo->ano }}</td>
                    <td>R$ {{ number_format($veiculo->preco, 2, ',', '.') }}</td>
                    <td>{{ $veiculo->status == 'disponivel' ? 'Disponível' : 'Vendido' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection