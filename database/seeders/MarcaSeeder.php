<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = [
            'Volkswagen', 'Fiat', 'Chevrolet', 'Ford', 'Honda', 
            'Toyota', 'Hyundai', 'Nissan', 'BMW', 'Mercedes-Benz',
            'Audi', 'Kia', 'Jeep', 'Renault', 'Peugeot',
            'Sea-Doo', 'Yamaha',
        ];
        
        foreach ($marcas as $nome) {
            Marca::firstOrCreate(['nome' => $nome]);
        }
    }
}