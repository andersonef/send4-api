<?php

namespace Tests\Feature\Mensagens;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Entities\Mensagem;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    const URI = '/api/mensagens';

    protected function getIdealPayload()
    {
        $mensagem = factory(Mensagem::class, 1)->create()->first()->toArray();
        return [
            $mensagem,
            [
                'contato_id'            => $mensagem['contato_id'],
                'descricao_mensagem'    => 'descrição alterada'
            ]
            ];
    }
    /**
     * Testando um caso de sucesso.
     *
     * @return void
     */
    public function testSuccess()
    {
        [$original,$payload] = $this->getIdealPayload();

        $response = $this->put(self::URI . '/' . $original['id'], $payload);

        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('mensagems', $payload);
        $this->assertDatabaseMissing('mensagems', $original);
    }

    /**
     * Testando o erro esperado ao tentar criar uma mensagem informando um contato inexistente
     */
    public function testContatoInexistente()
    {
        [$original, $payload] = $this->getIdealPayload();
        $payload['contato_id'] = -1; // Não existe o contato -1

        $response = $this->put(self::URI . '/' . $original['id'], $payload);

        $response
            ->assertStatus(422)
            ->assertJson(['status' => 'error']);
        
        unset($payload['id']);
        $this->assertDatabaseHas('mensagems', $original);
        $this->assertDatabaseMissing('mensagems', $payload);
    }

    /**
     * Testando o erro esperado ao tentar criar uma mensagem sem informar o contato
     */
    public function testErroMensagemSemContato()
    {
        [$original, $payload] = $this->getIdealPayload();
        

        unset($payload['contato_id']);

        $response = $this->put(self::URI . '/' . $original['id'], $payload);

        $response
            ->assertStatus(422)
            ->assertJson(['status' => 'error']);
        
        $this->assertDatabaseHas('mensagems', $original);
        $this->assertDatabaseMissing('mensagems', $payload);
    }

    /**
     * Testando o erro esperado ao tentar criar uma mensagem sem informar a descrição
     */
    public function testErroMensagemSemDescricao()
    {
        [$original, $payload] = $this->getIdealPayload();

        unset($payload['descricao_mensagem']);
        $response = $this->put(self::URI . '/' . $original['id'], $payload);

        $response
            ->assertStatus(422)
            ->assertJson(['status' => 'error']);
        
        $this->assertDatabaseHas('mensagems', $original);
    }
}
