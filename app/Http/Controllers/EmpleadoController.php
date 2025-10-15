<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado; // Importa el modelo de Empleado
use App\Models\User; // Importa el modelo de User
use Illuminate\Support\Facades\Hash; // Para encriptar la contraseña

class EmpleadoController extends Controller
{
    /**
     * Muestra una lista de todos los empleados.
     */
    public function index()
    {
        $empleados = Empleado::with('user')->get();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Muestra el formulario para crear un nuevo empleado.
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Almacena un nuevo empleado en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos del formulario (esto previene errores y valida el correo y la contraseña)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        // 2. Crear el usuario en la tabla 'users'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encripta la contraseña
        ]);

        // 3. Crear el empleado en la tabla 'empleados' y lo vincula al usuario
        $empleado = new Empleado([
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        // El método 'save()' crea la relación y guarda el empleado
        $user->empleado()->save($empleado);

        return redirect()->route('empleados.index')->with('success', '¡Empleado creado con éxito!');
    
    }

    /**
     * Muestra los detalles de un empleado específico.
     */
    public function show(Empleado $empleado)
    {
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Muestra el formulario para editar un empleado.
     */
    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    /**
     * Actualiza un empleado en la base de datos.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $empleado->user->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        $empleado->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $empleado->update([
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('empleados.index')->with('success', '¡Empleado actualizado con éxito!');
    }

    /**
     * Elimina un empleado de la base de datos.
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->user->delete(); // Elimina el usuario, lo que también elimina el empleado por la relación 'cascade'
        return redirect()->route('empleados.index')->with('success', '¡Empleado eliminado con éxito!');
    }
}
