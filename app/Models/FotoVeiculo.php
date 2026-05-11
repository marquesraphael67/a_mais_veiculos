<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoVeiculo extends Model
{
    protected $table = 'fotos_veiculos';
    
    protected $fillable = [
        'veiculo_id', 'caminho', 'foto_path', 'ordem', 'principal'
    ];
    
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}