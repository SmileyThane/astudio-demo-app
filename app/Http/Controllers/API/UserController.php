<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\User\UserCreateRequest;
use App\Http\Requests\API\User\UserDeleteRequest;
use App\Http\Requests\API\User\UserUpdateRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends ApiController
{
    public function __construct()
    {
        parent::__construct(UserRepository::class, ['projects', 'timesheets']);
    }

    final public function create(UserCreateRequest $request): JsonResponse
    {
        return response()->json($this->repository->create($request->validated()), ResponseAlias::HTTP_CREATED);
    }

    final public function update(UserUpdateRequest $request): JsonResponse
    {
        $this->repository->update($request->id, $request->validated());
        return $this->find($request->id);
    }

    final public function delete(UserDeleteRequest $request): Response
    {
        $this->repository->delete($request->id);
        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}
