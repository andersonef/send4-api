<?php

namespace Tests\Feature\Mensagens;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Entities\Mensagem;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    const URI = '/api/mensagens';

    protected function getIdealPayload()
    {
        return factory(Mensagem::class, 1)->create()->first();
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
        
        $this->assertDatabaseMissing('mensagems', ['id' => $payload->id]);
    }

}
