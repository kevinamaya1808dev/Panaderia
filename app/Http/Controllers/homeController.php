<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;   // <-- añade esto
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class homeController extends Controller
{
    // Devuelve una vista (panel) o una redirección (cajas)
    public function index(): View|RedirectResponse   // <-- union type
    {
        if (!Auth::check()) {
            return view('welcome');
        }

        // Si es cajero, mándalo directo a Cajas
        if (Auth::user()->hasRole('cajero')) {
            return redirect()->route('cajas.index'); // nombre de ruta del resource 'cajas'
        }

        // Datos del panel (solo para no-cajeros)
        $totalVentasPorDia = DB::table('ventas')
            ->selectRaw('DATE(created_at) as fecha, SUM(total) as total')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('fecha', 'asc')
            ->get()
            ->toArray();

        $productosStockBajo = DB::table('productos')
            ->join('inventario', 'productos.id', '=', 'inventario.producto_id')
            ->where('inventario.cantidad', '>', 0)
            ->orderBy('inventario.cantidad', 'asc')
            ->select('productos.nombre', 'inventario.cantidad')
            ->limit(5)
            ->get();

        return view('panel.index', compact('totalVentasPorDia', 'productosStockBajo'));
    }
}

