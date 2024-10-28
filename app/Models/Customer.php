<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    /**
     * Atributo que especifica el nombre de la secuencia asociado a la Tabla/Modelo
     */
    public $sequence = 's_clientes';

    /**
     * Atributo que especifica el nombre de la tabla asociado al modelo.
     */
    protected $table = 'clientes';

    protected $fillable = [
        'nombres',
        'documento',
        'celular',
        'email'
    ];

    protected $dates = [
        'fecha_creacion',
        'fecha_actualizacion'
    ];

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
}
