<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MeetingCreateRequest;
use App\Http\Requests\MeetingUpdateRequest;
use App\Repositories\MeetingRepository;
use App\Validators\MeetingValidator;

/**
 * Class MeetingsController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class MeetingsController extends Controller
{
    /**
     * @var MeetingRepository
     */
    protected $repository;

    /**
     * @var MeetingValidator
     */
    protected $validator;

    /**
     * MeetingsController constructor.
     *
     * @param MeetingRepository $repository
     * @param MeetingValidator $validator
     */
    public function __construct(MeetingRepository $repository, MeetingValidator $validator)
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
        $meetings = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $meetings,
            ]);
        }

        return view('meetings.index', compact('meetings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MeetingCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MeetingCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $meeting = $this->repository->create($request->all());

            $response = [
                'message' => 'Meeting created.',
                'data'    => $meeting->toArray(),
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
        $meeting = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $meeting,
            ]);
        }

        return view('meetings.show', compact('meeting'));
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
        $meeting = $this->repository->find($id);

        return view('meetings.edit', compact('meeting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MeetingUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MeetingUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $meeting = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Meeting updated.',
                'data'    => $meeting->toArray(),
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
                'message' => 'Meeting deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Meeting deleted.');
    }
}
