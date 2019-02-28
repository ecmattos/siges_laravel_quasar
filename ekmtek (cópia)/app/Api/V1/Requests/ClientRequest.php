<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function rules()
    {
        return Config::get('boilerplate.sign_up.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}
