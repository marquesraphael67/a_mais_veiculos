@extends('layouts.admin')

@section('title', 'Nova Marca')

@section('content')
<div class="form-container">
    <div class="page-header mb-4">
        <div>
            <h2>
                <i class="fas fa-tags me-2"></i>
                Cadastrar Nova Marca
            </h2>
            <p>Adicione uma nova marca para organizar os veículos.</p>
        </div>

        <a href="{{ route('admin.marcas.index') }}" class="btn-back">
            <i class="fas fa-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.marcas.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label">Nome da marca <span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="nome" 
                    class="form-control" 
                    required 
                    value="{{ old('nome') }}"
                    placeholder="Ex: Chevrolet, Honda, Toyota"
                    autofocus
                >
                <small class="text-muted">Essa marca aparecerá no cadastro e filtro dos veículos.</small>
            </div>

            <div class="preview-box">
                <div class="preview-icon">
                    <i class="fas fa-trademark"></i>
                </div>
                <div>
                    <strong>Organização do estoque</strong>
                    <p class="mb-0">Depois de cadastrar, você poderá vincular veículos a essa marca.</p>
                </div>
            </div>

            <div class="d-flex justify-content-between flex-wrap gap-2 mt-4">
                <a href="{{ route('admin.marcas.index') }}" class="btn btn-secondary px-4">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-primary px-5">
                    <i class="fas fa-save me-1"></i> Salvar Marca
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    body {
        background: #f5f7fb;
    }

    .form-container {
        max-width: 780px;
        margin: 0 auto;
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

    .btn-back {
        background: white;
        color: #1e3c72;
        border-radius: 15px;
        padding: 12px 18px;
        text-decoration: none;
        font-weight: 900;
        transition: .2s;
    }

    .btn-back:hover {
        color: #1e3c72;
        transform: translateY(-2px);
    }

    .form-card {
        background: white;
        border-radius: 24px;
        padding: 28px;
        border: 1px solid #eef0f5;
        box-shadow: 0 8px 25px rgba(0,0,0,.05);
    }

    .form-label {
        font-weight: 900;
        color: #111827;
        font-size: 14px;
    }

    .form-control {
        border-radius: 15px;
        border: 1px solid #dce3ee;
        padding: 13px 15px;
    }

    .form-control:focus {
        border-color: #1e3c72;
        box-shadow: 0 0 0 4px rgba(30,60,114,.12);
    }

    .preview-box {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 20px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .preview-icon {
        width: 52px;
        height: 52px;
        border-radius: 17px;
        background: linear-gradient(135deg, #1e3c72, #2563eb);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .preview-box strong {
        color: #111827;
        font-weight: 900;
    }

    .preview-box p {
        color: #6b7280;
        font-size: 14px;
    }

    .btn {
        border-radius: 14px;
        padding: 11px 20px;
        font-weight: 900;
    }

    .btn-primary {
        background: #1e3c72;
        border: none;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #6b7280;
        border: none;
    }

    @media (max-width: 768px) {
        .page-header,
        .form-card {
            padding: 22px;
        }
    }
</style>
@endsection