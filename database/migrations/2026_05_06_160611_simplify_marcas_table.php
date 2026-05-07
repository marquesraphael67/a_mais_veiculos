<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('marcas', function (Blueprint $table) {
            // Remover colunas desnecessárias
            if (Schema::hasColumn('marcas', 'descricao')) {
                $table->dropColumn('descricao');
            }
            if (Schema::hasColumn('marcas', 'pais_origem')) {
                $table->dropColumn('pais_origem');
            }
            if (Schema::hasColumn('marcas', 'logo_marca')) {
                $table->dropColumn('logo_marca');
            }
            if (Schema::hasColumn('marcas', 'logo')) {
                $table->dropColumn('logo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('marcas', function (Blueprint $table) {
            $table->text('descricao')->nullable();
            $table->string('pais_origem')->nullable();
            $table->string('logo_marca')->nullable();
            $table->string('logo')->nullable();
        });
    }
};