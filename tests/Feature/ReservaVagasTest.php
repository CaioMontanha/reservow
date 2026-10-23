<?php
namespace Tests\Feature;
use App\Enums\StatusReserva;
use App\Models\Passeio;
use App\Models\Reserva;
use App\Models\Saida;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class ReservaVagasTest extends TestCase
{
    use RefreshDatabase;
    private function fixture(int $capacity=20): array
    {
        $tour = Passeio::create(['nome'=>'Maragogi','slug'=>'maragogi','capacidade_padrao'=>$capacity,'ativo'=>true]);
        $saida = Saida::create(['passeio_id'=>$tour->id,'data'=>now()->addDay()->toDateString(),'horario'=>'08:00','vagas_total'=>$capacity]);
        return [$tour,$saida];
    }
    private function reservation(Saida $saida,int $pax,string $status='pendente'): Reserva
    { return Reserva::create(['saida_id'=>$saida->id,'codigo'=>strtoupper(bin2hex(random_bytes(4))),'nome_cliente'=>'Cliente Teste','telefone'=>'(81) 99999-0000','pessoas'=>$pax,'status'=>$status]); }
    public function test_no_capacity_returns_409(): void
    { [, $s]=$this->fixture(); $this->reservation($s,20,'confirmada'); $r=$this->reservation($s,1); $this->patchJson("/api/reservas/{$r->id}/confirmar")->assertConflict()->assertJsonPath('erro','sem_vagas'); }
    public function test_pending_three_does_not_fit_but_two_fits(): void
    { [, $s]=$this->fixture(); $this->reservation($s,18,'confirmada'); $reservation=$this->reservation($s,3); $this->patchJson("/api/reservas/{$reservation->id}/confirmar")->assertConflict(); $reservation->update(['pessoas'=>2]); $this->patchJson("/api/reservas/{$reservation->id}/confirmar")->assertOk(); }
    public function test_cancelling_confirmed_frees_seats(): void
    { [, $s]=$this->fixture(); $full=$this->reservation($s,20,'confirmada'); $this->patchJson("/api/reservas/{$full->id}/cancelar")->assertOk(); $next=$this->reservation($s,1); $this->patchJson("/api/reservas/{$next->id}/confirmar")->assertOk(); }
    public function test_cancelled_reservation_cannot_be_confirmed(): void
    { [, $s]=$this->fixture(); $r=$this->reservation($s,1,'cancelada'); $this->patchJson("/api/reservas/{$r->id}/confirmar")->assertUnprocessable(); }
    public function test_pending_reservations_do_not_count_as_occupied(): void
    { [, $s]=$this->fixture(); $this->reservation($s,15); $this->assertSame(0,$s->fresh()->vagas_ocupadas); }
}
