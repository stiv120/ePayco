<?php

namespace Database\Factories;

use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Src\SoapService\WalletTransaction\Domain\Enums\TransactionStatusEnum;
use App\Models\Wallet;

class WalletTransactionFactory extends Factory
{
    protected $model = WalletTransaction::class;

    public function definition(): array
    {
        // Crear una billetera primero
        $wallet = Wallet::factory()->create();

        return [
            'billetera_id' => $wallet->id, // usar el ID de la billetera creada
            'monto' => $this->faker->randomFloat(2, 10000, 1000000),
            'token' => $this->faker->numerify('######'),
            'session_id' => $this->faker->uuid,
            'estado' => TransactionStatusEnum::PENDING->value
        ];
    }
}
