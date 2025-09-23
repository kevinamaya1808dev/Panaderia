@extends('layouts.app')

@section('title','Inventario')

{{-- No usamos DataTables aquí --}}
@push('css')
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Inventario</h1>

    <x-breadcrumb.template>
        <x-breadcrumb.item :href="route('panel')" content="Inicio" />
        <x-breadcrumb.item active='true' content="Inventario" />
    </x-breadcrumb.template>

    <div class="mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verPlanoModal">
            Ver plano
        </button>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla inventario
        </div>
        <div class="card-body">
            {{-- cambia el id para evitar que se inicialice DataTables por accidente --}}
            <table id="table-inventario" class="table table-striped fs-6">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Stock</th>
                        <th>Ubicación</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inventario as $item)
                        <tr>
                            <td>{{ $item->producto->nombre_completo }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>{{ $item->ubicacione->nombre }}</td>
                            <td>{{ $item->fecha_vencimiento_format ?? $item->fecha_vencimiento_format }}</td>
                            <td>
                                {{-- Aquí puedes poner botones si quieres (Ver/Editar, etc.) --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Sin datos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($inventario->count())
                <p class="text-muted small mb-2">
                    Mostrando {{ $inventario->firstItem() }}–{{ $inventario->lastItem() }} de {{ $inventario->total() }}
                </p>
            @endif
            <div class="d-flex justify-content-end">
                {{ $inventario->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

    {{-- Modal plano --}}
    <div class="modal fade" id="verPlanoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Plano de Ubicaciones</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="{{ asset('assets/img/plano.png')}}" class="img-fluid img-thumbail border rounded" alt="Plano de ubicaciones">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
{{-- No cargar DataTables aquí --}}
@endpush
