<?php

namespace App\Api\V1\Controllers\Auth;

use App\Http\Controllers\Controller;
#use Illuminate\Support\Facades\Password;
use App\Api\V1\Requests\PasswordRecoveryRequest;
use App\Api\V1\Requests\PasswordResetRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repositories\UserRepository;
use App\Mail\Auth\PasswordRecoveryMail;
use Illuminate\Support\MessageBag;
use Mail;
use DB;

class PasswordController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UsersController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function recovery(PasswordRecoveryRequest $request)
    {
        $data = $request->all();
        $user = $this->userRepository->findWhere(['email' => $data['email']])->first();
        
        if(!$user) {
            //throw new HttpException(500);
            $bag = new MessageBag();
            $bag->add('email', 'Inexistente.');
                        
            return response()->json([
                'error' => [
                    'message' => '422 Unprocessable Entity',
                    'errors' => $bag,
                    'status_code' => 422
                ]
            ], 422);
        }

        $user_id = $user->id;

        $code_verification = str_random(20);
        $this->userRepository->update(['code_verification' => $code_verification], $user->id);
                    
        $user = $this->userRepository->find($user_id);
                    
        $subject = config('app.name') . " - Recuperação da Senha de Acesso";
        Mail::to($user->email)
            ->send(new PasswordRecoveryMail($subject, $user));
                    
        return response()->json([
            'status' => 'ok'
        ], 201);
    }

    public function reset(PasswordResetRequest $request)
    {
        $data = $request->all();
        #dd($data['codeVerification']);

        $user = $this->userRepository->findWhere(['code_verification' => $data['codeVerification']])->first();
        #dd($user);    
        if(!$user) {
            //throw new HttpException(500);
            $bag = new MessageBag();
            $bag->add('codeVerification', 'Inválido.');
            
            return response()->json([
                'error' => [
                    'message' => '422 Unprocessable Entity',
                    'errors' => $bag,
                    'status_code' => 422
                ]
            ], 422);
        }

        $this->userRepository->update(['password' => $data['password']], $user->id);
        
        return response()->json([
            'status' => 'ok'
        ], 201);
        
    }
    
    public function sendResetEmail(ForgotPasswordRequest $request)
    {
        $user = User::where('email', '=', $request->get('email'))->first();

        if(!$user) {
            throw new NotFoundHttpException();
        }

        $broker = $this->getPasswordBroker();
        $sendingResponse = $broker->sendResetLink($request->only('email'));

        if($sendingResponse !== Password::RESET_LINK_SENT) {
            throw new HttpException(500);
        }

        return response()->json([
            'status' => 'ok'
        ], 200);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    private function getPasswordBroker()
    {
        return Password::broker();
    }
}
