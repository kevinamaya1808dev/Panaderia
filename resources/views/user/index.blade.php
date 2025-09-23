@extends('layouts.app')

@section('title','usuarios')

{{-- Si vas a usar paginación de Laravel, NO cargues DataTables aquí --}}
{{-- @push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush --}}

{{-- Este stack es de CSS; no metas <script> aquí --}}
@push('css')
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Usuarios</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Usuarios</li>
    </ol>

    {{-- Botón "Añadir" solo para administrador (o usa @can si ya creaste esos permisos finos) --}}
    @hasrole('administrador')
    <div class="mb-4">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            Añadir nuevo usuario
        </a>
    </div>
    @endhasrole

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla de usuarios
        </div>

        <div class="card-body">
            {{-- Cambié el id para no inicializar DataTables por accidente --}}
            <table id="table-users" class="table table-striped fs-6">
                <thead>
                    <tr>
                        <th>Empleado</th>
                        <th>Alias</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $item)
                    <tr>
                        {{-- Empleado (null-safe con fallback) --}}
                        <td>
                            {{
                                $item->empleado?->persona?->razon_social
                                ?? $item->empleado?->persona?->nombre
                                ?? $item->empleado?->nombres
                                ?? $item->name
                            }}
                        </td>

                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->getRoleNames()->implode(', ') }}</td>

                        {{-- Estado (solo una vez) --}}
                        <td>
                            <span class="badge rounded-pill {{ $item->estado ? 'text-bg-success' : 'text-bg-danger' }}">
                                {{ $item->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>

                        {{-- Acciones --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                {{-- Dropdown de opciones --}}
                                @hasrole('administrador')
                                <div class="dropdown">
                                    <button title="Opciones" class="btn btn-datatable btn-icon btn-transparent-dark"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end text-bg-light" style="font-size: small;">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('users.edit', ['user' => $item]) }}">
                                                Editar
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="vr"></div>

                                {{-- Eliminar / Restaurar --}}
                                @if ($item->estado == 1)
                                    <button title="Eliminar" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal-{{ $item->id }}"
                                            class="btn btn-datatable btn-icon btn-transparent-dark">
                                        <i class="far fa-trash-can"></i>
                                    </button>
                                @else
                                    <button title="Restaurar" data-bs-toggle="modal"
                                            data-bs-target="#confirmModal-{{ $item->id }}"
                                            class="btn btn-datatable btn-icon btn-transparent-dark">
                                        <i class="fa-solid fa-rotate"></i>
                                    </button>
                                @endif
                                @endhasrole
                            </div>
                        </td>
                    </tr>

                    {{-- Modal de confirmación (uno por fila) --}}
                    @hasrole('administrador')
                    <div class="modal fade" id="confirmModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    {{ $item->estado == 1 ? '¿Seguro que quieres desactivar el usuario?' : '¿Seguro que quieres restaurar el usuario?' }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('users.destroy', ['user' => $item->id]) }}" method="POST">
                                        @method('DELETE') @csrf
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endhasrole
                    @endforeach
                </tbody>
            </table>

            {{-- Resumen y links de paginación (Laravel) --}}
            @if ($users->count())
                <p class="text-muted small mb-2">
                    Mostrando {{ $users->firstItem() }}–{{ $users->lastItem() }} de {{ $users->total() }} usuarios
                </p>
            @endif
            <div class="d-flex justify-content-end">
                {{ $users->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    {{-- Mueve SweetAlert al stack de JS (aquí sí va) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- No inicializamos DataTables en esta vista para evitar doble paginación --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script> --}}
@endpush
