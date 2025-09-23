@extends('layouts.app')

@section('title','Registro de actividad')

{{-- No cargamos DataTables aquí para evitar doble paginación --}}
{{-- @push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush --}}

@push('css')
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Registro de actividad</h1>

    <br>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Registro de actividad
        </div>
        <div class="card-body">
            {{-- Cambié el id y añadí la clase "table" para estilo Bootstrap --}}
            <table id="table-activity-logs" class="table table-striped fs-6">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Módulo</th>
                        <th>Ejecutado el</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activityLogs as $log)
                        <tr>
                            <td>{{ $log->user->name }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->module }}</td>
                            <td>{{ $log->created_at_formatted }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Sin datos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Paginación de Laravel (usa el parcial reusable) --}}
            @include('layouts.partials.paginator', ['paginator' => $activityLogs])
        </div>
    </div>
</div>
@endsection

@push('js')
    {{-- No cargamos DataTables en esta vista para evitar doble paginación --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script> --}}
@endpush
