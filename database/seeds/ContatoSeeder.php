<?php

use Illuminate\Database\Seeder;
use App\Entities\Contato;

class ContatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Contato::class, 50)->create();
    }
}
