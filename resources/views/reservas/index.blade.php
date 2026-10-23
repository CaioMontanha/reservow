@extends('layouts.app')
@section('title','Reservas')
@section('content')
<div class="page-heading"><div><h1>Reservas</h1><p>Gerenciamento operacional de reservas e confirmações</p></div><a class="button button-primary desktop-new" href="{{ route('reservas.create') }}"><span class="material-symbols-outlined">add</span> Nova reserva</a></div>
<section class="filter-panel"><form action="{{ route('reservas.index') }}" method="get" class="filter-grid">
<div class="field"><label for="filter-date">Data do passeio</label><input id="filter-date" type="date" name="data" value="{{ request('data') }}"></div>
<div class="field"><label for="filter-status">Status da reserva</label><select id="filter-status" name="status"><option value="">Todos</option>@foreach(['pendente'=>'Pendente','confirmada'=>'Confirmada','cancelada'=>'Cancelada'] as $key=>$label)<option value="{{ $key }}" @selected(request('status')===$key)>{{ $label }}</option>@endforeach</select></div>
<div class="field"><label for="filter-tour">Passeio</label><select id="filter-tour" name="passeio"><option value="">Todos os passeios</option>@foreach($passeios as $passeio)<option value="{{ $passeio->slug }}" @selected(request('passeio')===$passeio->slug)>{{ $passeio->nome }}</option>@endforeach</select></div>
<button class="button button-outline filter-button" type="submit"><span class="material-symbols-outlined">search</span>Filtrar</button></form></section>
<div class="capacity-alert" id="capacity-alert" role="alert" hidden><span class="material-symbols-outlined">error</span><span id="capacity-alert-message"></span></div>
<section class="table-panel"><div class="table-scroll"><table class="reservations-table"><thead><tr><th>Código</th><th>Cliente</th><th>Telefone</th><th>Passeio</th><th>Data</th><th>Horário</th><th>Pessoas</th><th>Status</th><th class="text-end">Ações</th></tr></thead><tbody>
@forelse($reservas as $reserva)
<tr data-reservation-row="{{ $reserva->id }}"><td class="code">{{ $reserva->codigo }}</td><td class="client-name">{{ $reserva->nome_cliente }}</td><td>{{ $reserva->telefone }}</td><td>{{ $reserva->saida->passeio->nome }}</td><td>{{ $reserva->saida->data->format('d/m/Y') }}</td><td>{{ substr($reserva->saida->horario,0,5) }}</td><td>{{ $reserva->pessoas }}</td><td><span class="status-pill {{ $reserva->status->value }}">{{ ucfirst($reserva->status->value) }}</span></td><td class="actions">
@if($reserva->status->value!=='cancelada')
  @if($reserva->status->value==='pendente')<button class="action-button confirm" data-action="confirmar" data-id="{{ $reserva->id }}">Confirmar</button>@endif
  <button class="action-button cancel" data-action="cancelar" data-id="{{ $reserva->id }}">Cancelar</button>
@else<span class="muted">—</span>@endif</td></tr>
@empty
<tr><td colspan="9"><div class="empty-table"><span class="material-symbols-outlined">search_off</span><strong>Nenhuma reserva encontrada.</strong><span>Nenhum resultado corresponde aos filtros selecionados.</span></div></td></tr>
@endforelse
</tbody></table></div>
<div class="table-footer"><span>Exibindo {{ $reservas->count() }} de {{ $reservas->total() }} reservas</span>{{ $reservas->links('pagination.reservas') }}</div></section>
@endsection
