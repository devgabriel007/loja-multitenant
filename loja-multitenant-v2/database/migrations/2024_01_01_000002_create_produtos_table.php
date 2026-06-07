<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabela de Produtos (Exemplo de tabela multi-tenant)
 * 
 * ✅ PADRÃO: toda tabela que precisa de isolamento por empresa
 *    DEVE ter a coluna empresa_id com foreignId + constrained.
 * 
 * Replique este padrão para: clientes, pedidos, categorias, etc.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();

            // ✅ COLUNA OBRIGATÓRIA para o EmpresaScope funcionar:
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();

            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2)->default(0);
            $table->integer('estoque')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            // Índice para performance nas queries filtradas por empresa:
            $table->index('empresa_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
