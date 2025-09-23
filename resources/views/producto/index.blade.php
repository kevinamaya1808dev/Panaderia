@extends('layouts.app')

@section('title','Productos')

{{-- NO cargar DataTables en esta vista --}}
{{-- @push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">
@endpush --}}

@push('css')
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Productos</h1>

    {{-- ... breadcrumb, botón "crear", etc. ... --}}

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i> Tabla productos
        </div>
        <div class="card-body">
            {{-- cambia el id para evitar que DataTables se auto-inicialice --}}
            <table id="table-productos" class="table table-striped fs-6">
                <thead>
                    <tr>
                        {{-- tus cabeceras actuales --}}
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Presentación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- deja tu foreach tal cual lo tienes hoy --}}
                    @forelse ($productos as $p)
                        <tr>
                            <td>{{ $p->nombre_completo }}</td>
                            <td>{{ $p->categoria?->caracteristica?->nombre }}</td>
                            <td>{{ $p->marca?->caracteristica?->nombre }}</td>
                            <td>{{ $p->presentacione?->caracteristica?->nombre }}</td>
                            <td>
                                <span class="badge rounded-pill {{ $p->estado ? 'text-bg-success' : 'text-bg-danger' }}">
                                    {{ $p->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                {{-- tus botones/menú de acciones actuales --}}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Sin datos</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Resumen + links de paginación (Laravel) --}}
            @if ($productos->count())
              <p class="text-muted small mb-2">
                Mostrando {{ $productos->firstItem() }}–{{ $productos->lastItem() }} de {{ $productos->total() }}
              </p>
            @endif
            <div class="d-flex justify-content-end">
                {{ $productos->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
{{-- NO cargar DataTables aquí para evitar doble paginación --}}
@endpush
