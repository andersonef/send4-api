<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
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
            'limit'             => ['max:50', 'min:1'],
            'offset'            => ['min:0']
        ];
    }

    public function messages()
    {
        return [
            'limit.max'         => 'Não é possível listar mais do que 50 registros por requisição.',
            'limit.min'         => 'Não é possível limitar a menos que 1 registro por requisição.',
            'offset.min'        => 'Não é possível selecionar um offset inferior a zero.',
        ];
    }
}
