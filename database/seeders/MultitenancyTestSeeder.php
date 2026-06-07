<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Empresa;
use App\Models\Produto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MultitenancyTestSeeder extends Seeder
{
    public function run(): void
    {
        // ── Empresa A — Tech Solutions ────────────────────────────────
        // Acessível em: localhost:8000 (local) | loja-a.com (produção)
        $empresaA = Empresa::create([
            'nome'         => 'Tech Solutions Ltda',
            'usuario'      => 'empresa_a',
            'email'        => 'contato@techsolutions.com',
            'password'     => Hash::make('123456'),
            'slug'         => 'tech',
            'dominio'      => 'loja-a.com',
            'cor_primaria' => '#1d4ed8',   // azul
            'ativo'        => true,
        ]);

        Banner::create(['empresa_id' => $empresaA->id, 'titulo' => 'Bem-vindo à Tech Solutions', 'subtitulo' => 'Tecnologia de ponta para o seu negócio', 'cor_fundo' => '#1d4ed8', 'ordem' => 1, 'ativo' => true]);
        Banner::create(['empresa_id' => $empresaA->id, 'titulo' => 'Novos produtos chegaram!', 'subtitulo' => 'Confira as novidades', 'cor_fundo' => '#7c3aed', 'ordem' => 2, 'ativo' => true]);

        foreach ([
            ['nome' => 'Notebook Pro 15',  'preco' => 4999.90, 'estoque' => 15, 'descricao' => 'Notebook para desenvolvedores'],
            ['nome' => 'Mouse Ergonômico', 'preco' =>  189.90, 'estoque' => 50, 'descricao' => 'Mouse vertical sem fio'],
            ['nome' => 'Teclado Mecânico', 'preco' =>  349.90, 'estoque' => 30, 'descricao' => 'Switch Blue, ABNT2'],
            ['nome' => 'Monitor 27" 4K',   'preco' => 2199.00, 'estoque' =>  8, 'descricao' => 'IPS, 144Hz, HDR'],
        ] as $p) {
            Produto::create(array_merge($p, ['empresa_id' => $empresaA->id, 'ativo' => true]));
        }

        // ── Empresa B — Café Gourmet ──────────────────────────────────
        // Acessível em: localhost:8001 (local) | loja-b.com (produção)
        $empresaB = Empresa::create([
            'nome'         => 'Café Gourmet ME',
            'usuario'      => 'empresa_b',
            'email'        => 'contato@cafegourmet.com',
            'password'     => Hash::make('123456'),
            'slug'         => 'cafe',
            'dominio'      => 'loja-b.com',
            'cor_primaria' => '#92400e',   // marrom café
            'ativo'        => true,
        ]);

        Banner::create(['empresa_id' => $empresaB->id, 'titulo' => 'Café Especial Direto ao Paladar', 'subtitulo' => 'Origem única, torra artesanal', 'cor_fundo' => '#92400e', 'ordem' => 1, 'ativo' => true]);
        Banner::create(['empresa_id' => $empresaB->id, 'titulo' => 'Novidade: Chemex chegou!', 'subtitulo' => 'O método perfeito para o seu café', 'cor_fundo' => '#78350f', 'ordem' => 2, 'ativo' => true]);

        foreach ([
            ['nome' => 'Café Especial 250g', 'preco' =>  38.90, 'estoque' => 200, 'descricao' => 'Origem única, torra média'],
            ['nome' => 'Chemex 6 xícaras',   'preco' => 219.00, 'estoque' =>  20, 'descricao' => 'Coador de vidro borossilicato'],
            ['nome' => 'Moedor Manual',       'preco' => 149.00, 'estoque' =>  35, 'descricao' => 'Cerâmica ajustável'],
        ] as $p) {
            Produto::create(array_merge($p, ['empresa_id' => $empresaB->id, 'ativo' => true]));
        }

        $this->command->info('✅ Seeder concluído!');
        $this->command->info('');
        $this->command->info('🖥️  DOIS SERVIDORES LOCAIS:');
        $this->command->info('   Terminal 1: php artisan serve --port=8000  →  localhost:8000  (Tech Solutions - azul)');
        $this->command->info('   Terminal 2: php artisan serve --port=8001  →  localhost:8001  (Café Gourmet - marrom)');
        $this->command->info('');
        $this->command->info('🔑 Admin A: usuario=empresa_a  senha=123456  → localhost:8000/admin/login');
        $this->command->info('🔑 Admin B: usuario=empresa_b  senha=123456  → localhost:8001/admin/login');
    }
}
