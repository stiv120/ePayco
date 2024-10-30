<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\SoapService\Wallet\Infrastructure\Persistence\Factory\WalletFactory;
use Src\SoapService\Customer\Infrastructure\Persistence\Factory\CustomerFactory;
use Src\SoapService\WalletTransaction\Infrastructure\Persistence\DoctrineWalletTransactionEntity;

class WalletTransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $em;
    protected $user;
    protected $wallet;
    protected $customer;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->em = app('em');

        // Crear cliente y billetera base para las pruebas
        $this->customer = CustomerFactory::create();
        $this->wallet = WalletFactory::create([
            'celular' => $this->customer->getCelular(),
            'documento' => $this->customer->getDocumento(),
            'valor' => 50000
        ]);
    }

    // Casos de éxito para realizar pago
    public function testRealizarPagoCompraExitoso()
    {
        $datosTransaccion = [
            'monto' => 25000,
            'billetera_id' => $this->wallet->getId(),
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/soap/billeteras/transacciones/realizar-pago', $datosTransaccion);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'wallet_transaction' => [
                        'id',
                        'billetera_id',
                        'monto',
                        'token',
                        'session_id',
                        'estado'
                    ],
                    'message'
                ]
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'message' => 'Pago pendiente por confirmar, al correo fueron enviados los datos para confirmar el pago, por favor revisa tu correo.'
                ]
            ]);

        $transaccion = $this->em->getRepository(DoctrineWalletTransactionEntity::class)
            ->findOneBy(['billeteraId' => $this->wallet->getId()]);

        $this->assertNotNull($transaccion);
        $this->assertEquals($datosTransaccion['monto'], $transaccion->getMonto());
        $this->assertEquals('pendiente', $transaccion->getEstado()->value);
    }

    // Casos de fallo para realizar pago
    public function testRealizarPagoCompraSaldoInsuficiente()
    {
        $datosTransaccion = [
            'billetera_id' => $this->wallet->getId(),
            'monto' => 200000, // Monto mayor al saldo disponible
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/soap/billeteras/transacciones/realizar-pago', $datosTransaccion);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message_error' => "Errores de validación."
            ]);
    }

    public function testRealizarPagoCompraDatosInvalidos()
    {
        $datosTransaccion = [
            'billetera_id' => $this->wallet->getId(),
            'monto' => -1000, // Monto negativo
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/soap/billeteras/transacciones/realizar-pago', $datosTransaccion);

        $response->assertStatus(422);
    }

    // Casos de éxito para confirmar pago
    public function testConfirmarPagoCompraExitoso()
    {
        $transaccion = new DoctrineWalletTransactionEntity();
        $transaccion->setBilleteraId($this->wallet->getId());
        $transaccion->setMonto(25000);
        $transaccion->setToken('123456');
        $transaccion->setSessionId('session123');
        $transaccion->setEstado('pendiente');

        $this->em->persist($transaccion);
        $this->em->flush();

        $datosConfirmacion = [
            'token' => '123456',
            'session_id' => 'session123'
        ];

        $response = $this->actingAs($this->user)
            ->postJson("/api/soap/billeteras/transacciones/confirmar-pago/{$transaccion->getId()}", $datosConfirmacion);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'message' => 'Pago confirmado.'
                ]
            ]);

        $this->em->refresh($transaccion);
        $this->assertEquals('completada', $transaccion->getEstado()->value);
    }

    // Casos de fallo para confirmar pago
    public function testConfirmarPagoDatosInvalidos()
    {
        $transaccion = new DoctrineWalletTransactionEntity();
        $transaccion->setBilleteraId($this->wallet->getId());
        $transaccion->setMonto(25000);
        $transaccion->setToken('123456');
        $transaccion->setSessionId('session12345');
        $transaccion->setEstado('pendiente');

        $this->em->persist($transaccion);
        $this->em->flush();

        $datosConfirmacion = [
            'token' => '999999', // Token incorrecto,
            'session_id' => 'session1' //Id de sesión incorrecto
        ];

        $response = $this->actingAs($this->user)
            ->postJson("/api/soap/billeteras/transacciones/confirmar-pago/{$transaccion->getId()}", $datosConfirmacion);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message_error' => 'Errores de validación.'
            ]);

        $this->em->refresh($transaccion);
        $this->assertEquals('pendiente', $transaccion->getEstado()->value);
    }

    public function testConfirmarPagoCompraTransaccionInexistente()
    {
        $datosConfirmacion = [
            'token' => '123456',
            'session_id' => 'session12345'
        ];

        $response = $this->actingAs($this->user)
            ->postJson("/api/soap/billeteras/transacciones/confirmar-pago/99999", $datosConfirmacion);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message_error' => 'Errores de validación.'
            ]);
    }

    public function testConfirmarPagoCompraYaConfirmado()
    {
        $transaccion = new DoctrineWalletTransactionEntity();
        $transaccion->setBilleteraId($this->wallet->getId());
        $transaccion->setMonto(25000);
        $transaccion->setToken('248632');
        $transaccion->setSessionId('session12345678');
        $transaccion->setEstado('completada'); // Ya está confirmado

        $this->em->persist($transaccion);
        $this->em->flush();

        $datosConfirmacion = [
            'token' => '248632',
            'session_id' => 'session12345678'
        ];

        $response = $this->actingAs($this->user)
            ->postJson("/api/soap/billeteras/transacciones/confirmar-pago/{$transaccion->getId()}", $datosConfirmacion);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message_error' => 'Errores de validación.'
            ]);
    }
}
