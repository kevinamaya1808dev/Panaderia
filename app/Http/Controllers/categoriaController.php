<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCaracteristicaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Caracteristica;
use App\Models\Categoria;
use App\Services\ActivityLogService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;                 // ← IMPORT correcto de Request
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class categoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-categoria|crear-categoria|editar-categoria|eliminar-categoria', ['only' => ['index']]);
        $this->middleware('permission:crear-categoria', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-categoria', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-categoria', ['only' => ['destroy']]);
    }

    /**
     * Listado con paginación.
     */
    public function index(): View
{
    $categorias = \App\Models\Categoria::with('caracteristica')
        ->latest()
        ->paginate(10);

    return view('categoria.index', compact('categorias'));
}

    /**
     * Formulario de creación.
     */
    public function create(): View
    {
        return view('categoria.create');
    }

    /**
     * Guardado de nueva categoría.
     */
    public function store(StoreCaracteristicaRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->categoria()->create([]);   // relación 1–1

            DB::commit();

            ActivityLogService::log('Creación de categoría', 'Categorías', $request->validated());
            return redirect()->route('categorias.index')->with('success', 'Categoría registrada');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error al crear la categoría', ['error' => $e->getMessage()]);
            return redirect()->route('categorias.index')->with('error', 'Ups, algo falló');
        }
    }

    /**
     * Mostrar (no usado por ahora).
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Formulario de edición.
     */
    public function edit(Categoria $categoria): View   // ← View con V mayúscula
    {
        return view('categoria.edit', compact('categoria'));
    }

    /**
     * Actualización.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        try {
            $categoria->caracteristica->update($request->validated());

            ActivityLogService::log('Edición de categoría', 'Categorías', $request->validated());
            return redirect()->route('categorias.index')->with('success', 'Categoría editada');
        } catch (Throwable $e) {
            Log::error('Error al editar la categoría', ['error' => $e->getMessage()]);
            return redirect()->route('categorias.index')->with('error', 'Ups, algo falló');
        }
    }

    /**
     * Activar/Desactivar (soft toggle) por estado de característica.
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $categoria = Categoria::findOrFail($id);

            $nuevoEstado = $categoria->caracteristica->estado == 1 ? 0 : 1;
            $categoria->caracteristica->update(['estado' => $nuevoEstado]);

            $message = $nuevoEstado == 1 ? 'Categoría restaurada' : 'Categoría eliminada';

            ActivityLogService::log($message, 'Categorías', [
                'categoria_id' => $id,
                'estado'       => $nuevoEstado,
            ]);

            return redirect()->route('categorias.index')->with('success', $message);
        } catch (Throwable $e) {
            Log::error('Error al eliminar/restaurar la categoría', ['error' => $e->getMessage()]);
            return redirect()->route('categorias.index')->with('error', 'Ups, algo falló');
        }
    }
}

