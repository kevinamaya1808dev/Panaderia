<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $primaryKey = 'idEmp';

    protected $fillable = [
        'idUserFK',
        'telefono',
        'direccion'
    ];
    
    /**
     * Define la relación con el modelo User.
     * Un empleado pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'idUserFK');
    }
}
