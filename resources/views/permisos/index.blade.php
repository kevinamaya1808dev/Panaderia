extends('layouts.app') {{-- Usa el layout principal de tu aplicación --}}

@section('content')

<div class="container-fluid py-4">
{{-- Títulos y Navegación --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Permisos para el Cargo: <span class="badge bg-primary">{{ $cargo->nombre }}</span></h1>
<a href="{{ route('cargos.index') }}" class="btn btn-sm btn-secondary shadow-sm">
<i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Cargos
</a>
</div>

{{-- Mostrar mensajes de sesión (success/error) --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Formulario para la matriz de permisos --}}
<div class="card shadow mb-4">
    <div class="card-body">
        
        {{-- El formulario enviará la data al método update del PermisoController --}}
        <form action="{{ route('cargos.permisos.update', $cargo) }}" method="POST">
            @csrf
            @method('PUT') {{-- Usamos PUT para actualizar el recurso --}}

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" id="permisosTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-start">Módulo</th>
                            <th>Mostrar (Ver Lista)</th>
                            <th>Detalle (Ver Ítem)</th>
                            <th>Alta (Crear)</th>
                            <th>Editar (Modificar)</th>
                            <th>Eliminar (Borrar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Recorremos todos los módulos disponibles --}}
                        @foreach ($modulos as $modulo)
                        <tr>
                            <td class="text-start align-middle fw-bold">{{ $modulo->nombre }}</td>
                            
                            {{-- Obtenemos el permiso actual para este módulo y cargo --}}
                            @php
                                $permiso = $permisosActuales->get($modulo->id);
                            @endphp

                            {{-- Definición de Checkboxes --}}
                            @foreach (['mostrar', 'detalle', 'alta', 'editar', 'eliminar'] as $accion)
                            <td class="align-middle">
                                <div class="form-check d-flex justify-content-center">
                                    {{-- 
                                        El nombre del input es un array asociativo: name="accion[modulo_id]"
                                        Si está en la DB como 1, marcamos el checkbox como 'checked'.
                                    --}}
                                    <input 
                                        type="checkbox" 
                                        class="form-check-input" 
                                        name="{{ $accion }}[{{ $modulo->id }}]" 
                                        value="1" 
                                        id="{{ $accion }}_{{ $modulo->id }}"
                                        {{ $permiso && $permiso->$accion ? 'checked' : '' }}
                                    >
                                </div>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-save"></i> Guardar Permisos
                </button>
            </div>
        </form>

    </div>
</div>


</div>
@endsection