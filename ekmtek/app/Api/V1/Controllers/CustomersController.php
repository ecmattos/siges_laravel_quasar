<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\CustomerRequest;

use App\Repositories\CustomerRepository;
use App\Validators\CustomerValidator;

/**
 * Class CustomersController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class CustomersController extends Controller
{
    /**
     * @var CustomerRepository
     */
    protected $repository;

    /**
     * @var CustomerValidator
     */
    protected $validator;

    /**
     * CustomersController constructor.
     *
     * @param CustomerRepository $repository
     * @param CustomerValidator $validator
     */
    public function __construct(CustomerRepository $repository, CustomerValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $customers = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $customers,
            ]);
        }

        #return view('customers.index', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CustomerRequest $request
     *
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->all();
        
        $customer = $this->repository->create($data);

        if(!$customer) {
            throw new HttpException(500);
        }

        return response()->json([
            'status' => 'ok'
        ], 201);
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
        $customer = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'status' => 'ok'
            ], 201);
        }

        #return view('customers.show', compact('customer'));
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
        $customer = $this->repository->find($id);

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CustomerUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CustomerUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $customer = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Customer updated.',
                'data'    => $customer->toArray(),
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
                'message' => 'Customer deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Customer deleted.');
    }
}
