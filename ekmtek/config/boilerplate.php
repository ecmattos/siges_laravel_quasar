<?php

return [

    // these options are related to the sign-up procedure
    'sign_up' => [

        // this option must be set to true if you want to release a token
        // when your user successfully terminates the sign-in procedure
        'release_token' => env('SIGN_UP_RELEASE_TOKEN', false),

        // here you can specify some validation rules for your sign-in request
        'validation_rules' => [
            'cpfcnpj'   => 'cnpj_cpf|required|unique:clients,cpfcnpj',
            'name'      => 'max:100|required|unique:clients,name',
            'email'     => 'max:100|required|email|unique:clients,email'
        ]
    ],

    'user_admin' => [
        'validation_rules' => [
            'codeVerification' => 'required',
            'name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'min:6|required|required_with:passwordRepeat|same:passwordRepeat',
            'passwordRepeat' => 'min:6|required'
        ]
    ],

    // these options are related to the login procedure
    'login' => [

        // here you can specify some validation rules for your login request
        'validation_rules' => [
            'email' => 'required|email',
            'password' => 'required'
        ],
    ],

    // these options are related to the password recovery procedure
    'password_recovery' => [

        // here you can specify some validation rules for your password recovery procedure
        'validation_rules' => [
            'email' => 'required|email'
        ]
    ],

    // these options are related to the password recovery procedure
    'password_reset' => [

        // this option must be set to true if you want to release a token
        // when your user successfully terminates the password reset procedure
        //'release_token' => env('PASSWORD_RESET_RELEASE_TOKEN', false),

        // here you can specify some validation rules for your password recovery procedure
        'validation_rules' => [
            'codeVerification' => 'required',
            'password' => 'min:6|required|required_with:passwordRepeat|same:passwordRepeat',
            'passwordRepeat' => 'min:6|required'
        ]
    ],

    'customers' => [
        'validation_rules' => [
            'cpfcnpj' => 'cnpj_cpf|required|numeric|unique:customers,cpfcnpj',
            'name' => 'max:100|required|unique:customers,name',
            'email' => 'max:100|required|email|unique:customers,email',
            'address' => 'required',
            'phone' => 'telefone',
            'mobile' => 'celular'
        ]
    ],

];
