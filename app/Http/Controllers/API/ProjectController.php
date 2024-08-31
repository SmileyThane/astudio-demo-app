<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Project\ProjectCreateRequest;
use App\Http\Requests\API\Project\ProjectDeleteRequest;
use App\Http\Requests\API\Project\ProjectUpdateRequest;
use App\Repositories\ProjectRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProjectController extends ApiController
{
    public function __construct()
    {
        parent::__construct(ProjectRepository::class, ['users', 'timesheets']);
    }

    final public function create(ProjectCreateRequest $request): JsonResponse
    {
        return response()->json($this->repository->create($request->validated()), ResponseAlias::HTTP_CREATED);
    }

    final public function update(ProjectUpdateRequest $request): JsonResponse
    {
        $this->repository->update($request->id, $request->validated());
        return $this->find($request->id);
    }

    final public function delete(ProjectDeleteRequest $request): Response
    {
        $this->repository->delete($request->id);
        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}
