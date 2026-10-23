<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Passeio extends Model
{
    protected $fillable = ['nome', 'slug', 'capacidade_padrao', 'preco_centavos', 'ativo'];
    protected $casts = ['ativo' => 'boolean'];
    public function saidas(): HasMany { return $this->hasMany(Saida::class); }
}
