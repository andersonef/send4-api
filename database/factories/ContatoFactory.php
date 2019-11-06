<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Contato;
use Faker\Generator as Faker;

$factory->define(Contato::class, function (Faker $faker) {
    return [
        'nome_contato'          => $faker->firstName,
        'sobrenome_contato'     => $faker->lastName,
        'email_contato'         => $faker->email,
        'telefone_contato'      => $faker->regexify('/\+[0-9]{1,3} \([0-9]{2,3}\) [0-9]{4}\-[0-9]{5}/')
    ];
});
