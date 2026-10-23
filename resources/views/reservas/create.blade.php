@extends('layouts.app')
@section('title','Nova reserva')
@section('content')
<div class="page-heading create-heading"><div><div class="breadcrumb"><a href="{{ route('reservas.index') }}">Reservas</a><span>›</span>Nova reserva</div><h1>Nova reserva</h1><p>Cadastro de nova reserva e alocação imediata de vagas</p></div></div>
<section class="form-panel"><form id="reservationForm">
<div class="field date-field"><label for="tour-date">Data do passeio <span class="required">*</span></label><input id="tour-date" type="date" value="{{ $data }}" required><small>Selecione o dia do embarque para consultar o quadro de vagas</small></div>
<hr><div class="section-label"><label>Saída disponível <span class="required">*</span></label><span id="departure-count">{{ $saidas->count() }} saídas programadas</span></div>
<div class="departure-options" id="departure-options" role="radiogroup" aria-label="Saídas disponíveis">
@forelse($saidas as $saida)
@php $pct=$saida->vagas_total?round($saida->vagas_ocupadas/$saida->vagas_total*100):0; @endphp
<label class="departure-option {{ $loop->first && $saida->vagas_restantes>0?'selected':'' }} {{ $saida->vagas_restantes===0?'sold-out':'' }}">
<input type="radio" name="saida_id" value="{{ $saida->id }}" data-name="{{ $saida->passeio->nome }}" data-time="{{ substr($saida->horario,0,5) }}" data-remaining="{{ $saida->vagas_restantes }}" @checked($loop->first && $saida->vagas_restantes>0) @disabled($saida->vagas_restantes===0)>
<span class="option-top"><strong><span class="material-symbols-outlined">sailing</span>{{ $saida->passeio->nome }}</strong><span class="availability {{ $saida->vagas_restantes===0?'full':($pct>=70?'limited':'available') }}">{{ $saida->vagas_restantes===0?'0 vagas · ESGOTADO':$saida->vagas_restantes.' vagas restantes' }}</span></span>
<span class="option-bottom"><span><span class="material-symbols-outlined">schedule</span>{{ substr($saida->horario,0,5) }}</span><span class="selection-label">{{ $saida->vagas_restantes===0?'Sem vagas':($loop->first?'Selecionado':'Disponível') }}</span></span>
</label>
@empty
<div class="empty-options">Nenhuma saída programada para esta data.</div>
@endforelse
</div>
<div class="selection-banner" id="selection-banner" @if(!$saidas->contains(fn($s)=>$s->vagas_restantes>0)) hidden @endif><span class="material-symbols-outlined">info</span><span>Saída selecionada: <strong id="selected-summary"></strong><span class="banner-separator">·</span>Capacidade restante: <strong id="remaining-summary"></strong></span></div>
<hr><h2 class="form-section-title">Dados do Passageiro Principal</h2>
<div class="customer-fields"><div class="field"><label for="customer-name">Nome do cliente <span class="required">*</span></label><input id="customer-name" name="nome_cliente" required maxlength="160" placeholder="Ex: Maria Fernanda Souza"></div>
<div class="field"><label for="customer-phone">Telefone (WhatsApp) <span class="required">*</span></label><input id="customer-phone" name="telefone" required maxlength="30" inputmode="tel" placeholder="(81) 98765-4321"></div>
<div class="field"><label for="people-count">Número de pessoas <span class="required">*</span></label><input id="people-count" name="pessoas" required type="number" min="1" max="15" value="1"><small id="seats-help">Selecione uma saída disponível</small></div></div>
<div class="form-actions"><p><span class="material-symbols-outlined">lock_clock</span>A reserva será criada com status <strong>Pendente</strong>; vagas só são consumidas após confirmação.</p><div><a class="button button-outline" href="{{ route('reservas.index') }}">Cancelar</a><button class="button button-primary" id="submit-booking" type="submit" disabled><span class="material-symbols-outlined">check_circle</span>Salvar reserva</button></div></div>
</form></section>
@endsection
