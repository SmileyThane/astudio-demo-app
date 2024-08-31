<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\UserCreateRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\Response\ResponseHandlingTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    use ResponseHandlingTrait;

    final public function register(UserCreateRequest $request): Response
    {
        (new UserRepository())->create($request->validated());

        return response(null, ResponseAlias::HTTP_CREATED);
    }

    final public function verify(int $id): Response
    {
        $user = User::query()->find($id);
        if (!$user) {
            $messages = new MessageBag();
            $messages->add('email', __('User not Found.'));
            $this->returnValidationErrors($messages);
        }

        $user->markEmailAsVerified();
        return response(null, ResponseAlias::HTTP_OK);
    }

    final public function login(LoginRequest $request):JsonResponse
    {
        $messages = new MessageBag();

        $user = User::query()->where('email', $request->email)->first();

        if ($user === null) {
            $messages->add('email', __('User not Found.'));
        } elseif (!Hash::check($request->password, $user->password)) {
            $messages->add('email', __('The provided credentials are incorrect.'));
        } elseif (!$user->email_verified_at) {
            $messages->add('email', __('Email is not verified.'));
        }

        if ($messages->isNotEmpty()) {
            $this->returnValidationErrors($messages);
        }

        return response()->json(
            ['token' => $user->createToken('api')->plainTextToken]
        );
    }

    final public function logout(Request $request): Response
    {
        $request->user()->tokens()->delete();

        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}
