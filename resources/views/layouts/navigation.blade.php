<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <!-- Logo y Nombre de la Aplicación -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="fas fa-bread-slice me-2"></i> {{ config('app.name', 'Panadería POS') }}
        </a>
        
        <!-- Toggler para Móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <!-- Enlaces de Navegación Principales (Izquierda) -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                
                {{-- Ejemplo de un Módulo de Gestión --}}
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('empleados.*')) active @endif" href="{{ route('empleados.index') }}">
                        <i class="fas fa-users"></i> Empleados
                    </a>
                </li>
                
                {{-- Aquí puedes añadir más enlaces como Productos, Ventas, etc. --}}

            </ul>

            <!-- Configuración del Usuario (Derecha) -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle"></i> {{ Auth::user()->name }} 
                        <span class="badge bg-secondary">{{ Auth::user()->cargo->nombre ?? 'Usuario' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-cog"></i> Perfil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <!-- Formulario de Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>