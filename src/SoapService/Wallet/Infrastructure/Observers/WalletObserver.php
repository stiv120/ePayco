<?php

namespace Src\SoapService\Wallet\Infrastructure\Observers;

use App\Models\Wallet;

class WalletObserver
{
    /**
     * Handle the Wallet "created" event.
     */
    public function created(Wallet $wallet): void
    {
    }

    /**
     * Handle the Wallet "updated" event.
     */
    public function updated(Wallet $wallet): void
    {
    }

    /**
     * Handle the Wallet "deleted" event.
     */
    public function deleted(Wallet $wallet): void
    {
        //
    }

    /**
     * Handle the Wallet "restored" event.
     */
    public function restored(Wallet $wallet): void
    {
        //
    }

    /**
     * Handle the Wallet "force deleted" event.
     */
    public function forceDeleted(Wallet $wallet): void
    {
        //
    }
}
