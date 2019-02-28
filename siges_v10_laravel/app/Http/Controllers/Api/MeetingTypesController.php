<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MeetingTypeCreateRequest;
use App\Http\Requests\MeetingTypeUpdateRequest;
use App\Repositories\MeetingTypeRepository;
use App\Validators\MeetingTypeValidator;

/**
 * Class MeetingTypesController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class MeetingTypesController extends Controller
{
    /**
     * @var MeetingTypeRepository
     */
    protected $repository;

    /**
     * @var MeetingTypeValidator
     */
    protected $validator;

    /**
     * MeetingTypesController constructor.
     *
     * @param MeetingTypeRepository $repository
     * @param MeetingTypeValidator $validator
     */
    public function __construct(MeetingTypeRepository $repository, MeetingTypeValidator $validator)
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
        $meetingTypes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $meetingTypes,
            ]);
        }

        return view('meetingTypes.index', compact('meetingTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MeetingTypeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MeetingTypeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $meetingType = $this->repository->create($request->all());

            $response = [
                'message' => 'MeetingType created.',
                'data'    => $meetingType->toArray(),
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
        $meetingType = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $meetingType,
            ]);
        }

        return view('meetingTypes.show', compact('meetingType'));
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
        $meetingType = $this->repository->find($id);

        return view('meetingTypes.edit', compact('meetingType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MeetingTypeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MeetingTypeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $meetingType = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MeetingType updated.',
                'data'    => $meetingType->toArray(),
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
                'message' => 'MeetingType deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MeetingType deleted.');
    }
}
