<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public Repository $repository;
    public array $with;

    public function __construct(string $repository, array $with = [])
    {
        $this->repository = new $repository;
        $this->with = $with;
    }

    final public function index(Request $request): JsonResponse
    {
        return response()->json($this->repository->all($request->all()));
    }

    final public function find(int $id): JsonResponse
    {
        return response()->json($this->repository->findById($id, $this->with));
    }
}
