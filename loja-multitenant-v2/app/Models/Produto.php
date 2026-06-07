<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Produto - Exemplo de Model com isolamento Multi-tenancy.
 * 
 * O EmpresaScope garante que cada empresa só veja seus próprios produtos.
 * Copie este padrão (booted + addGlobalScope) para qualquer Model
 * que precise de isolamento por empresa.
 * 
 * A tabela DEVE ter a coluna: empresa_id UNSIGNED BIGINT NOT NULL
 */
class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'nome',
        'descricao',
        'preco',
        'estoque',
        'ativo',
    ];

    protected $casts = [
        'preco'  => 'decimal:2',
        'ativo'  => 'boolean',
    ];

    /**
     * ✅ PADRÃO MULTI-TENANCY:
     * Adicione este método em todo Model que precisa ser isolado por empresa.
     * O EmpresaScope filtra automaticamente por empresa_id em toda query.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    /**
     * Ao criar um registro, injeta automaticamente o empresa_id do tenant atual.
     * Adicione este observer nos Models onde fizer sentido.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->empresa_id)) {
                $model->empresa_id = auth('empresa')->id();
            }
        });
    }

    public function empresa(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }
}
