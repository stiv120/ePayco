<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletTransaction extends Model
{
    use HasFactory;

    /**
     * Atributo que especifica el nombre de la secuencia asociado a la Tabla/Modelo
     */
    public $sequence = 's_transacciones_billeteras';

    /**
     * Atributo que especifica el nombre de la tabla asociado al modelo.
     */
    protected $table = 'transacciones_billeteras';

    protected $fillable = [
        'monto',
        'token',
        'estado',
        'session_id',
        'billetera_id'
    ];

    public function billetera()
    {
        return $this->belongsTo(Wallet::class, 'billetera_id');
    }
}
