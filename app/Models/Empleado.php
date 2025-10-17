<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Empleado extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'empleados'; 

    protected $fillable = [
        'Nombre',
        'Correo',
        'Password',
        'idCargoFK'
    ];
    
    protected $hidden = [
        'Password',
    ];
    
    // CRÍTICO: Fortify o la autenticación usa esta función si el campo no es 'password'
    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['Password'] = bcrypt($value);
    }
    
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'idCargoFK');
    }
    
    // Relación para el AuthServiceProvider
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'cargo_permiso', 'id_cargo', 'id_permiso');
    }
}
