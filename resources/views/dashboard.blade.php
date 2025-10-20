<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Panadería</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    </style>
</head>
<body class="antialiased min-h-screen p-4">

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-xl p-8 sm:p-10 mt-10">
        
        <header class="flex justify-between items-center border-b pb-4 mb-6">
            <h1 class="text-3xl font-extrabold text-blue-800">
                Dashboard Principal
            </h1>
            
            <!-- Botón de Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition duration-150 shadow-md">
                    Cerrar Sesión
                </button>
            </form>
        </header>

        <section class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Bienvenido, {{ Auth::user()->name }}</h2>
            <p class="text-gray-600">
                Tu cargo actual es: 
                <span class="font-bold text-green-700">{{ Auth::user()->cargo->nombre ?? 'Sin Cargo' }}</span>.
            </p>
            <p class="mt-2 text-sm text-gray-500">
                Desde aquí podrás acceder a los módulos permitidos según tu Cargo.
            </p>
        </section>

        <!-- Bloque de Módulos (Ejemplo de uso de Gates) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            
            <!-- Módulo de Productos (Solo si tiene permiso de alta) -->
            @can('alta-productos')
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 shadow-sm hover:shadow-lg transition">
                <h3 class="font-bold text-lg text-blue-800">Gestión de Productos</h3>
                <p class="text-sm text-blue-600 mt-1">Alta y Edición de Recetas.</p>
                <a href="{{ route('productos.create') }}" class="mt-3 block text-sm font-medium text-blue-700 hover:underline">Ir a crear producto →</a>
            </div>
            @endcan

            <!-- Módulo de Ventas (Para Cajeros/Vendedores) -->
            @can('alta-ventas')
            <div class="bg-green-50 border border-green-200 rounded-xl p-5 shadow-sm hover:shadow-lg transition">
                <h3 class="font-bold text-lg text-green-800">Punto de Venta (POS)</h3>
                <p class="text-sm text-green-600 mt-1">Registrar nuevas transacciones.</p>
                <a href="/ventas" class="mt-3 block text-sm font-medium text-green-700 hover:underline">Ir a Ventas →</a>
            </div>
            @endcan
            
            <!-- Módulo de Usuarios (Solo Super Admin) -->
            @if(Auth::user()->cargo_id == 1)
            <div class="bg-purple-50 border border-purple-200 rounded-xl p-5 shadow-sm hover:shadow-lg transition">
                <h3 class="font-bold text-lg text-purple-800">Administración de Usuarios</h3>
                <p class="text-sm text-purple-600 mt-1">Gestionar Cargos y Empleados.</p>
                <a href="{{ route('empleados.index') }}" class="mt-3 block text-sm font-medium text-purple-700 hover:underline">Ir a Empleados →</a>
            </div>
            @endif

        </div>
    </div>

</body>
</html>
