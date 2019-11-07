<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    const REGEX_TELEFONE = '/^\+[0-9]{1,3} \([0-9]{2,3}\) ([0-9]{4}\-[0-9]{5}|[0-9]{5}\-[0-9]{4})$/';
    const FORMATO_TELEFONE = '+## (##) ####-#####';
    
    protected $fillable = [
        'nome_contato',
        'sobrenome_contato',
        'email_contato',
        'telefone_contato'
    ];
}
