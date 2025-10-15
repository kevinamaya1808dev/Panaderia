<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('clientes.update', $cliente->idCli) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Esto le dice a Laravel que es una solicitud de actualización (PUT/PATCH) --}}
                        
                        <div>
                            <label for="Nombre" class="block text-sm font-medium text-gray-700">Nombre del Cliente</label>
                            <input type="text" name="Nombre" id="Nombre" value="{{ old('Nombre', $cliente->Nombre) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('Nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Cliente
                            </button>
                            <a href="{{ route('clientes.index') }}" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>