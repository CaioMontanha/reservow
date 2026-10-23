<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'RESERVOW') · RESERVOW</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo-montanha.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}?v=11" rel="stylesheet">
  <link href="{{ asset('css/capacity.css') }}?v=4" rel="stylesheet">
  @stack('head')
</head>
<body>
<header class="topbar">
  <a class="header-logo" href="{{ route('dashboard') }}" aria-label="Reservow — início"><img src="{{ asset('images/logo-montanha.png') }}" alt="Logo Montanha"></a>
  <a class="brand" href="{{ route('dashboard') }}">RESERVOW</a>
  <nav class="main-nav" id="primary-navigation" aria-label="Navegação principal">
    <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
    <a class="{{ request()->routeIs('reservas.*') ? 'active' : '' }}" href="{{ route('reservas.index') }}">Reservas</a>
    <a href="https://caio-montanha.vercel.app/" target="_blank" rel="noopener noreferrer">Portfólio</a>
  </nav>
  <a class="button button-primary new-booking" href="{{ route('reservas.create') }}">+ Nova reserva</a>
  <div class="header-tools" aria-label="Ações da conta">
    <a class="header-icon" href="{{ route('reservas.index', ['status' => 'pendente']) }}" aria-label="Ver reservas pendentes" title="Reservas pendentes"><span class="material-symbols-outlined" aria-hidden="true">notifications</span></a>
    <button class="header-icon" type="button" data-account-info aria-label="Informações da conta" title="Informações da conta"><span class="material-symbols-outlined" aria-hidden="true">account_circle</span></button>
  </div>
  <button class="mobile-menu" type="button" aria-label="Abrir menu" aria-controls="primary-navigation" aria-expanded="false"><span class="material-symbols-outlined" aria-hidden="true">menu</span></button>
</header>
<main class="page-shell">@yield('content')</main>
<a class="portfolio-fab" href="https://caio-montanha.vercel.app/" target="_blank" rel="noopener noreferrer" aria-label="Portfólio Montanha" title="Portfólio Montanha">
  <img src="{{ asset('images/logo-montanha.png') }}" alt="">
  <span>Portfólio Montanha</span>
</a>
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastArea" aria-live="polite"></div>
<script src="{{ asset('js/app.js') }}" defer></script>
@stack('scripts')
</body></html>
