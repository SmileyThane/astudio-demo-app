<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserProject\UserProjectCreateRequest;
use App\Http\Requests\API\UserProject\UserProjectDeleteRequest;
use App\Repositories\Repository;
use App\Repositories\UserProjectRepository;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserProjectController extends Controller
{
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new UserProjectRepository();
    }

    final public function create(UserProjectCreateRequest $request): Response
    {
        $this->repository->create($request->validated());
        return response(null, ResponseAlias::HTTP_CREATED);
    }

    final public function delete(UserProjectDeleteRequest $request): Response
    {
        $this->repository->delete($this->repository->findIdByParams($request->validated()));
        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}
