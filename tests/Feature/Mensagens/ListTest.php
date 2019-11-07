<?php

namespace Tests\Feature\Mensagens;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Entities\Contato;
use App\Entities\Mensagem;
use Tests\ListRequestParamsTestTrait;

class ListTest extends TestCase
{
    use RefreshDatabase, ListRequestParamsTestTrait;
    
    protected $contato1;
    protected $contato2;

    protected function getUri()
    {
        return '/api/mensagens/' . $this->contato1->id;
    }

    /**
     * Prepara o ambiente criando 2 contatos e 70 mensagens para cada umd os contatos.
     */
    protected function setUp(): void
    {
        parent::setup();

        $this->contato1 = factory(Contato::class, 1)->create()->first();
        $this->contato2 = factory(Contato::class, 1)->create()->first();
        $mensagensContato1 = factory(Mensagem::class, 70)->create(['contato_id' => $this->contato1->id]);
        $mensagensContato2 = factory(Mensagem::class, 70)->create(['contato_id' => $this->contato2->id]);
    }
    /**
     * Testando a exibição da lista, trazendo o limite de 50 registros.
     *
     * @return void
     */
    public function testSuccess()
    {
        $response = $this->get($this->getUri());
        $response
            ->assertStatus(200)
            ->assertJsonCount(50, 'data');
    }
}
