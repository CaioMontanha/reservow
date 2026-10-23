<?php
namespace App\Enums;
enum StatusReserva: string
{
    case Pendente = 'pendente';
    case Confirmada = 'confirmada';
    case Cancelada = 'cancelada';
    public function podeIrPara(self $destino): bool
    {
        return match ($this) {
            self::Pendente => in_array($destino, [self::Confirmada, self::Cancelada], true),
            self::Confirmada => $destino === self::Cancelada,
            self::Cancelada => false,
        };
    }
}
