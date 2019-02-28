<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class PasswordRecoveryRequest extends FormRequest
{
    public function rules()
    {
        return Config::get('boilerplate.password_recovery.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}
