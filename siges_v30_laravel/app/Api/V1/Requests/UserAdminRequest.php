<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class UserAdminRequest extends FormRequest
{
    public function rules()
    {
        return Config::get('boilerplate.user_admin.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}
