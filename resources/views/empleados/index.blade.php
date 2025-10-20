@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Empleados</h2>
        <a href="{{ route('empleados.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Crear Nuevo Empleado
        </a>
    </div>

    {{-- Manejo de Mensajes de Sesión (Éxito/Error) --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Cargo</th>
                    <th>Teléfono</th>
                    <th style="width: 250px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{-- Muestra el nombre del cargo si existe --}}
                        {{ $user->cargo ? $user->cargo->nombre : 'Sin Cargo' }}
                    </td>
                    <td>
                        {{-- Muestra el teléfono del empleado si existe el registro relacionado --}}
                        {{ $user->empleado ? $user->empleado->telefono : 'N/A' }}
                    </td>
                    <td>
                        {{-- Enlace para ver detalles (si tienes una vista show.blade.php) --}}
                        {{-- <a href="{{ route('empleados.show', $user->id) }}" class="btn btn-sm btn-info me-1" title="Ver Detalle">
                            <i class="fas fa-eye"></i>
                        </a> --}}
                        <a href="{{ route('empleados.edit', $user->id) }}" class="btn btn-sm btn-warning me-1" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        {{-- Protección: No permitir eliminar al Super Administrador (ID 1) ni al usuario actual --}}
                        @if ($user->id !== 1 && $user->id !== Auth::id())
                            <form action="{{ route('empleados.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a {{ $user->name }}? Esta acción es irreversible.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection