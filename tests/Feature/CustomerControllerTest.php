<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;

class CustomerControllerTest extends TestCase
{
    protected $user;

    /**
     * Set up the environment for each test.
     * Creates a new user instance.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(); // Create a user
    }

    /**
     * Test the store method for products.
     * Ensures that a new product can be created and checks if it's stored in the database.
     * @return void
     */
    public function testRegistroCliente()
    {
        $customerData = Customer::factory()->make()->toArray();

        $response = $this->actingAs($this->user)->postJson('/api/soap/clientes/registrar', $customerData);

        $response->assertStatus(201)
                 ->assertJson(
                    [
                        'success' => true,
                        'data' => [
                            'customer' => $customerData,
                            'message' => 'Cliente registrado correctamente.'
                        ]
                    ]
                );
        $this->assertDatabaseHas('clientes', $customerData);
    }
}
