@extends('layouts.app')

@section('title','compras')

{{-- No cargamos DataTables aquí para evitar doble paginación --}}
{{-- @push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush --}}

@push('css')
<style>
    .row-not-space { width: 110px; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Compras</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Compras</li>
    </ol>

    @can('crear-compra')
    <div class="mb-4">
        <a href="{{ route('compras.create') }}" class="btn btn-primary">
            Añadir nuevo registro
        </a>
    </div>
    @endcan

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla compras
        </div>
        <div class="card-body">
            {{-- Cambié el id y aseguré la clase "table" para estilos Bootstrap --}}
            <table id="table-compras" class="table table-striped fs-6">
                <thead>
                    <tr>
                        <th>Comprobante</th>
                        <th>Proveedor</th>
                        <th>Fecha y hora</th>
                        <th>Usuario</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($compras as $item)
                    <tr>
                        <td>
                            <p class="fw-semibold mb-1">{{ $item->comprobante->nombre }}</p>
                            <p class="text-muted mb-0">{{ $item->numero_comprobante }}</p>
                        </td>
                        <td>
                            <p class="fw-semibold mb-1">{{ ucfirst($item->proveedore->persona->tipo->value) }}</p>
                            <p class="text-muted mb-0">{{ $item->proveedore->persona->razon_social }}</p>
                        </td>
                        <td>
                            <div class="row-not-space">
                                <p class="fw-semibold mb-1">
                                    <span class="m-1"><i class="fa-solid fa-calendar-days"></i></span>
                                    {{ $item->fecha }}
                                </p>
                                <p class="fw-semibold mb-0">
                                    <span class="m-1"><i class="fa-solid fa-clock"></i></span>
                                    {{ $item->hora }}
                                </p>
                            </div>
                        </td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->total }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Acciones">
                                @can('mostrar-compra')
                                <form action="{{ route('compras.show', ['compra' => $item]) }}" method="get">
                                    <button type="submit" class="btn btn-success">Ver</button>
                                </form>
                                @endcan

                                <button type="button" class="btn btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#verPDFModal-{{ $item->id }}">
                                    PDF
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="verPDFModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">PDF de la compra</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    @if ($item->comprobante_path)
                                        <iframe src="{{ asset($item->comprobante_path) }}"
                                                style="width: 100%; height:500px;" frameborder="0"></iframe>
                                    @else
                                        <p class="text-muted">No se ha cargado un comprobante</p>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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

            {{-- Paginación de Laravel (parcial reusable) --}}
            @include('layouts.partials.paginator', ['paginator' => $compras])
        </div>
    </div>
</div>
@endsection

@push('js')
    {{-- SweetAlert (scripts van en JS, no en CSS) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- No cargamos DataTables en esta vista para evitar doble paginación --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script> --}}
@endpush
