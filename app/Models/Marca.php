<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = ['nome', 'logo', 'descricao', 'logo_marca', 'pais_origem'];
    
    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }
}