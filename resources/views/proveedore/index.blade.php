@extends('layouts.app')

@section('title','proveedores')

@push('css')
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Proveedores</h1>

    <x-breadcrumb.template>
        <x-breadcrumb.item :href="route('panel')" content="Inicio" />
        <x-breadcrumb.item active='true' content="Proveedores" />
    </x-breadcrumb.template>

    @can('crear-proveedore')
    <div class="mb-4">
        <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
            Añadir nuevo registro
        </a>
    </div>
    @endcan

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla proveedores
        </div>

        <div class="card-body">
            <table id="table-proveedores" class="table table-striped fs-6">
                <thead>
                    <tr>
                        <th>Nombre / Razón social</th>
                        <th>Documento</th>
                        <th>Dirección</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($proveedores as $item)
                        <tr>
                            <td>{{ $item->persona->razon_social }}</td>

                            <td>
                                <p class="fw-semibold mb-1">{{ $item->persona->documento->nombre ?? '—' }}</p>
                                <p class="text-muted mb-0">{{ $item->persona->numero_documento ?? '—' }}</p>
                            </td>

                            <td>{{ $item->persona->direccion ?? '—' }}</td>

                            <td>
                                <span class="badge rounded-pill text-bg-{{ $item->persona->estado ? 'success' : 'danger' }}">
                                    {{ $item->persona->estado ? 'Activo' : 'Eliminado' }}
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
                                            @can('editar-proveedore')
                                            <li>
                                                <a class="dropdown-item"
                                                   href="{{ route('proveedores.edit', ['proveedore' => $item->id]) }}">
                                                   Editar
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>

                                    <div class="vr"></div>

                                    @can('eliminar-proveedore')
                                        <button title="{{ $item->persona->estado ? 'Eliminar' : 'Restaurar' }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $item->id }}"
                                                class="btn btn-datatable btn-icon btn-transparent-dark">
                                            @if ($item->persona->estado)
                                                <i class="far fa-trash-can"></i>
                                            @else
                                                <i class="fa-solid fa-rotate"></i>
                                            @endif
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de confirmación --}}
                        <div class="modal fade" id="confirmModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Mensaje de confirmación</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $item->persona->estado ? '¿Seguro que quieres eliminar el proveedor?' : '¿Seguro que quieres restaurar el proveedor?' }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <form action="{{ route('proveedores.destroy', ['proveedore' => $item->id]) }}"
                                              method="post">
                                            @method('DELETE') @csrf
                                            <button type="submit" class="btn btn-danger">Confirmar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Sin datos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Resumen + links de paginación (Laravel) --}}
            @if ($proveedores->count())
                <p class="text-muted small mb-2">
                    Mostrando {{ $proveedores->firstItem() ?? 1 }}–{{ $proveedores->lastItem() ?? $proveedores->count() }}
                    de {{ method_exists($proveedores, 'total') ? $proveedores->total() : $proveedores->count() }}
                </p>
            @endif
            <div class="d-flex justify-content-end">
                {{ $proveedores->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    {{-- No cargamos DataTables aquí para evitar doble paginación --}}
@endpush
