<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fotos_veiculos', function (Blueprint $table) {
            // Verificar se a coluna não existe antes de adicionar
            if (!Schema::hasColumn('fotos_veiculos', 'principal')) {
                $table->boolean('principal')->default(false)->after('ordem');
            }
        });
    }
    
    public function down()
    {
        Schema::table('fotos_veiculos', function (Blueprint $table) {
            if (Schema::hasColumn('fotos_veiculos', 'principal')) {
                $table->dropColumn('principal');
            }
        });
    }
};