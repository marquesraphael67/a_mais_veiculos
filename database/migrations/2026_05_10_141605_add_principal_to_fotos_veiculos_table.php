<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fotos_veiculos', function (Blueprint $table) {
            $table->boolean('principal')->default(false)->after('ordem');
        });
    }
    
    public function down()
    {
        Schema::table('fotos_veiculos', function (Blueprint $table) {
            $table->dropColumn('principal');
        });
    }
};