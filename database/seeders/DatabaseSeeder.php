<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Produto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Empresa A ────────────────────────────────────────────
        $empresaA = Empresa::create([
            'nome'         => 'TechShop',
            'usuario'      => 'techshop',
            'email'        => 'admin@techshop.com',
            'password'     => Hash::make('123456'),
            'slug'         => 'techshop',
            'dominio'      => null,
            'cor_primaria' => '#6366f1',
            'descricao'    => 'Os melhores produtos de tecnologia',
            'ativo'        => true,
        ]);

        $catEletronicos = Categoria::create(['empresa_id' => $empresaA->id, 'nome' => 'Eletrônicos']);
        $catAcessorios  = Categoria::create(['empresa_id' => $empresaA->id, 'nome' => 'Acessórios']);

        Produto::create(['empresa_id' => $empresaA->id, 'categoria_id' => $catEletronicos->id, 'nome' => 'Smartphone X Pro', 'preco' => 2499.90, 'estoque' => 15, 'destaque' => true, 'descricao' => 'O melhor smartphone do mercado com câmera de 108MP.']);
        Produto::create(['empresa_id' => $empresaA->id, 'categoria_id' => $catEletronicos->id, 'nome' => 'Notebook UltraFast', 'preco' => 4199.00, 'preco_antigo' => 4999.00, 'estoque' => 8, 'destaque' => true, 'descricao' => 'Notebook leve e rápido para o dia a dia profissional.']);
        Produto::create(['empresa_id' => $empresaA->id, 'categoria_id' => $catAcessorios->id, 'nome' => 'Fone Bluetooth Pro', 'preco' => 349.90, 'estoque' => 30, 'descricao' => 'Cancelamento de ruído ativo e 30h de bateria.']);
        Produto::create(['empresa_id' => $empresaA->id, 'categoria_id' => $catAcessorios->id, 'nome' => 'Carregador Turbo 65W', 'preco' => 129.90, 'estoque' => 50]);

        Banner::create(['empresa_id' => $empresaA->id, 'titulo' => 'Tecnologia que transforma', 'subtitulo' => 'Os melhores produtos com os melhores preços', 'cor_fundo' => '#4f46e5', 'ordem' => 1]);
        Banner::create(['empresa_id' => $empresaA->id, 'titulo' => 'Frete grátis acima de R$ 500', 'subtitulo' => 'Para todo o Brasil', 'cor_fundo' => '#7c3aed', 'ordem' => 2]);

        // ─── Empresa B ────────────────────────────────────────────
        $empresaB = Empresa::create([
            'nome'         => 'ModaViva',
            'usuario'      => 'modaviva',
            'email'        => 'admin@modaviva.com',
            'password'     => Hash::make('123456'),
            'slug'         => 'modaviva',
            'dominio'      => null,
            'cor_primaria' => '#ec4899',
            'descricao'    => 'Moda feminina com estilo e qualidade',
            'ativo'        => true,
        ]);

        $catRoupas   = Categoria::create(['empresa_id' => $empresaB->id, 'nome' => 'Roupas']);
        $catCalcados = Categoria::create(['empresa_id' => $empresaB->id, 'nome' => 'Calçados']);

        Produto::create(['empresa_id' => $empresaB->id, 'categoria_id' => $catRoupas->id, 'nome' => 'Vestido Floral', 'preco' => 189.90, 'estoque' => 20, 'destaque' => true, 'descricao' => 'Leve e elegante para o verão.']);
        Produto::create(['empresa_id' => $empresaB->id, 'categoria_id' => $catRoupas->id, 'nome' => 'Blusa Básica Premium', 'preco' => 79.90, 'estoque' => 40, 'descricao' => 'Algodão 100% premium em várias cores.']);
        Produto::create(['empresa_id' => $empresaB->id, 'categoria_id' => $catCalcados->id, 'nome' => 'Scarpin Elegante', 'preco' => 259.00, 'preco_antigo' => 319.00, 'estoque' => 12, 'destaque' => true]);
        Produto::create(['empresa_id' => $empresaB->id, 'categoria_id' => $catCalcados->id, 'nome' => 'Tênis Casual Feminino', 'preco' => 219.90, 'estoque' => 25]);

        Banner::create(['empresa_id' => $empresaB->id, 'titulo' => 'Nova Coleção Verão', 'subtitulo' => 'Peças exclusivas com até 30% OFF', 'cor_fundo' => '#db2777', 'ordem' => 1]);
        Banner::create(['empresa_id' => $empresaB->id, 'titulo' => 'Parcele em até 12x', 'subtitulo' => 'Sem juros nos cartões selecionados', 'cor_fundo' => '#9d174d', 'ordem' => 2]);

        $this->command->info('✅ Seed concluído! Duas lojas criadas:');
        $this->command->info('   Loja A → usuário: techshop  | senha: 123456');
        $this->command->info('   Loja B → usuário: modaviva  | senha: 123456');
        $this->command->info('');
        $this->command->info('Para testar:');
        $this->command->info('   php artisan serve --port=8000  → TechShop');
        $this->command->info('   php artisan serve --port=8001  → ModaViva');
        $this->command->info('   Ou: /?tenant=techshop e /?tenant=modaviva');
    }
}
