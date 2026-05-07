<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar se já existe o admin
        $admin = User::where('email', 'admin@aveiculos.com')->first();
        
        if (!$admin) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@aveiculos.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('✅ Usuário administrador criado com sucesso!');
            $this->command->info('📧 Email: admin@aveiculos.com');
            $this->command->info('🔑 Senha: 12345678');
        } else {
            $this->command->info('⚠️ Usuário admin já existe!');
            $this->command->info('📧 Email: admin@aveiculos.com');
            $this->command->info('🔑 Senha: 12345678');
        }
    }
}