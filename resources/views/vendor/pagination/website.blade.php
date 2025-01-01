<div class="blog-pagination">
  <ul class="justify-content-end">
    <!-- halaman sebelumnya -->
    <li class="{{ $paginator->onFirstPage() ? 'disabled' : '' }}">
      <a class="" href="{{ $paginator->previousPageUrl() ?? 'javascript:void(0)' }}" tabindex="-1">
        <i class="bi bi-chevron-left"></i>
      </a>
    </li>

    <!-- nomor halaman -->
    @foreach ($elements as $element)
      @if (is_string($element))
        <li class="disabled">
          <a class="" href="javascript:void(0)">{{ $element }}</a>
        </li>
      @endif

      @if (is_array($element))
        @foreach ($element as $page => $url)
          <li class="{{ $page == $paginator->currentPage() ? 'active' : '' }}">
            <a class="" href="{{ $url }}">{{ $page }}</a>
          </li>
        @endforeach
      @endif
    @endforeach

    <!-- halaman selanjutnya -->
    <li class="{{ $paginator->hasMorePages() ? '' : 'disabled' }}">
      <a class="" href="{{ $paginator->nextPageUrl() ?? 'javascript:void(0)' }}">
        <i class="bi bi-chevron-right"></i>
      </a>
    </li>
  </ul>
</div>