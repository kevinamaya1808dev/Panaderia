@extends('layouts.app')

@section('title','categorías')

{{-- Como usaremos paginación de Laravel, no cargamos DataTables aquí --}}
{{-- @push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush --}}

@push('css')
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Categorías</h1>

    <x-breadcrumb.template>
        <x-breadcrumb.item :href="route('panel')" content="Inicio" />
        <x-breadcrumb.item active='true' content="Categorías" />
    </x-breadcrumb.template>

    @can('crear-categoria')
    <div class="mb-4">
        <a href="{{ route('categorias.create') }}" class="btn btn-primary">
            Añadir nuevo registro
        </a>
    </div>
    @endcan

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla categorías
        </div>

        <div class="card-body">
            {{-- Cambié el id para no inicializar DataTables por accidente --}}
            <table id="table-categorias" class="table table-striped fs-6">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->caracteristica->nombre }}</td>
                            <td>{{ $categoria->caracteristica->descripcion }}</td>
                            <td>
                                <span class="badge rounded-pill text-bg-{{ $categoria->caracteristica->estado ? 'success' : 'danger' }}">
                                    {{ $categoria->caracteristica->estado ? 'Activo' : 'Eliminado' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-around">
                                    <div class="dropdown">
                                        <button title="Opciones"
                                                class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu text-bg-light" style="font-size: small;">
                                            @can('editar-categoria')
                                            <li>
                                                <a class="dropdown-item"
                                                   href="{{ route('categorias.edit', ['categoria' => $categoria]) }}">
                                                   Editar
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>

                                    <div class="vr"></div>

                                    @can('eliminar-categoria')
                                        @if ($categoria->caracteristica->estado == 1)
                                            <button title="Eliminar"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $categoria->id }}"
                                                    class="btn btn-datatable btn-icon btn-transparent-dark">
                                                <i class="far fa-trash-can"></i>
                                            </button>
                                        @else
                                            <button title="Restaurar"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $categoria->id }}"
                                                    class="btn btn-datatable btn-icon btn-transparent-dark">
                                                <i class="fa-solid fa-rotate"></i>
                                            </button>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de confirmación (mejor fuera de <table>, pero funciona así) --}}
                        <div class="modal fade" id="confirmModal-{{ $categoria->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Mensaje de confirmación</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $categoria->caracteristica->estado == 1
                                            ? '¿Seguro que quieres eliminar la categoría?'
                                            : '¿Seguro que quieres restaurar la categoría?' }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <form action="{{ route('categorias.destroy', ['categoria' => $categoria->id]) }}" method="POST">
                                            @method('DELETE') @csrf
                                            <button type="submit" class="btn btn-danger">Confirmar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Sin datos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Resumen + links de paginación (Laravel) --}}
            @if ($categorias->count())
                <p class="text-muted small mb-2">
                    Mostrando {{ $categorias->firstItem() }}–{{ $categorias->lastItem() }} de {{ $categorias->total() }}
                </p>
            @endif
            <div class="d-flex justify-content-end">
                {{ $categorias->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    {{-- No cargamos DataTables aquí para evitar doble paginación --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script> --}}
@endpush
