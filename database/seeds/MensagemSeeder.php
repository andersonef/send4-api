<?php

use Illuminate\Database\Seeder;
use App\Entities\Mensagem;

class MensagemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Mensagem::class, 500)->create();
    }
}
