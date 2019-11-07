<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Contato;
use Faker\Generator as Faker;

$factory->define(Contato::class, function (Faker $faker) {
    return [
        'nome_contato'          => $faker->firstName,
        'sobrenome_contato'     => $faker->lastName,
        'email_contato'         => $faker->email,
        'telefone_contato'      => $faker->bothify(Contato::FORMATO_TELEFONE)
    ];
});
