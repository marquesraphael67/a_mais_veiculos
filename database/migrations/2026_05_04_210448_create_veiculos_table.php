<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marca_id')->constrained('marcas');
            $table->string('modelo', 100);
            $table->integer('ano');
            $table->decimal('preco', 10, 2);
            $table->integer('km');
            $table->string('cor', 30);
            $table->string('combustivel', 20);
            $table->integer('portas');
            $table->text('descricao');
            $table->string('imagem_destaque');
            $table->enum('status', ['disponivel', 'vendido'])->default('disponivel');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};