<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class SaidaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['id' => $this->id, 'passeio' => $this->passeio->nome, 'slug' => $this->passeio->slug, 'data' => $this->data->toDateString(), 'horario' => substr($this->horario, 0, 5), 'vagas_total' => $this->vagas_total, 'vagas_ocupadas' => $this->vagas_ocupadas, 'vagas_restantes' => $this->vagas_restantes];
    }
}
