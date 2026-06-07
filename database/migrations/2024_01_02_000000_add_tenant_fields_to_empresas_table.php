<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adiciona campos de personalização e identificação por domínio à tabela empresas.
 * - dominio: usado em produção para identificar o tenant pelo host HTTP
 * - cor_primaria: cor personalizada de cada loja (hex)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->string('dominio')->nullable()->unique()->after('slug')
                ->comment('Domínio de produção, ex: minha-loja.com');
            $table->string('cor_primaria')->default('#0d6efd')->after('dominio')
                ->comment('Cor primária da loja em hex, ex: #1d4ed8');
        });
    }

    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn(['dominio', 'cor_primaria']);
        });
    }
};
