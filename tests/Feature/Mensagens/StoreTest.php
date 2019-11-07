<?php

namespace Tests\Feature\Mensagens;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Entities\Contato;
use App\Entities\Mensagem;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    const URI = '/api/mensagens';

    protected function getIdealPayload()
    {
        $mensagem = factory(Mensagem::class, 1)->make()->first()->toArray();
        return $mensagem;
    }
    /**
     * Testando um caso de sucesso.
     *
     * @return void
     */
    public function testSuccess()
    {
        $payload = $this->getIdealPayload();

        $response = $this->post(self::URI, $payload);

        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('mensagems', $payload);
    }

    /**
     * Testando o erro esperado ao tentar criar uma mensagem informando um contato inexistente
     */
    public function testContatoInexistente()
    {
        $payload = $this->getIdealPayload();
        $payload['contato_id'] = -1; // Não existe o contato -1

        $response = $this->post(self::URI, $payload);

        $response
            ->assertStatus(422)
            ->assertJson(['status' => 'error']);
        
        $this->assertDatabaseMissing('mensagems', $payload);
    }

    /**
     * Testando o erro esperado ao tentar criar uma mensagem sem informar o contato
     */
    public function testErroMensagemSemContato()
    {
        $payload = $this->getIdealPayload();

        unset($payload['contato_id']);
        $response = $this->post(self::URI, $payload);

        $response
            ->assertStatus(422)
            ->assertJson(['status' => 'error']);
        
        $this->assertDatabaseMissing('mensagems', $payload);
    }

    /**
     * Testando o erro esperado ao tentar criar uma mensagem sem informar a descrição
     */
    public function testErroMensagemSemDescricao()
    {
        $payload = $this->getIdealPayload();

        unset($payload['descricao_mensagem']);
        $response = $this->post(self::URI, $payload);

        $response
            ->assertStatus(422)
            ->assertJson(['status' => 'error']);
        
        $this->assertDatabaseMissing('mensagems', ['descricao_mensagem' => null]);
    }
}
