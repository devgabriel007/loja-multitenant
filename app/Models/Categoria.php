<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'nome',
        'descricao',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

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

    public function produtos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Produto::class);
    }
}
