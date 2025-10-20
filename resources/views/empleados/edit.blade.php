@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-header bg-warning text-white">
            <h3 class="mb-0">Editar Empleado: {{ $empleado->name }}</h3>
        </div>
        <div class="card-body">

            {{-- Manejo de Errores de Sesión (si hay rollback) --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('empleados.update', $empleado->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Sección de Datos de Usuario (users table) --}}
                <h5 class="mt-3 mb-3 text-warning">Datos de Acceso</h5>

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre Completo</label>
                    {{-- old() para persistencia, $empleado->name como valor por defecto --}}
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $empleado->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $empleado->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="cargo_id" class="form-label">Cargo (Rol)</label>
                    <select class="form-select @error('cargo_id') is-invalid @enderror" id="cargo_id" name="cargo_id" required>
                        <option value="">Seleccione un Cargo</option>
                        {{-- $cargos viene del EmpleadoController@edit --}}
                        @foreach ($cargos as $cargo)
                            <option value="{{ $cargo->id }}" {{ old('cargo_id', $empleado->cargo_id) == $cargo->id ? 'selected' : '' }}>
                                {{ $cargo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('cargo_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nueva Contraseña (Dejar vacío para no cambiar)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
                
                {{-- Sección de Datos de Empleado (empleados table) --}}
                <h5 class="mt-4 mb-3 text-warning">Información Adicional</h5>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    {{-- Usa el operador ?? para manejar el caso donde $empleado->empleado podría ser null --}}
                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $empleado->empleado->telefono ?? '') }}">
                    @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $empleado->empleado->direccion ?? '') }}">
                    @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-warning text-white">Actualizar Empleado</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection