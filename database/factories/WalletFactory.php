<?php

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\kardexMovement>
 */
class WalletFactory extends Factory
{
    /**
     * El nombre del modelo que está asociado con este factory.
     *
     * @var string
     */
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'documento' => $this->faker->unique()->numerify('##########'),
            'celular' => $this->faker->unique()->numerify('##########'),
            'valor' => $this->faker->randomFloat(2, 10000, 1000000)
        ];
    }
}
