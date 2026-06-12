<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'categoria_id',
        'nome',
        'descricao',
        'preco',
        'preco_antigo',
        'estoque',
        'imagem_url',
        'destaque',
        'ativo',
    ];

    protected $casts = [
        'preco'       => 'decimal:2',
        'preco_antigo'=> 'decimal:2',
        'ativo'       => 'boolean',
        'destaque'    => 'boolean',
    ];

    // ✅ PADRÃO MULTI-TENANCY: filtra automaticamente por empresa
    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);

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

    public function categoria(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
}
