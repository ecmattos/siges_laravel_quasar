<?php

namespace App\Api\V1\Controllers\Auth;

use Config;
use Mail;
use App\Entities\User;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\SignUpRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Mail\VerifyUser;

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
    {
        $data = $request->all();
        $data['code_verification'] = sha1(time());
    
        $user = new User($data);

        if(!$user->save()) {
            throw new HttpException(500);
        }
        
        if(!Config::get('boilerplate.sign_up.release_token')) {
            $subject = "SiGeS - Confirmação do Cadastro";
            Mail::to($user->email)->send(new VerifyUser($subject, $user));
            
            return response()->json([
                'status' => 'ok'
            ], 201);
        }

        $token = $JWTAuth->fromUser($user);
        return response()->json([
            'status' => 'ok',
            'token' => $token
        ], 201);
    }
}
