<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    /**
     * Atributo que especifica el nombre de la secuencia asociado a la Tabla/Modelo
     */
    public $sequence = 's_billeteras';

    /**
     * Atributo que especifica el nombre de la tabla asociado al modelo.
     */
    protected $table = 'billeteras';

    protected $fillable = ['documento', 'celular', 'valor'];
}
