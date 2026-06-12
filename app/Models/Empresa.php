<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Empresa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'usuario',
        'email',
        'password',
        'slug',
        'dominio',
        'cor_primaria',
        'logo_url',
        'descricao',
        'telefone',
        'endereco',
        'banner_rodape',
        'ativo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'ativo'             => 'boolean',
        'banner_rodape'     => 'boolean',
        'password'          => 'hashed',
    ];

    public function produtos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Produto::class);
    }

    public function banners(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Banner::class);
    }

    public function categorias(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Categoria::class);
    }
}
