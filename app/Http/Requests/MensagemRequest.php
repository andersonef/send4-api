<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\ApiRequestValidationException;
use Illuminate\Contracts\Validation\Validator;

class MensagemRequest extends FormRequest
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
        return [
            'contato_id'                => ['required', 'exists:contatos,id'],
            'descricao_mensagem'        => ['required']
        ];
    }

    public function messages()
    {
        return [
            'contato_id.required'           => 'É obrigatório informar o contato da mensagem.',
            'contato_id.exists'             => 'O contato informado não foi encontrado em nosso banco de dados.',
            'descricao_mensagem.required'   => 'É obrigatório informar a descrição da mensagem.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ApiRequestValidationException($validator->errors());
    }
}
