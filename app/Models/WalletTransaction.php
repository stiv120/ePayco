<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $table = 'transacciones_billeteras';

    protected $fillable = [
        'billetera_id',
        'monto',
        'token',
        'session_id',
        'estado'
    ];

    protected $dates = [
        'fecha_creacion',
        'fecha_actualizacion'
    ];

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'billetera_id');
    }
}
