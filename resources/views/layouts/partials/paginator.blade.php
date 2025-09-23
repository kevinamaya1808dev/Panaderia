@php($p = $paginator ?? null)

@if($p instanceof \Illuminate\Contracts\Pagination\Paginator && $p->hasPages())
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 mt-3">
    @if(method_exists($p, 'firstItem'))
      <p class="text-muted small mb-0">
        Mostrando {{ $p->firstItem() }}–{{ $p->lastItem() }} de {{ $p->total() }}
      </p>
    @endif
    <div class="ms-sm-auto">
      {{ $p->onEachSide(1)->links() }}
    </div>
  </div>
@endif
