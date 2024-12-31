<nav class="d-inline-block">
    <ul class="pagination mb-0">
      <!-- halaman sebelumnya -->
      <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
        <a class="page-link" href="{{ $paginator->previousPageUrl() ?? 'javascript:void()' }}" tabindex="-1">
          <i class="fas fa-chevron-left"></i>
        </a>
      </li>

      <!-- nomor halaman -->
      @foreach ($elements as $element)
        @if (is_string($element))
          <li class="page-item disabled">
            <span class="page-link">{{ $element }}</span>
          </li>
        @endif

        @if (is_array($element))
          @foreach ($element as $page => $url)
            <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
              <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
          @endforeach
        @endif
      @endforeach

      <!-- halaman selanjutnya -->
      <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
        <a class="page-link" href="{{ $paginator->nextPageUrl() ?? 'javascript:void(0)' }}">
          <i class="fas fa-chevron-right"></i>
        </a>
      </li>
    </ul>
</nav>