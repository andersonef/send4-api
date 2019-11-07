<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MensagemRequest;
use App\Entities\Mensagem;
use App\Classes\ListQueryBuilder;
use App\Http\Requests\ListRequest;

class MensagensController extends Controller
{
    public function store(MensagemRequest $request)
    {
        $mensagem = Mensagem::create($request->all());
        return $mensagem;
    }

    public function show($id, ListRequest $request, ListQueryBuilder $listQueryBuilder)
    {
        $mensagens = Mensagem::query()
            ->where('contato_id', '=', $id);
            
        $mensagens = $listQueryBuilder
            ->usingQuery($mensagens)
            ->searchFields((new Mensagem())->getFillable())
            ->readRequest($request)
            ->process();

        return $mensagens->get();       
    }

    public function update(MensagemRequest $request, $id)
    {
        $mensagem = Mensagem::query()->where('id', '=', $id)->first();
        $mensagem->update($request->all());
        return $mensagem;
    }

    public function destroy($id)
    {
        Mensagem::query()->where('id', '=', $id)->delete();
        return true;
    }
}
