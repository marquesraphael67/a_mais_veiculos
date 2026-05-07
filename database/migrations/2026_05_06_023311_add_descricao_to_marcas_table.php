<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('marcas', function (Blueprint $table) {
            $table->text('descricao')->nullable()->after('nome');
            $table->string('logo_marca')->nullable()->after('logo');
            $table->string('pais_origem')->nullable()->after('descricao');
        });
    }

    public function down(): void
    {
        Schema::table('marcas', function (Blueprint $table) {
            $table->dropColumn(['descricao', 'logo_marca', 'pais_origem']);
        });
    }
};