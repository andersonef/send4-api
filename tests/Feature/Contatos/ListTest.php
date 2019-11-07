<?php

namespace Tests\Feature\Contatos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Entities\Contato;
use Tests\TestCase;
use Tests\ListRequestParamsTestTrait;

class ListTest extends TestCase
{
    const URI = '/api/contatos';

    use RefreshDatabase, ListRequestParamsTestTrait;    

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
