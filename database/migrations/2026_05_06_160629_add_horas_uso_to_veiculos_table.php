<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('veiculos', function (Blueprint $table) {
        $table->integer('horas_uso')->nullable();
        
    });
}

public function down(): void
{
    Schema::table('veiculos', function (Blueprint $table) {
        $table->dropColumn(['horas_uso']);
    });
}
    
};