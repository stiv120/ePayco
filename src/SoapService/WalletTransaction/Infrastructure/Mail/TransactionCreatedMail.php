<?php

namespace Src\SoapService\WalletTransaction\Infrastructure\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Src\SoapService\WalletTransaction\Domain\Entities\WalletTransaction;

class TransactionCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3; // Número de reintentos
    public $timeout = 30; // Tiempo máximo de ejecución
    public $transaction;

    /**
     * Create a new message instance.
     */
    public function __construct(WalletTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.transactions.created')
                    ->subject('Nueva Transacción Creada')
                    ->with([
                        'token' => $this->transaction->getToken(),
                        'sessionId' => $this->transaction->getSessionId(),
                        'monto' => $this->transaction->getMonto()
                    ]);
    }
}
