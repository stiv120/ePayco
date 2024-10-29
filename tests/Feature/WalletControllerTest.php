<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Customer;

class WalletControllerTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testRecargarBilletera()
    {
        $customer = Customer::first();
        $walletData = Wallet::factory()->make()->toArray();
        $walletData['documento'] = $customer?->documento;
        $walletData['celular'] = $customer?->celular;

        $response = $this->actingAs($this->user)->postJson('/api/soap/billeteras/recargar', $walletData);

        $response->assertStatus(201)
                 ->assertJson(
                    [
                        'success' => true,
                        'data' => [
                            'wallet' => $walletData,
                            'message' => 'Billetera cargada correctamente.'
                        ]
                    ]
                );
        $this->assertDatabaseHas('billeteras', $walletData);
    }
}
