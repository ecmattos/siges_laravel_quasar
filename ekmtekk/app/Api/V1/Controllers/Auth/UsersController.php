<?php

namespace App\Api\V1\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\ClientRepository;
use App\Api\V1\Requests\UserAdminRequest;
use Illuminate\Support\MessageBag;
use JWTAuth;
use Config;

/**
 * Class UsersController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class UsersController extends Controller
{
    protected $userRepository;
    protected $clientRepository;

    public function __construct(UserRepository $userRepository, ClientRepository $clientRepository)
    {
        $this->userRepository = $userRepository;
        $this->clientRepository = $clientRepository;
    }

    public function admin_store(UserAdminRequest $request, JWTAuth $JWTAuth)
    {
        $data = $request->all();
        $code_verification = $data['codeVerification'];

        try {
            $check = $this->clientRepository->findWhere(['code_verification' => $code_verification])->first();
            $bag = new MessageBag();
                        
            if(!is_null($check))
            {
                $client = $this->clientRepository->find($check->id);

                if($client->verified==0)
                {
                    $this->clientRepository->update(['verified' => 1], $client->id);
                }

                $name = $data['name'];
                $email = $data['email'];
                $password = $data['password'];

                $user = $this->userRepository->create([
                    'client_id' => $client->id,
                    'name' => $name, 
                    'email' => $email, 
                    'password' => $password,
                    'role' => 'Admin',
                    'code_verification' => str_random(20),
                    'verified' => 1
                ]);

                if(!$user->save()) {
                    throw new HttpException(500);
                }

                if(!Config::get('boilerplate.sign_up.release_token')) {
                    return response()->json([
                        'status' => 'ok'
                    ], 201);
                }

                $token = $JWTAuth->fromUser($user);
                return response()->json([
                    'status' => 'ok',
                    'token' => $token
                ], 201);

                $subject = config('app.name') . " - Confirmação do Novo Usuário";
                Mail::to($user->email)
                    ->send(new UserNewMail($subject, $user->client, $user));
            }

            $bag->add('codeVerification', 'Inválido.');
            return response()->json([
                'error' => [
                    'message' => '422 Unprocessable Entity',
                    'errors' => $bag,
                    'status_code' => 422
                ]
            ], 422);

        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'errors' => $e->getMessageBag()
                ], 422);
            }
        }                  
    }
}
