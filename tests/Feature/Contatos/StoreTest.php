<?php

namespace Tests\Feature\Contatos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Entities\Contato;

class StoreTest extends TestCase
{
    const URI = '/api/contatos';

    use RefreshDatabase;

    protected function getIdealPayload()
    {
        $payload = factory(Contato::class, 1)
            ->make()
            ->first()
            ->toArray();
        
        return $payload;
    }

    /**
     * Testando o cenário ideal
     *
     * @return void
     */
    public function testSuccess()
    {
        $payload = $this->getIdealPayload();

        $response = $this->post(self::URI, $payload);
        
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('contatos', $payload);
    }

    /**
     * Testando a falha no envio de uma payload sem o nome do contato
     */
    public function testNomeObrigatorio()
    {
        $payload = $this->getIdealPayload();
        
        unset($payload['nome_contato']); //removendo o nome para testar a validação

        $response = $this->post(self::URI, $payload);

        // Asserts
        $this->assertNotEquals(200, $response->getStatusCode());
        $response->assertJson(['status' => 'error']);
        $this->assertDatabaseMissing('contatos', $payload);
    }

    /**
     * Testando a falha no envio de uma payload sem o sobrenome do contato
     */
    public function testSobrenomeObrigatorio()
    {
        $payload = $this->getIdealPayload();
        
        unset($payload['sobrenome_contato']);

        $response = $this->post(self::URI, $payload);

        // Asserts
        $this->assertNotEquals(200, $response->getStatusCode());
        $response->assertJson(['status' => 'error']);
        $this->assertDatabaseMissing('contatos', $payload);
    }

    /**
     * Testando o email único
     */
    public function testEmailUnico()
    {
        $contatoCriado = factory(Contato::class, 1)->create()->first();

        $payload = $this->getIdealPayload();

        $payload['email_contato'] = $contatoCriado->email_contato; // informando na payload um email já existente no banco

        $response = $this->post(self::URI, $payload);

        // Espero status de erro
        $this->assertNotEquals(200, $response->getStatusCode());
        $response->assertJson(['status' => 'error']);

        // Email deve existir no banco apenas 1x:
        $qtdEmailBanco = Contato::query()->where('email_contato', '=', $payload['email_contato'])->count();

        $this->assertEquals(1, $qtdEmailBanco);

    }

    /**
     * Testa se o sistema está validando o telefone nos seguinte formato: 
     *  -> +## (##) ####-#####
     *  -> +### (###) #####-####
     *  -> +## (###) #####-####
     *  -> +### (##) #####-####
     *  -> +# (##) #####-####
     *  -> +# (###) #####-####
     */
    public function testFormatoTelefone()
    {
        $formatos = [
            '+55 (34) 9999-33333'       => 200,
            '+332 (344) 98883-3332'     => 200,
            '+1 (323) 23452-3332'       => 200,
            '+1 (32) 34562-3322'        => 200,
            '+55 (322) 34442-3344'      => 200,
            '+3445 (3) 322444'          => 422, // formato inválido
            '5534991255544'             => 422, // formato inválido
            '(34) 32444-3322'           => 422, // formato inválido
        ];

        foreach($formatos as $telefone => $statusCodeEsperado) {
            $payload = $this->getIdealPayload();
            $payload['telefone_contato'] = $telefone;
            $response = $this->post(self::URI, $payload);

            $this->assertEquals($response->getStatusCode(), $statusCodeEsperado);
            if ($statusCodeEsperado === 200) {
                $response->assertJson(['status' => 'success']);
                $this->assertDatabaseHas('contatos', ['telefone_contato' => $telefone]);
                continue;
            }

            $response->assertJson(['status' => 'error']);
            
        }
    }
}
