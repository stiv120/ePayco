<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\SoapService\Customer\Infrastructure\Persistence\DoctrineCustomerEntity;
use Src\SoapService\Customer\Infrastructure\Persistence\Factory\CustomerFactory;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $em;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->em = app('em');
    }

    public function testRegistroClienteExitoso()
    {
        $customerData = [
            'nombres' => 'Juan',
            'celular' => '1234567890',
            'documento' => '1234567890',
            'email' => 'juan@example.com'
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/soap/clientes/registrar', $customerData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'message' => 'Cliente registrado correctamente.'
                ]
            ]);

        $cliente = $this->em->getRepository(DoctrineCustomerEntity::class)
            ->findOneBy(['email' => $customerData['email']]);

        $this->assertNotNull($cliente);
        $this->assertEquals($customerData['email'], $cliente->getEmail());
        $this->assertEquals($customerData['nombres'], $cliente->getNombres());
    }

    public function testRegistroClienteDatosInvalidos()
    {
        $customerData = [
            'nombres' => '', // Nombre vacío
            'celular' => '123', // Celular muy corto
            'documento' => 'abc', // Documento no numérico
            'email' => 'correo-invalido' // Email inválido
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/soap/clientes/registrar', $customerData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message_error' => 'Errores de validación.'
            ]);
    }

    public function testRegistroClienteEmailDuplicado()
    {
        // Crear cliente existente
        CustomerFactory::create([
            'email' => 'pruebajuan@example.com'
        ]);

        $customerData = [
            'nombres' => 'Juan Nuevo',
            'celular' => '9876543210',
            'documento' => '9876543210',
            'email' => 'pruebajuan@example.com' // Email duplicado
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/soap/clientes/registrar', $customerData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message_error' => 'Errores de validación.',
                'data' => [
                    'email' => ['Ya existe un cliente con este email.']
                ]
            ]);
    }
}
