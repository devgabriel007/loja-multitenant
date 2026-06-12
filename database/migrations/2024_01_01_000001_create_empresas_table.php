<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('usuario')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('slug')->unique()->nullable();
            $table->string('dominio')->nullable()->unique()
                ->comment('Domínio de produção, ex: minha-loja.com');
            $table->string('cor_primaria')->default('#0d6efd')
                ->comment('Cor primária da loja em hex');
            $table->string('logo_url', 500)->nullable()
                ->comment('URL da logo da loja');
            $table->text('descricao')->nullable()
                ->comment('Descrição/slogan da loja');
            $table->string('telefone')->nullable();
            $table->string('endereco')->nullable();
            $table->boolean('banner_rodape')->default(false)
                ->comment('Exibir banners também no rodapé da loja');
            $table->boolean('ativo')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
