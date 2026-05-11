<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = ['nome', 'descricao'];
    
    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }
}