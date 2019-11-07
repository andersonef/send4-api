<?php namespace Tests;

use App\Entities\Contato;
use App\Entities\Mensagem;

trait ListRequestParamsTestTrait
{

    protected function getUri()
    {
        return self::URI;
    }

    protected function initializeDatabase()
    {
        // populando o banco
        factory(Contato::class, 60)->create();
        factory(Mensagem::class, 500)->create();
    }
    /**
     * Testando exibição de todos os resultados. O sistema deve limitar a 50 sempre.
     *
     * @return void
     */
    public function testLimiteExibicao()
    {
        $this->initializeDatabase();

        $response = $this->get($this->getUri());
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $response->assertJsoncount(50, 'data');

        $response = $this->get($this->getUri() . '?limit=10');
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $response->assertJsoncount(10, 'data');
    }

}