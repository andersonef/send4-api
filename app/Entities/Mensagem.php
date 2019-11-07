<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $fillable = [
        'contato_id',
        'descricao_mensagem'
    ];
}
