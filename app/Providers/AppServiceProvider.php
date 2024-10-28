<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Src\SoapService\WalletTransaction\Domain\Events\WalletTransactionCreatedEvent;
use Src\SoapService\WalletTransaction\Infrastructure\Listeners\SendTransactionEmailListener;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            WalletTransactionCreatedEvent::class,
            [SendTransactionEmailListener::class, 'handle']
        );
    }
}
