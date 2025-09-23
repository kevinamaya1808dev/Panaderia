@extends('layouts.app')

@section('title','empleados')

{{-- No cargamos DataTables aquí para evitar doble paginación --}}
{{-- @push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush --}}

@push('css')
<style>
    .img { width: 80px; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Empleados</h1>

    <x-breadcrumb.template>
        <x-breadcrumb.item :href="route('panel')" content="Inicio" />
        <x-breadcrumb.item active='true' content="Empleados" />
    </x-breadcrumb.template>

    @can('crear-empleado')
    <div class="mb-4">
        <a href="{{ route('empleados.create') }}" class="btn btn-primary">
            Añadir nuevo registro
        </a>
    </div>
    @endcan

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla empleados
        </div>

        <div class="card-body">
            {{-- Cambié el id y aseguré clase "table" para estilos Bootstrap --}}
            <table id="table-empleados" class="table table-striped fs-6">
                <thead>
                    <tr>
                        <th>Nombres y Apellidos</th>
                        <th>Cargo</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($empleados as $item)
                    <tr>
                        <td>{{ $item->razon_social }}</td>
                        <td>{{ $item->cargo }}</td>

                        <td>
                            @if(!empty($item->imagen))
                                <img src="{{ asset($item->imagen) }}" alt="Foto" class="img img-thumbnail">
                            @elseif(!empty($item->foto))
                                <img src="{{ asset($item->foto) }}" alt="Foto" class="img img-thumbnail">
                            @else
                                <span class="text-muted">Sin imagen</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex justify-content-around">
                                {{-- Opciones --}}
                                <div class="dropdown">
                                    <button title="Opciones" class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu text-bg-light" style="font-size: small;">
                                        @can('editar-empleado')
                                        <li>
                                            <a class="dropdown-item" href="{{ route('empleados.edit', ['empleado' => $item]) }}">
                                                Editar
                                            </a>
                                        </li>
                                        @endcan
                                    </ul>
                                </div>

                                {{-- Separador --}}
                                <div class="vr"></div>

                                {{-- Eliminar --}}
                                @can('eliminar-empleado')
                                <button title="Eliminar"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmModal-{{ $item->id }}"
                                        class="btn btn-datatable btn-icon btn-transparent-dark">
                                    <i class="far fa-trash-can"></i>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>

                    {{-- Modal (nota: podría ir fuera de la tabla para HTML más limpio) --}}
                    <div class="modal fade" id="confirmModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Seguro que quieres eliminar el empleado?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('empleados.destroy', ['empleado' => $item->id]) }}" method="post">
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

            {{-- Paginación de Laravel (usa el parcial reusable o líneas directas) --}}
            @if ($empleados->count())
                <p class="text-muted small mb-2">
                    Mostrando {{ $empleados->firstItem() }}–{{ $empleados->lastItem() }} de {{ $empleados->total() }}
                </p>
            @endif
            <div class="d-flex justify-content-end">
                {{ $empleados->onEachSide(1)->links() }}
                {{-- O si prefieres el parcial:
                @include('layouts.partials.paginator', ['paginator' => $empleados]) --}}
            </div>
        </div>

        <div class="card-footer">
            <form action="{{ route('import.excel-empleados') }}"
                  method="post" enctype="multipart/form-data" class="mb-3">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Subir archivo:</label>
                    <input type="file" name="file" id="file" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Importar datos</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    {{-- SweetAlert va en JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- No cargamos DataTables para evitar doble paginación --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script> --}}
@endpush
