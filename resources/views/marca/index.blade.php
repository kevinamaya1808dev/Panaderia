@extends('layouts.app')

@section('title','Marcas')

{{-- NO cargar DataTables en esta vista --}}
{{-- @push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">
@endpush --}}

@push('css')
@endpush

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4 text-center">Marcas</h1>

  <x-breadcrumb.template>
    <x-breadcrumb.item :href="route('panel')" content="Inicio" />
    <x-breadcrumb.item active='true' content="Marcas" />
  </x-breadcrumb.template>

  @can('crear-marca')
  <div class="mb-4">
    <a href="{{ route('marcas.create') }}" class="btn btn-primary">Añadir nuevo registro</a>
  </div>
  @endcan

  <div class="card">
    <div class="card-header">
      <i class="fas fa-table me-1"></i> Tabla marcas
    </div>
    <div class="card-body">
      <table id="table-marcas" class="table table-striped fs-6">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($marcas as $marca)
          <tr>
            <td>{{ $marca->caracteristica->nombre }}</td>
            <td>{{ $marca->caracteristica->descripcion }}</td>
            <td>
              <span class="badge rounded-pill text-bg-{{ $marca->caracteristica->estado ? 'success' : 'danger' }}">
                {{ $marca->caracteristica->estado ? 'Activo' : 'Eliminado' }}
              </span>
            </td>
            <td>
              <div class="d-flex justify-content-around">
                <div class="dropdown">
                  <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-vertical"></i>
                  </button>
                  <ul class="dropdown-menu text-bg-light" style="font-size: small;">
                    @can('editar-marca')
                      <li><a class="dropdown-item" href="{{ route('marcas.edit', $marca) }}">Editar</a></li>
                    @endcan
                  </ul>
                </div>
                <div class="vr"></div>
                @can('eliminar-marca')
                  <button class="btn btn-datatable btn-icon btn-transparent-dark"
                          data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $marca->id }}">
                    <i class="{{ $marca->caracteristica->estado ? 'far fa-trash-can' : 'fa-solid fa-rotate' }}"></i>
                  </button>
                @endcan
              </div>
            </td>
          </tr>

          {{-- Modal de confirmación --}}
          <div class="modal fade" id="confirmModal-{{ $marca->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog"><div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">Mensaje de confirmación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                {{ $marca->caracteristica->estado ? '¿Seguro que quieres eliminar la marca?' : '¿Seguro que quieres restaurar la marca?' }}
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <form action="{{ route('marcas.destroy', $marca->id) }}" method="POST">
                  @method('DELETE') @csrf
                  <button type="submit" class="btn btn-danger">Confirmar</button>
                </form>
              </div>
            </div></div>
          </div>
          @empty
          <tr><td colspan="4" class="text-center text-muted">Sin datos</td></tr>
          @endforelse
        </tbody>
      </table>

      @if ($marcas->count())
        <p class="text-muted small mb-2">
          Mostrando {{ $marcas->firstItem() }}–{{ $marcas->lastItem() }} de {{ $marcas->total() }}
        </p>
      @endif
      <div class="d-flex justify-content-end">
        {{ $marcas->onEachSide(1)->links() }}
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
{{-- NO cargues DataTables aquí --}}
@endpush
