<?php
namespace App\Models;
use App\Enums\StatusReserva;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Reserva extends Model
{
    protected $fillable = ['saida_id', 'codigo', 'nome_cliente', 'telefone', 'pessoas', 'status', 'confirmada_em', 'cancelada_em'];
    protected $casts = ['status' => StatusReserva::class, 'confirmada_em' => 'datetime', 'cancelada_em' => 'datetime'];
    public function saida(): BelongsTo { return $this->belongsTo(Saida::class); }
}
