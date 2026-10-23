@extends('layouts.app')
@section('title', 'Dashboard do dia')
@section('content')
<div class="page-heading">
  <div><h1>Dashboard do dia</h1><p>Visão operacional de saídas, ocupação e vagas em tempo real</p></div>
  <form method="get" class="date-control"><label for="dashboard-date" class="visually-hidden">Data das saídas</label><span class="material-symbols-outlined">calendar_today</span><input id="dashboard-date" type="date" name="data" value="{{ $data }}" onchange="this.form.submit()"></form>
</div>
@if($saidas->isEmpty())
  <section class="empty-state"><span class="material-symbols-outlined">sailing</span><h2>Nenhuma saída programada</h2><p>Não há passeios cadastrados para esta data.</p></section>
@else
<section class="departure-grid" aria-label="Saídas do dia">
@foreach($saidas as $saida)
  @php
    $used=$saida->vagas_ocupadas; $remaining=$saida->vagas_restantes; $pct=$saida->vagas_total ? min(100, round($used/$saida->vagas_total*100)) : 0;
    $tone=$pct>=100?'danger':($pct>=70?'warning':'success');
    $confirmed=$saida->reservas->filter(fn($r) => $r->status->value === 'confirmada')->sum('pessoas'); $pending=$saida->reservas->filter(fn($r) => $r->status->value === 'pendente')->count();
    $pendingPax=$saida->reservas->filter(fn($r) => $r->status->value === 'pendente')->sum('pessoas');
  @endphp
  <article class="departure-card">
    <div class="card-title-row"><div><h2>{{ $saida->passeio->nome }}</h2><p>Capacidade total: {{ $saida->vagas_total }} pessoas</p></div><span class="time-chip"><span class="material-symbols-outlined">schedule</span>{{ substr($saida->horario,0,5) }}</span></div>
    <div class="capacity-meta"><span>{{ $used }}/{{ $saida->vagas_total }} vagas ocupadas</span><strong class="text-{{ $tone }}">{{ $pct }}%</strong></div>
    <div class="capacity-track" role="progressbar" aria-label="Ocupação de {{ $saida->passeio->nome }}" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"><span class="fill {{ $tone }}" style="width:{{ $pct }}%"></span></div>
    <div class="remaining {{ $tone }}"><span><span class="material-symbols-outlined">{{ $tone==='danger'?'block':($tone==='warning'?'info':'check') }}</span>Vagas restantes</span><strong>{{ $remaining }} {{ $remaining===1?'vaga':'vagas' }} restantes{{ $remaining===0?' (LOTADO)':'' }}</strong></div>
    <footer class="departure-footer"><div class="status-counts"><span class="mini-badge confirmed">⊙ Confirmadas: {{ $confirmed }}</span><span class="mini-badge {{ $pending?'pending':'neutral' }}">⊙ Pendentes: {{ $pending }}</span></div>@if($pending)<span class="reservation-note" title="{{ $pending }} reservas pendentes de {{ $pendingPax }} pessoas">{{ $pending }} res. ({{ $pendingPax }}p)</span>@endif</footer>
  </article>
@endforeach
</section>
@endif
@endsection
