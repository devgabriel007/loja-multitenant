<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->string('titulo');
            $table->string('subtitulo')->nullable();
            $table->string('url_link', 500)->nullable();
            $table->string('cor_fundo', 7)->default('#1d4ed8'); // cor hex
            $table->integer('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->index('empresa_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
