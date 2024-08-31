<?php

namespace Tests\Feature\Project;

use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\User;
use JsonException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class ProjectCRUDTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    private string $authToken;

    /**
     * A basic feature test example.
     */
    final public function test_projects_list(): void
    {
        $this->prepareTestEnv();
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->get('/api/projects');

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    final public function test_user_create_failed(): void
    {
        $this->prepareTestEnv();
        $data = [];
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->post('/api/projects', $data);

        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }

    final public function test_project_create_successful(): void
    {
        $this->prepareTestEnv();
        $data = [
            'name' => 'test project',
            'departments_id' => Department::query()->first()->id,
            'start_date' => '2010-01-01',
            'end_date' => '2010-01-01',
            'project_statuses_id' => ProjectStatus::query()->first()->id,
        ];

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->post('/api/projects', $data);

        $response->assertStatus(ResponseAlias::HTTP_CREATED);
    }

    /**
     * @throws JsonException
     */
    final public function test_project_update(): void
    {
        $this->prepareTestEnv();
        $data = [
            'id' => $this->getTestProjectId(),
            'name' => 'test project updated',
        ];

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->post('/api/projects/update', $data);

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    final public function test_project_item(): void
    {
        $this->prepareTestEnv();
        $data = [
            'name' => 'test project updated',
        ];
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->get('/api/projects/' . $this->getTestProjectId());

        $response->assertJsonFragment($data)->assertStatus(ResponseAlias::HTTP_OK);
    }

    final public function test_project_delete(): void
    {
        $this->prepareTestEnv();
        $data = [
            'id' => $this->getTestProjectId(),
        ];
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->post('/api/projects/delete', $data);

        $response->assertStatus(ResponseAlias::HTTP_NO_CONTENT);
    }

    private function prepareTestEnv(): void
    {
        $user = User::query()->whereNotNull('email_verified_at')->first();
        $this->authToken = $user->createToken('auth_token_for_php_unit_tests')->plainTextToken;
    }

    private function getTestProjectId(): int
    {
        return Project::query()->latest('id')->first()->id;
    }
}
