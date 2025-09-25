<aside class="sidebar">
  <ul>
    @auth
      @role('cajero')
        {{-- Menú Cajero --}}
        @include('layouts.partials.menu.cajero')
      @endrole

      @role('gerente')
        {{-- Menú Gerente --}}
        @include('layouts.partials.menu.gerente')
      @endrole

      @role('administrador')
        {{-- Menú Admin --}}
        @include('layouts.partials.menu.admin')
      @endrole
    @endauth
  </ul>
</aside>


