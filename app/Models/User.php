<?php

namespace App\Models;

// Importamos las clases necesarias para las relaciones
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Es crucial incluir 'cargo_id' aquí.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cargo_id', // El campo que conecta con la tabla 'cargos'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // RELACIÓN CLAVE: Un usuario pertenece a un cargo (soluciona el error de 'Sin Cargo').
    /**
     * Define la relación con el modelo Cargo.
     */
    public function cargo(): BelongsTo
    {
        // Indica que la llave foránea es 'cargo_id' en la tabla 'users'.
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    // RELACIÓN ADICIONAL DE TU ESQUEMA
    
    /**
     * Define la relación con el modelo Empleado.
     */
    public function empleado(): HasOne
    {
        return $this->hasOne(Empleado::class, 'idUserFK');
    }
}
