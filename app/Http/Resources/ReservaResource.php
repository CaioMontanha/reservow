<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class ReservaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['id' => $this->id, 'saida_id' => $this->saida_id, 'codigo' => $this->codigo, 'nome_cliente' => $this->nome_cliente, 'telefone' => $this->telefone, 'pessoas' => $this->pessoas, 'status' => $this->status->value, 'confirmada_em' => $this->confirmada_em, 'saida' => ['passeio' => $this->saida->passeio->nome, 'data' => $this->saida->data->toDateString(), 'horario' => substr($this->saida->horario, 0, 5)]];
    }
}
