<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UserRegisterValidator.
 *
 * @package namespace App\Validators;
 */
class UserRegisterValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'min:6|required_with:passwordRepeat|same:passwordRepeat',
            'passwordRepeat' => 'min:6|required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'min:6|required_with:passwordRepeat|same:passwordRepeat',
            'passwordRepeat' => 'min:6|required'
        ]
    ];

    protected $messages = [
        'required' => 'Obrigatório.',
        'unique' => 'Indisponivel',
        'email' => 'Inválido',
        'same' => 'Senhas diferentes',
        'max' => 'Máximo :max caracteres',
        'min' => 'Mínimo :min caracteres'
    ];

    protected $attributes = [
        'name' => 'Nome',
        'email' => 'E-mail',
        'password' => 'Senha',
        'passwordRepeat' => 'Senhas diferentes'
    ];   
    
}