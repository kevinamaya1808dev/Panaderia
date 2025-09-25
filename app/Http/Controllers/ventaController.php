<?php

namespace App\Http\Controllers;

use App\Enums\MetodoPagoEnum;
use App\Events\CreateVentaDetalleEvent;
use App\Events\CreateVentaEvent;
use App\Http\Requests\StoreVentaRequest;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Venta;
use App\Services\ActivityLogService;
use App\Services\ComprobanteService;
use App\Services\EmpresaService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ventaController extends Controller
{
    protected EmpresaService $empresaService;

    public function __construct(EmpresaService $empresaService)
    {
        // Listado
        $this->middleware('permission:ver-venta|crear-venta|mostrar-venta|eliminar-venta', ['only' => ['index']]);

        // Crear/guardar
        $this->middleware('permission:crear-venta', ['only' => ['create', 'store']]);

        // Ver detalle (si no tienes 'mostrar-venta', usa 'ver-venta' aquí)
        $this->middleware('permission:mostrar-venta', ['only' => ['show']]);

        // Caja aperturada para flujos de venta y POS
        $this->middleware('check-caja-aperturada-user')->only(['create', 'store', 'pos']);

        // POS con permiso dedicado
        $this->middleware('permission:abrir-pos')->only(['pos']);

        // Ver detalle propio
        $this->middleware('check-show-venta-user')->only(['show']);

        $this->empresaService = $empresaService;
    }

    /**
     * Listado de ventas
     */
    public function index(): View
    {
        $query = Venta::with([
            'comprobante',
            'cliente.persona.documento',
            'user',
        ]);

        // Si NO es admin, filtrar por usuario autenticado
        if (!auth()->user()->hasRole('administrador')) {
            $query->where('user_id', Auth::id());
        }

        $ventas = $query->latest()->paginate(10);

        return view('venta.index', compact('ventas'));
    }

    /**
     * POS: pantalla de venta sin exigir 'crear-venta'
     */
    public function pos(ComprobanteService $comprobanteService): View
    {
        // Reutilizamos exactamente la misma data que create()
        $productos = Producto::join('inventario as i', function ($join) {
                $join->on('i.producto_id', '=', 'productos.id');
            })
            ->join('presentaciones as p', function ($join) {
                $join->on('p.id', '=', 'productos.presentacione_id');
            })
            ->select(
                'p.sigla',
                'productos.nombre',
                'productos.codigo',
                'productos.id',
                'i.cantidad',
                'productos.precio'
            )
            ->where('productos.estado', 1)
            ->where('i.cantidad', '>', 0)
            ->get();

        $clientes = Cliente::whereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();

        $comprobantes      = $comprobanteService->obtenerComprobantes();
        $optionsMetodoPago = MetodoPagoEnum::cases();
        $empresa           = $this->empresaService->obtenerEmpresa();

        return view('venta.create', compact(
            'productos',
            'clientes',
            'comprobantes',
            'optionsMetodoPago',
            'empresa'
        ));
    }

    /**
     * Form de crear venta (flujo clásico)
     */
    public function create(ComprobanteService $comprobanteService): View
    {
        $productos = Producto::join('inventario as i', function ($join) {
                $join->on('i.producto_id', '=', 'productos.id');
            })
            ->join('presentaciones as p', function ($join) {
                $join->on('p.id', '=', 'productos.presentacione_id');
            })
            ->select(
                'p.sigla',
                'productos.nombre',
                'productos.codigo',
                'productos.id',
                'i.cantidad',
                'productos.precio'
            )
            ->where('productos.estado', 1)
            ->where('i.cantidad', '>', 0)
            ->get();

        $clientes = Cliente::whereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();

        $comprobantes      = $comprobanteService->obtenerComprobantes();
        $optionsMetodoPago = MetodoPagoEnum::cases();
        $empresa           = $this->empresaService->obtenerEmpresa();

        return view('venta.create', compact(
            'productos',
            'clientes',
            'comprobantes',
            'optionsMetodoPago',
            'empresa'
        ));
    }

    /**
     * Guardar venta
     */
    public function store(StoreVentaRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $venta = Venta::create($request->validated());

            // Arrays del detalle
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad    = $request->get('arraycantidad');
            $arrayPrecioVenta = $request->get('arrayprecioventa');

            $sizeArray = count($arrayProducto_id);
            $cont = 0;

            while ($cont < $sizeArray) {
                $venta->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont] => [
                        'cantidad'     => $arrayCantidad[$cont],
                        'precio_venta' => $arrayPrecioVenta[$cont],
                    ]
                ]);

                // Evento por cada item
                CreateVentaDetalleEvent::dispatch(
                    $venta,
                    $arrayProducto_id[$cont],
                    $arrayCantidad[$cont],
                    $arrayPrecioVenta[$cont]
                );

                $cont++;
            }

            // Evento general
            CreateVentaEvent::dispatch($venta);

            DB::commit();
            ActivityLogService::log('Creación de una venta', 'Ventas', $request->validated());

            return redirect()
                ->route('movimientos.index', ['caja_id' => $venta->caja_id])
                ->with('success', 'Venta registrada');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error al crear la venta', ['error' => $e->getMessage()]);
            return redirect()->route('ventas.index')->with('error', 'Ups, algo falló');
        }
    }

    /**
     * Ver detalle
     */
    public function show(Venta $venta): View
    {
        $empresa =  $this->empresaService->obtenerEmpresa();
        return view('venta.show', compact('venta', 'empresa'));
    }

    public function edit(string $id) { /* ... */ }
    public function update(Request $request, string $id) { /* ... */ }
    public function destroy(string $id) { /* ... */ }
}
