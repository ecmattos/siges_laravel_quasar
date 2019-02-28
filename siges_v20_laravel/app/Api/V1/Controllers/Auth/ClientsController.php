<?php

namespace App\Api\V1\Controllers\Auth;

use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\SignUpRequest;
use App\Repositories\ClientRepository;
use App\Mail\SendClientVerifyMailable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Mail;

/**
 * Class ClientsController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class ClientsController extends Controller
{
    /**
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * ClientsController constructor.
     *
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->clientRepository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $clients = $this->clientRepository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clients,
            ]);
        }

        return view('clients.index', compact('clients'));
    }

    public function store(SignUpRequest $request, JWTAuth $JWTAuth)
    {
        $data = $request->all();
        
        $data['code'] = $this->generateCode();
        $data['domain'] = env("DOMAIN");
        $data['database'] = env('DB_DATABASE')."_".$data['code'];
        $data['hostname'] = env('DB_HOST');
        $data['username'] = env('DB_USERNAME');
        $data['password'] = env('DB_PASSWORD');
        $data['code_verification'] =  str_random(20);

        $code_verification = $data['code_verification'];

        #dd($data);
                       
        $client = $this->clientRepository->create($data);
            
        if(!$client) {
            throw new HttpException(500);
        }

        $subject = "SiGeS - Confirmação do Cadastro";
        Mail::to($client->email)
            ->send(new SendClientVerifyMailable($subject, $client, $code_verification));
        
        return response()->json([
            'status' => 'ok'
        ], 201);
        
    }

    public function generateCode()
	{
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $charsLength = strlen($chars);
        
        $size = 10;

        $codeRandomString = '';
        
        for($i = 0; $i < $size; $i++)
        {
           $codeRandomString .= $chars[rand(0, $charsLength - 1)];
		}
        
        return $codeRandomString;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->clientRepository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $client,
            ]);
        }

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = $this->clientRepository->find($id);

        return view('clients.edit', compact('client'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->clientRepository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Client deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Client deleted.');
    }
}
