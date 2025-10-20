<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Panadería</title>
    <!-- Asumiendo que Tailwind CSS está configurado o enlazado -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8 sm:p-10">
        <!-- Logo o Título -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-blue-800 tracking-tight">
                Panadería
            </h1>
            <p class="text-gray-500 mt-1">Acceso al Sistema POS</p>
        </div>

        <!-- Manejo de Errores (Si falla el login) -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg">
                <p class="font-bold">Error de Acceso</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de Inicio de Sesión -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf <!-- Token de seguridad de Laravel -->

            <!-- Campo Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <div class="mt-1">
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           value="{{ old('email') }}" autofocus>
                </div>
            </div>

            <!-- Campo Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>

            <!-- Recordar Sesión -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Recuérdame
                    </label>
                </div>
            </div>

            <!-- Botón de Enviar -->
            <div>
                <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    Iniciar Sesión
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Usa el usuario de administrador: <span class="font-mono text-blue-600">admin@panaderia.com</span> / <span class="font-mono text-blue-600">password</span>
            </p>
        </div>
    </div>

</body>
</html>