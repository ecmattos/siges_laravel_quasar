<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class CustomerValidator.
 *
 * @package namespace App\Validators;
 */
class CustomerValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'cpfcnpj'       => 'cnpj_cpf|required|numeric|unique:customers,cpfcnpj',
            'name'          => 'max:100|required|unique:customers,name',
            'email'         => 'max:100|required|email|unique:customers,email',
            'address'       => 'required',
            'phone'         => 'telefone',
            'mobile'        => 'celular'
        ],
        ValidatorInterface::RULE_UPDATE => []
    ];

    protected $messages = [
        'cnpj_cpf'  => 'Inválido',
        'required'  => 'Obrigatório.',
        'numeric'   => 'Somente números',
        'unique'    => 'Indisponivel',
        'email'     => 'Inválido',
        'telefone'  => 'Inválido',
        'celular'   => 'Inválido'
    ];

    protected $attributes = [
        'cpfcnpj'   => 'CPF/CNPJ',
        'name'      => 'Descrição',
        'email'     => 'E-mail',
        'phone'     => 'Telefone',
        'mobile'    => 'Celular'
    ];   
}
