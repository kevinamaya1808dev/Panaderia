{{-- resources/views/layouts/partials/menu/cajero.blade.php --}}

{{-- POS (permiso propio "abrir-pos") --}}
@can('abrir-pos')
  <x-nav.link :href="route('pos')" icon="fa-solid fa-cash-register" content="POS" />
@endcan

{{-- MÓDULOS --}}
@can('ver-kardex')
  <x-nav.link :href="route('kardex.index')" icon="fa-solid fa-box-archive" content="Kardex" />
@endcan

@can('ver-caja')
  <x-nav.link :href="route('cajas.index')" icon="fa-solid fa-vault" content="Cajas" />
@endcan

{{-- Ventas: solo "Ver" (no mostramos "Crear") --}}
@can('ver-venta')
  <x-nav.link :href="route('ventas.index')" icon="fa-solid fa-receipt" content="Ventas" />
@endcan


