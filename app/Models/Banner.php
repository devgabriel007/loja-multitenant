<?php
namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id', 'titulo', 'subtitulo', 'url_link', 'cor_fundo', 'ordem', 'ativo',
    ];

    protected $casts = ['ativo' => 'boolean', 'ordem' => 'integer'];

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (self $model) {
            if (empty($model->empresa_id)) {
                $model->empresa_id = auth('empresa')->id();
            }
        });
    }
}
