<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cargo_id', // Para la relación con Cargo
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relación con Cargo
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }
    
    // Relación con Empleado (clave foránea está en Empleado)
    public function empleado()
    {
        // Un usuario TIENE un empleado
        return $this->hasOne(Empleado::class, 'idUserFK');
    }
    
    // Puedes definir aquí tus métodos para checkear permisos si los necesitas
}