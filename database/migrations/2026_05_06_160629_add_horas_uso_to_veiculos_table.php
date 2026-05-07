<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->integer('horas_uso')->nullable()->after('km');
            $table->enum('tipo_veiculo', ['carro', 'moto', 'caminhao', 'jetski', 'lancha'])->default('carro')->after('status');
            $table->text('obs_admin')->nullable()->after('descricao');
            $table->decimal('preco_antigo', 10, 2)->nullable()->after('preco');
            $table->decimal('desconto_maximo', 10, 2)->nullable()->after('preco_antigo');
        });
    }

    public function down(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->dropColumn(['horas_uso', 'tipo_veiculo', 'obs_admin', 'preco_antigo', 'desconto_maximo']);
        });
    }
};