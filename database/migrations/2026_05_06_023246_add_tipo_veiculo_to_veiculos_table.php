<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->enum('tipo_veiculo', ['carro', 'moto', 'caminhao', 'jetski', 'lancha'])->default('carro')->after('status');
            $table->text('obs_admin')->nullable()->after('descricao');
            $table->decimal('desconto_maximo', 10, 2)->nullable()->after('preco');
            $table->decimal('preco_antigo', 10, 2)->nullable()->after('preco');
        });
    }

    public function down(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->dropColumn(['tipo_veiculo', 'obs_admin', 'desconto_maximo', 'preco_antigo']);
        });
    }
};