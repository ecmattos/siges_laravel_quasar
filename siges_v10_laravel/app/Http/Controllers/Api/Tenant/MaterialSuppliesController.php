<?php

namespace App\Http\Controllers\Api\Tenant;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MaterialSupplyCreateRequest;
use App\Http\Requests\MaterialSupplyUpdateRequest;
use App\Repositories\MaterialSupplyRepository;
use App\Validators\MaterialSupplyValidator;

use League\Fractal;

/**
 * Class MaterialSuppliesController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class MaterialSuppliesController extends Controller
{
    /**
     * @var MaterialSupplyRepository
     */
    protected $repository;

    /**
     * @var MaterialSupplyValidator
     */
    protected $validator;

    /**
     * MaterialSuppliesController constructor.
     *
     * @param MaterialSupplyRepository $repository
     * @param MaterialSupplyValidator $validator
     */
    public function __construct(MaterialSupplyRepository $repository, MaterialSupplyValidator $validator)
    {
        $this->repository = $repository;
        $this->repository->skipPresenter(true);
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #$this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $materialSupplies = $this->repository->findWhereIn('material_id', ['1', '3', '5']);
        
        return response()->json([
            'success'  => true,
            'materials' => $materialSupplies,
            'messages' => 'Operação realizada com sucesso!'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MaterialSupplyCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MaterialSupplyCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $materialSupply = $this->repository->create($request->all());

            $response = [
                'message' => 'MaterialSupply created.',
                'data'    => $materialSupply->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $materialSupply = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $materialSupply,
            ]);
        }

        return view('materialSupplies.show', compact('materialSupply'));
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
        $materialSupply = $this->repository->find($id);

        return view('materialSupplies.edit', compact('materialSupply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MaterialSupplyUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MaterialSupplyUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $materialSupply = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MaterialSupply updated.',
                'data'    => $materialSupply->toArray(),
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
                'message' => 'MaterialSupply deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MaterialSupply deleted.');
    }
}
