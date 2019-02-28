<?php

namespace App\Api\V1\Controllers;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Api\V1\Requests\ClientRequest;
use App\Repositories\ClientRepository;
use App\Mail\ClientNewMail;
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
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $clients = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clients,
            ]);
        }

        return view('clients.index', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ClientRequest $request, JWTAuth $JWTAuth)
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

        $subject = config('app.name') . " - Confirmação do Cadastro";
        Mail::to($client->email)
            ->send(new ClientNewMail($subject, $client));
        
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
        $client = $this->repository->find($id);

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
        $client = $this->repository->find($id);

        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ClientUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $client = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Client updated.',
                'data'    => $client->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Client deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Client deleted.');
    }
}
