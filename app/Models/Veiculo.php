<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $fillable = [
        'marca_id', 'modelo', 'ano', 'preco', 'preco_antigo', 'desconto_maximo',
        'km', 'horas_uso', 'cor', 'combustivel', 'portas', 'descricao', 'obs_admin',
        'imagem_destaque', 'status', 'tipo_veiculo'
    ];
    
    protected $casts = [
        'preco' => 'decimal:2',
        'preco_antigo' => 'decimal:2',
        'desconto_maximo' => 'decimal:2',
    ];
    
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }
    
    public function fotos()
    {
        return $this->hasMany(FotoVeiculo::class);
    }
    
    // Exibe KM ou Horas dependendo do tipo
    public function getKmOuHorasAttribute()
    {
        if ($this->tipo_veiculo == 'jetski' || $this->tipo_veiculo == 'lancha') {
            return number_format($this->horas_uso ?? 0, 0, ',', '.') . ' horas';
        }
        return number_format($this->km ?? 0, 0, ',', '.') . ' km';
    }
    
    public function getTipoVeiculoLabelAttribute()
    {
        $tipos = [
            'carro' => '🚗 Carro',
            'moto' => '🏍️ Moto',
            'caminhao' => '🚛 Caminhão',
            'jetski' => '🌊 Jet Ski',
            'lancha' => '⛵ Lancha'
        ];
        return $tipos[$this->tipo_veiculo] ?? '🚗 Carro';
    }
    
    public function getIconeAttribute()
    {
        $icones = [
            'carro' => 'fa-car',
            'moto' => 'fa-motorcycle',
            'caminhao' => 'fa-truck',
            'jetski' => 'fa-water',
            'lancha' => 'fa-ship'
        ];
        return $icones[$this->tipo_veiculo] ?? 'fa-car';
    }
}