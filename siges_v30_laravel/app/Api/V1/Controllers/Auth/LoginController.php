<?php

namespace App\Api\V1\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;

class LoginController extends Controller
{
    /**
     * Log the user in
     *
     * @param LoginRequest $request
     * @param JWTAuth $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        $credentials['verified'] = 1;

        #dd($credentials);

        try {
            $token = JWTAuth::attempt($credentials);
            dd($token);
            
            if(!$token) {
                throw new AccessDeniedHttpException();
            }

        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        return response()
            ->json([
                'status' => 'ok',
                'token' => $token,
                'expires_in' => Auth::guard()->factory()->getTTL() * 60
            ]);
    }
}
