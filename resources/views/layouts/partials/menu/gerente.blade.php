{{-- resources/views/layouts/partials/menu/gerente.blade.php --}}

{{-- POS --}}
@can('abrir-pos')
  <x-nav.link :href="route('pos')" icon="fa-solid fa-cash-register" content="POS" />
@endcan

{{-- Módulos que sí debe ver Gerente --}}
@can('ver-producto')
  <x-nav.link :href="route('productos.index')" icon="fa-solid fa-boxes-stacked" content="Productos" />
@endcan

@can('ver-inventario')
  <x-nav.link :href="route('inventario.index')" icon="fa-solid fa-warehouse" content="Inventario" />
@endcan

@can('ver-kardex')
  <x-nav.link :href="route('kardex.index')" icon="fa-solid fa-box-archive" content="Kardex" />
@endcan

@can('ver-cliente')
  <x-nav.link :href="route('clientes.index')" icon="fa-solid fa-users" content="Clientes" />
@endcan

@can('ver-caja')
  <x-nav.link :href="route('cajas.index')" icon="fa-solid fa-vault" content="Cajas" />
@endcan

@can('ver-compra')
  <x-nav.link :href="route('compras.index')" icon="fa-solid fa-cart-flatbed" content="Compras" />
@endcan

{{-- Ventas: solo "Ver" --}}
@can('ver-venta')
  <x-nav.link :href="route('ventas.index')" icon="fa-solid fa-cart-shopping" content="Ventas" />
@endcan


