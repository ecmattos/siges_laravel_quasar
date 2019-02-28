<?php

namespace App\Api\V1\Controllers\Auth;

use Symfony\Component\HttpKernel\Exception\HttpException;
use JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\MessageBag;
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
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $token = Auth::guard()->attempt($credentials);

            if(!$token) {
                $bag = new MessageBag();
                $bag->add('email', 'Inexistente ou ...');
                $bag->add('password', '... incorreta.');

                return response()->json([
                    'error' => [
                        'message' => '422 Unprocessable Entity',
                        'errors' => $bag,
                        'status_code' => 422
                    ]
                ], 422);
                //throw new AccessDeniedHttpException();
            }

            $user = Auth::user();

        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        return response()
            ->json([
                'status' => 'ok',
                'token' => $token,
                'user' => $user,
                'client_name' => $user->client->name,
                'expires_in' => Auth::guard()->factory()->getTTL() * env('JWT_TTL')
            ]);
    }
}
