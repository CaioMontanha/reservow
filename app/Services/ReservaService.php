<?php
namespace App\Services;
use App\Enums\StatusReserva;
use App\Exceptions\SemVagasException;
use App\Models\Reserva;
use App\Models\Saida;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class ReservaService
{
    public function transicionar(Reserva $reserva, StatusReserva $destino): Reserva
    {
        return DB::transaction(function () use ($reserva, $destino) {
            $reserva = Reserva::query()->lockForUpdate()->findOrFail($reserva->id);
            if (!$reserva->status->podeIrPara($destino)) {
                throw ValidationException::withMessages(['status' => "Não é possível alterar {$reserva->status->value} para {$destino->value}."]);
            }
            if ($destino === StatusReserva::Confirmada) {
                $saida = Saida::query()->lockForUpdate()->findOrFail($reserva->saida_id);
                $ocupadas = $saida->reservas()->where('status', StatusReserva::Confirmada->value)->sum('pessoas');
                $restantes = max(0, $saida->vagas_total - (int) $ocupadas);
                if ($reserva->pessoas > $restantes) throw new SemVagasException($restantes);
                $reserva->confirmada_em = now();
            }
            if ($destino === StatusReserva::Cancelada) $reserva->cancelada_em = now();
            $reserva->status = $destino;
            $reserva->save();
            return $reserva->refresh()->load('saida.passeio');
        });
    }
}
