@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Crear Nuevo Empleado</h3>
        </div>
        <div class="card-body">

            {{-- Manejo de Errores de Sesión (si hay rollback) --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('empleados.store') }}" method="POST">
                @csrf

                {{-- Sección de Datos de Usuario (users table) --}}
                <h5 class="mt-3 mb-3 text-primary">Datos de Acceso</h5>

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="cargo_id" class="form-label">Cargo (Rol)</label>
                    <select class="form-select @error('cargo_id') is-invalid @enderror" id="cargo_id" name="cargo_id" required>
                        <option value="">Seleccione un Cargo</option>
                        {{-- La variable $cargos debe ser pasada desde el EmpleadoController@create --}}
                        @foreach ($cargos as $cargo)
                            <option value="{{ $cargo->id }}" {{ old('cargo_id') == $cargo->id ? 'selected' : '' }}>
                                {{ $cargo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('cargo_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                
                {{-- Sección de Datos de Empleado (empleados table) --}}
                <h5 class="mt-4 mb-3 text-primary">Información Adicional</h5>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}">
                    @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion') }}">
                    @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar Empleado</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
