<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('fotos_veiculos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('veiculo_id')->constrained('veiculos')->onDelete('cascade');
    $table->string('foto_path');
    $table->integer('ordem')->default(0);
    $table->boolean('principal')->default(false);
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos_veiculos');
    }
};
