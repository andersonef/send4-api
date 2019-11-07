<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Entities\Contato;
use App\Exceptions\ApiRequestValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;


class ContatoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $uniqueRule = Rule::unique('contatos', 'email_contato');
        if ($this->has('id')) {
            $uniqueRule->ignore($this->get('id'));
        }
        return [
            'nome_contato'      => ['required', 'min:3'],
            'sobrenome_contato' => ['required', 'min:3'],
            'email_contato'     => ['required', 'email', $uniqueRule],
            'telefone_contato'  => ['required', 'regex:' . Contato::REGEX_TELEFONE],
        ];
    }

    public function messages()
    {
        return [
            'nome_contato.required'         => 'É obrigatório informar o nome do contato!',
            'nome_contato.gt'               => 'O nome do contato deve ter pelo menos 3 caracteres',

            'sobrenome_contato.required'    => 'É obrigatório informar o sobrenome do contato!',
            'sobrenome_contato.gt'          => 'O sobrenome deve conter pelo menos 3 caracteres',

            'email_contato.required'        => 'É obrigatório informar o email do contato',
            'email_contato.email'           => 'O campo "Email" está inválido.',
            'email_contato.unique'          => 'Email já encontrado em nosso banco de dados!',

            'telefone_contato.required'     => 'É obrigatório informar o telefone do contato',
            'telefone_contato.regex'        => 'O telefone precisa estar no seguinte format: +99 (99) 9999-99999!'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ApiRequestValidationException($validator->errors());
    }
}
