<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Timesheet\TimesheetCreateRequest;
use App\Http\Requests\API\Timesheet\TimesheetDeleteRequest;
use App\Http\Requests\API\Timesheet\TimesheetUpdateRequest;
use App\Repositories\TimesheetRepository;
use App\Repositories\UserProjectRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TimesheetController extends ApiController
{
    public function __construct()
    {
        parent::__construct(TimesheetRepository::class);
    }

    final public function create(TimesheetCreateRequest $request): JsonResponse
    {
        $userProjectKeys = ['user_id', 'project_id'];
        $userProject = (new UserProjectRepository())->create($request->only($userProjectKeys));
        $request->request->add(['user_projects_id' => $userProject->id]);
        return response()->json($this->repository->create($request->except($userProjectKeys)), ResponseAlias::HTTP_CREATED);
    }

    final public function update(TimesheetUpdateRequest $request): JsonResponse
    {
        $this->repository->update($request->id, $request->validated());
        return $this->find($request->id);
    }

    final public function delete(TimesheetDeleteRequest $request): Response
    {
        $this->repository->delete($request->id);
        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}
