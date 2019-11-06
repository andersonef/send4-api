<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Mensagem;
use App\Entities\Contato;
use Faker\Generator as Faker;

$factory->define(Mensagem::class, function (Faker $faker) {
    $contato = Contato::query()->inRandomOrder()->first();
    return [
        'contato_id'            => $contato->id,
        'descricao_mensagem'    => implode('', $faker->paragraphs(3))
    ];
});
