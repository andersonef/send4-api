<?php

namespace Tests\Feature\Contatos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Entities\Contato;
use App\Entities\Mensagem;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    const URI = '/api/contatos';

    protected function getIdealPayload()
    {
        return factory(Contato::class, 1)->create()->first();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccess()
    {
        $payload = $this->getIdealPayload();
        $response = $this->delete(self::URI . '/' . $payload->id);
        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'success']);
        
        $this->assertDatabaseMissing('contatos', ['id' => $payload->id]);
    }

    public function testDeleteContatoComMensagens()
    {
        $payload = $this->getIdealPayload();
        factory(Mensagem::class, 1)->create(['contato_id' => $payload->id]); // agora o contato possui uma mensagem

        $response = $this->delete(self::URI . '/' . $payload->id);

        $response
            ->assertStatus(422)
            ->assertJson(['status' => 'error']);
        $this->assertDatabaseHas('contatos', ['id' => $payload->id]);
    }
}
