@if ($paginator->hasPages())
<nav aria-label="Paginação de reservas">
  <ul class="pagination">
    <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
      @if ($paginator->onFirstPage())
        <span class="page-link" aria-hidden="true">‹</span>
      @else
        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Página anterior">‹</a>
      @endif
    </li>
    @foreach ($elements as $element)
      @if (is_string($element))
        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
      @endif
      @if (is_array($element))
        @foreach ($element as $page => $url)
          <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
            @if ($page == $paginator->currentPage())
              <span class="page-link" aria-current="page">{{ $page }}</span>
            @else
              <a class="page-link" href="{{ $url }}" aria-label="Página {{ $page }}">{{ $page }}</a>
            @endif
          </li>
        @endforeach
      @endif
    @endforeach
    <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
      @if ($paginator->hasMorePages())
        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Próxima página">›</a>
      @else
        <span class="page-link" aria-hidden="true">›</span>
      @endif
    </li>
  </ul>
</nav>
@endif
