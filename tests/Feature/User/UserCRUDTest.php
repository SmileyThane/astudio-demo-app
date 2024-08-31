<?php

namespace Tests\Feature\User;

use App\Models\User;
use JsonException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class UserCRUDTest extends TestCase
{
    private string $authToken;

    /**
     * A basic feature test example.
     */
    final public function test_users_list(): void
    {
        $this->prepareTestEnv();
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->get('/api/users');

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    final public function test_user_create_failed(): void
    {
        $this->prepareTestEnv();
        $data = [];
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->post('/api/users', $data);

        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @throws JsonException
     */
    final public function test_user_create_successful(): void
    {
        User::query()->where('email', 'test_user@test.com')->delete();

        $this->prepareTestEnv();
        $data = [
            'name' => 'test user name',
            'lastname' => 'test user lastname',
            'date_of_birth' => '2010-01-01',
            'sex' => 'M',
            'email' => 'test_user@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->post('/api/users', $data);

        $response->assertStatus(ResponseAlias::HTTP_CREATED);
    }

    /**
     * @throws JsonException
     */
    final public function test_user_update(): void
    {
        $this->prepareTestEnv();
        $data = [
            'id' => $this->getTestUserId(),
            'lastname' => 'test user lastname updated',
            'sex' => 'F',
        ];

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->post('/api/users/update', $data);

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    final public function test_user_item(): void
    {
        $this->prepareTestEnv();
        $data = [
            'id' => $this->getTestUserId(),
            'lastname' => 'test user lastname updated',
            'sex' => 'F',
        ];
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->get('/api/users/' . $this->getTestUserId());

        $response->assertJsonFragment($data)->assertStatus(ResponseAlias::HTTP_OK);
    }

    final public function test_user_delete(): void
    {
        $this->prepareTestEnv();
        $data = [
            'id' => $this->getTestUserId(),
        ];
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->post('/api/users/delete', $data);

        $response->assertStatus(ResponseAlias::HTTP_NO_CONTENT);
    }

    private function prepareTestEnv(): void
    {
        $user = User::query()->whereNotNull('email_verified_at')->first();
        $this->authToken = $user->createToken('auth_token_for_php_unit_tests')->plainTextToken;
    }

    private function getTestUserId(): int
    {
        return User::query()->latest('id')->first()->id;
    }
}
