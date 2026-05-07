@extends('layouts.admin')

@section('title', 'Veículos')
@section('header', 'Gerenciar Veículos')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Veículos</h5>
        <a href="{{ route('admin.veiculos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Novo Veículo
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div style="overflow-x: auto; width: 100%;">
            <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
                <thead>
                    <tr style="background-color: #1e3c72; color: white;">
                        <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Tipo</th>
                        <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Foto</th>
                        <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Veículo</th>
                        <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Ano</th>
                        <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">KM/Horas</th>
                        <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Preço</th>
                        <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Status</th>
                        <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($veiculos as $veiculo)
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            @if($veiculo->tipo_veiculo == 'carro') 🚗 Carro
                            @elseif($veiculo->tipo_veiculo == 'moto') 🏍️ Moto
                            @elseif($veiculo->tipo_veiculo == 'caminhao') 🚛 Caminhão
                            @elseif($veiculo->tipo_veiculo == 'jetski') 🌊 Jet Ski
                            @elseif($veiculo->tipo_veiculo == 'lancha') ⛵ Lancha
                            @endif
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <img src="{{ asset('storage/' . $veiculo->imagem_destaque) }}" style="width: 50px; height: 40px; object-fit: cover;">
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <strong>{{ $veiculo->marca->nome ?? 'Sem marca' }}</strong><br>
                            {{ $veiculo->modelo }}<br>
                            <small>{{ $veiculo->cor }} - {{ $veiculo->combustivel }}</small>
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $veiculo->ano }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            @if($veiculo->tipo_veiculo == 'jetski' || $veiculo->tipo_veiculo == 'lancha')
                                ⏱️ {{ number_format($veiculo->horas_uso ?? 0, 0, ',', '.') }} h
                            @else
                                📊 {{ number_format($veiculo->km ?? 0, 0, ',', '.') }} km
                            @endif
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd; color: #28a745; font-weight: bold;">
                            R$ {{ number_format($veiculo->preco, 2, ',', '.') }}
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <span style="background: {{ $veiculo->status == 'disponivel' ? '#28a745' : '#dc3545' }}; color: white; padding: 5px 10px; border-radius: 5px;">
                                {{ $veiculo->status == 'disponivel' ? 'Disponível' : 'Vendido' }}
                            </span>
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <a href="{{ route('admin.veiculos.edit', $veiculo->id) }}" class="btn btn-sm btn-primary">Editar</a>
                            <form action="{{ route('admin.veiculos.destroy', $veiculo->id) }}" method="POST" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="padding: 40px; text-align: center;">Nenhum veículo cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $veiculos->links() }}
        </div>
    </div>
</div>
@endsection