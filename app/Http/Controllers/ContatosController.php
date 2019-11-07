<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContatoRequest;
use App\Http\Requests\ListRequest;
use App\Entities\Contato;
use App\Classes\ListQueryBuilder;
use App\Entities\Mensagem;
use App\Exceptions\ApiRequestValidationException;

class ContatosController extends Controller
{
    public function store(ContatoRequest $request)
    {
        $contato = Contato::create($request->all());
        return $contato;
    }

    public function index(ListRequest $request, ListQueryBuilder $listQueryBuilder)
    {
        $contatos = Contato::query();
        $contatos = $listQueryBuilder
            ->usingQuery($contatos)
            ->searchFields((new Contato())->getFillable())
            ->readRequest($request)
            ->process();

        return $contatos->get();       
    }

    public function update(ContatoRequest $request, $id)
    {
        $contato = Contato::query()->where('id', '=', $id)->first();
        $contato->update($request->all());
        return $contato;
    }

    public function destroy($id)
    {
        $mensagensDoContato = Mensagem::query()
            ->where('contato_id', '=', $id)
            ->first();
        if ($mensagensDoContato) {
            throw new ApiRequestValidationException('O contato possui uma ou mais mensagens e não pode ser excluído. Exclua as mensagens primeiro!');
        }
        Contato::query()->where('id', '=', $id)->delete();
        return true;
    }
}
