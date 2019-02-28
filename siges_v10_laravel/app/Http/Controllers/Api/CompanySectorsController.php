<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CompanySectorCreateRequest;
use App\Http\Requests\CompanySectorUpdateRequest;
use App\Repositories\CompanySectorRepository;
use App\Validators\CompanySectorValidator;

/**
 * Class CompanySectorsController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class CompanySectorsController extends Controller
{
    /**
     * @var CompanySectorRepository
     */
    protected $repository;

    /**
     * @var CompanySectorValidator
     */
    protected $validator;

    /**
     * CompanySectorsController constructor.
     *
     * @param CompanySectorRepository $repository
     * @param CompanySectorValidator $validator
     */
    public function __construct(CompanySectorRepository $repository, CompanySectorValidator $validator)
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
        $companySectors = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $companySectors,
            ]);
        }

        return view('companySectors.index', compact('companySectors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanySectorCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CompanySectorCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $companySector = $this->repository->create($request->all());

            $response = [
                'message' => 'CompanySector created.',
                'data'    => $companySector->toArray(),
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
        $companySector = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $companySector,
            ]);
        }

        return view('companySectors.show', compact('companySector'));
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
        $companySector = $this->repository->find($id);

        return view('companySectors.edit', compact('companySector'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanySectorUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CompanySectorUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $companySector = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'CompanySector updated.',
                'data'    => $companySector->toArray(),
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
                'message' => 'CompanySector deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'CompanySector deleted.');
    }
}
