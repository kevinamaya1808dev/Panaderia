{{-- resources/views/layouts/partials/menu/admin.blade.php --}}

@can('abrir-pos')
  <x-nav.link :href="route('pos')" icon="fa-solid fa-cash-register" content="POS" />
@endcan

<x-nav.link :href="route('compras.index')" icon="fa-solid fa-cart-flatbed" content="Compras" />
<x-nav.link :href="route('proveedores.index')" icon="fa-solid fa-truck-field" content="Proveedores" />
<x-nav.link :href="route('categorias.index')" icon="fa-solid fa-tag" content="Categorías" />
<x-nav.link :href="route('presentaciones.index')" icon="fa-solid fa-box-archive" content="Presentaciones" />
<x-nav.link :href="route('productos.index')" icon="fa-brands fa-shopify" content="Productos" />
<x-nav.link :href="route('inventario.index')" icon="fa-solid fa-warehouse" content="Inventario" />
<x-nav.link :href="route('kardex.index')" icon="fa-solid fa-file" content="Kardex" />
<x-nav.link :href="route('users.index')" icon="fa-solid fa-user" content="Usuarios" />
<x-nav.link :href="route('roles.index')" icon="fa-solid fa-person-circle-plus" content="Roles" />
<x-nav.link :href="route('empresa.index')" icon="fa-solid fa-city" content="Empresa" />
<x-nav.link :href="route('cajas.index')" icon="fa-solid fa-vault" content="Cajas" />
{{-- OJO: movimientos.index suele requerir caja_id; si te da error, quita esta línea o enlaza desde Cajas --}}
<x-nav.link :href="route('movimientos.index')" icon="fa-solid fa-right-left" content="Movimientos" />
