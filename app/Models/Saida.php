<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Saida extends Model
{
    public $timestamps = false;
    protected $fillable = ['passeio_id', 'data', 'horario', 'vagas_total'];
    protected $casts = ['data' => 'date'];
    public function passeio(): BelongsTo { return $this->belongsTo(Passeio::class); }
    public function reservas(): HasMany { return $this->hasMany(Reserva::class); }
    public function getVagasOcupadasAttribute(): int { return (int) $this->reservas()->where('status', 'confirmada')->sum('pessoas'); }
    public function getVagasRestantesAttribute(): int { return max(0, $this->vagas_total - $this->vagas_ocupadas); }
}
