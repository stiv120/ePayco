<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\SoapService\Wallet\Infrastructure\Persistence\DoctrineWalletEntity;
use Src\SoapService\Wallet\Infrastructure\Persistence\Factory\WalletFactory;
use Src\SoapService\Customer\Infrastructure\Persistence\Factory\CustomerFactory;

class WalletControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $em;
    protected $user;
    protected $customer;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->em = app('em');
        $this->customer = CustomerFactory::create();
    }

    public function testRecargarBilleteraExitoso()
    {
        $walletData = [
            'celular' => $this->customer->getCelular(),
            'documento' => $this->customer->getDocumento(),
            'valor' => 25000
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/soap/billeteras/recargar', $walletData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'message' => 'Billetera cargada correctamente.'
                ]
            ]);

        $wallet = $this->em->getRepository(DoctrineWalletEntity::class)
            ->findOneBy([
                'celular' => $walletData['celular'],
                'documento' => $walletData['documento']
            ]);

        $this->assertNotNull($wallet);
        $this->assertEquals($walletData['valor'], $wallet->getValor());
    }

    public function testRecargarBilleteraClienteNoExiste()
    {
        $walletData = [
            'celular' => '9999999999',
            'documento' => '9999999999',
            'valor' => 25000
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/soap/billeteras/recargar', $walletData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message_error' => 'Errores de validación.',
                'data' => [
                   'Cliente no encontrado!'
                ]
            ]);
    }

    public function testRecargarBilleteraMontoInvalido()
    {
        $walletData = [
            'celular' => $this->customer->getCelular(),
            'documento' => $this->customer->getDocumento(),
            'valor' => -1000 // Monto negativo
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/soap/billeteras/recargar', $walletData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message_error' => 'Errores de validación.'
            ]);
    }

    public function testConsultarSaldoExitoso()
    {
        $wallet = WalletFactory::create([
            'celular' => $this->customer->getCelular(),
            'documento' => $this->customer->getDocumento(),
            'valor' => 50000
        ]);

        $consultaData = [
            'celular' => $wallet->getCelular(),
            'documento' => $wallet->getDocumento()
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/soap/billeteras/consultar-saldo', $consultaData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'saldo' => $wallet->getValor()
                ]
            ]);
    }

    public function testConsultarSaldoBilleteraNoExiste()
    {
        $consultaData = [
            'celular' => '9999999999',
            'documento' => '9999999999'
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/soap/billeteras/consultar-saldo', $consultaData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message_error' => 'Errores de validación.'
            ]);
    }

    public function testConsultarSaldoDatosInvalidos()
    {
        $consultaData = [
            'celular' => '123', // Celular muy corto
            'documento' => 'abc' // Documento no numérico
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/soap/billeteras/consultar-saldo', $consultaData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message_error' => 'Errores de validación.'
            ]);
    }
}
