<aside class="sidebar">
  <ul>
    @auth
      @role('cajero') @include('partials.menu.cajero') @endrole
      @role('admin')  @include('partials.menu.admin')  @endrole
    @endauth

    @auth
  @role('cajero') @include('layouts.partials.menu.cajero') @endrole
  @role('admin')  @include('layouts.partials.menu.admin')  @endrole
@endauth

  </ul>
</aside>
