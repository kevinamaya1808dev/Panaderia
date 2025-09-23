@extends('layouts.app')

@section('title','clientes')

{{-- No cargamos DataTables aquí para evitar doble paginación --}}
{{-- @push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush --}}

@push('css')
@endpush

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Clientes</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Clientes</li>
    </ol>

    @can('crear-cliente')
    <div class="mb-4">
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            Añadir nuevo registro
        </a>
    </div>
    @endcan

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla clientes
        </div>
        <div class="card-body">
            {{-- Cambié el id y aseguré clase "table" para estilos Bootstrap --}}
            <table id="table-clientes" class="table table-striped fs-6">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Documento</th>
                        <th>Tipo de persona</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $item)
                    <tr>
                        <td>{{ $item->persona->razon_social }}</td>
                        <td>{{ $item->persona->direccion }}</td>
                        <td>
                            <p class="fw-semibold mb-1">{{ $item->persona->documento->nombre }}</p>
                            <p class="text-muted mb-0">{{ $item->persona->numero_documento }}</p>
                        </td>
                        <td>{{ $item->persona->tipo->value }}</td>
                        <td>
                            <span class="badge rounded-pill text-bg-{{ $item->persona->estado ? 'success' : 'danger' }}">
                                {{ $item->persona->estado ? 'Activo' : 'Eliminado' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <div class="dropdown">
                                    <button title="Opciones" class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu text-bg-light" style="font-size: small;">
                                        @can('editar-cliente')
                                        <li>
                                            <a class="dropdown-item" href="{{ route('clientes.edit', ['cliente' => $item]) }}">
                                                Editar
                                            </a>
                                        </li>
                                        @endcan
                                    </ul>
                                </div>

                                <div class="vr"></div>

                                @can('eliminar-cliente')
                                    @if ($item->persona->estado == 1)
                                        <button title="Eliminar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $item->id }}"
                                                class="btn btn-datatable btn-icon btn-transparent-dark">
                                            <i class="far fa-trash-can"></i>
                                        </button>
                                    @else
                                        <button title="Restaurar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $item->id }}"
                                                class="btn btn-datatable btn-icon btn-transparent-dark">
                                            <i class="fa-solid fa-rotate"></i>
                                        </button>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>

                    <!-- Modal de confirmación -->
                    <div class="modal fade" id="confirmModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    {{ $item->persona->estado == 1
                                        ? '¿Seguro que quieres eliminar el cliente?'
                                        : '¿Seguro que quieres restaurar el cliente?' }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('clientes.destroy', ['cliente' => $item->persona->id]) }}" method="post">
                                        @method('DELETE') @csrf
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Sin datos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Resumen + links de paginación --}}
        @if ($clientes->count())
            <p class="text-muted small mb-2">
            Mostrando {{ $clientes->firstItem() ?? 1 }}–{{ $clientes->lastItem() ?? $clientes->count() }}
            de {{ method_exists($clientes, 'total') ? $clientes->total() : $clientes->count() }}
        </p>
        @endif
        <div class="d-flex justify-content-end">
            {{ $clientes->onEachSide(1)->links() }}
        </div>


            {{-- Paginación de Laravel (parcial reusable) --}}
            @include('layouts.partials.paginator', ['paginator' => $clientes])
        </div>
    </div>
</div>
@endsection

@push('js')
    {{-- SweetAlert (esto sí va en JS, no en CSS) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- No cargamos DataTables en esta vista para evitar doble paginación --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script> --}}
@endpush
