<?php

namespace Tests\Feature\Contatos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Entities\Contato;
use Tests\TestCase;

class ListTest extends TestCase
{
    const URI = '/api/contatos';

    /**
     * Testando exibição de todos os resultados. O sistema deve limitar a 50 sempre.
     *
     * @return void
     */
    public function testLimiteExibicao()
    {
        factory(Contato::class, 60)->create();
        $response = $this->get(self::URI);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $response->assertJsoncount(50, 'data');

        $response = $this->get(self::URI . '?limit=10');
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $response->assertJsoncount(10, 'data');
    }

    public function testBuscaPorNome()
    {
        $nomeParaPesquisar = 'ijadofasdf8ua9fa8fad7sf87dfa98dafdas9f9';
        $contatos = factory(Contato::class, 20)->create();
        $contatoParaBuscar = $contatos->first();
        $contatoParaBuscar->update(['nome_contato' => $nomeParaPesquisar]);

        $response = $this->get(self::URI . '?limit=1&q=' . $nomeParaPesquisar);
        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'success'])
            ->assertJsoncount(1, 'data');
    
    }
}
