<?php

namespace Tests\Feature\Timesheet;

use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Timesheet;
use App\Models\User;
use App\Models\UserProject;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TimesheetCRUDTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    private string $authToken;

    final public function test_timesheet_create_failed(): void
    {
        $this->prepareTestEnv();
        $data = [];
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->post('/api/timesheets', $data);

        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }

    final public function test_timesheet_create_successful(): void
    {
        $this->prepareTestEnv();
        $userProjectData = $this->createTestDataForTimesheet();


        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->post('/api/user-projects', $userProjectData);
        $response->assertStatus(ResponseAlias::HTTP_CREATED);


        for ($i=0; $i < 2; $i++) {
            $data = [
                'user_id' => $userProjectData['user_id'],
                'project_id' => $userProjectData['project_id'],
                'title' => 'test timesheet ' . $i,
                'date' => '2010-01-01',
                'spent_hours' => 10,
            ];
            $response = $this
                ->withHeader('Authorization', 'Bearer ' . $this->authToken)
                ->withHeader('Accept', 'application/json')
                ->post('/api/timesheets', $data);

            $response->assertStatus(ResponseAlias::HTTP_CREATED);

        }
    }

    final public function test_timesheet_update(): void
    {
        $this->prepareTestEnv();

        foreach ($this->getTestTimesheetIds() as $id) {
            $data = [
                'id' => $id,
                'spent_hours' => 50,
            ];

            $response = $this
                ->withHeader('Authorization', 'Bearer ' . $this->authToken)
                ->withHeader('Accept', 'application/json')
                ->post('/api/timesheets/update', $data);

            $response->assertStatus(ResponseAlias::HTTP_OK);

        }
    }

    final public function test_project_item(): void
    {
        $this->prepareTestEnv();
        foreach ($this->getTestTimesheetIds() as $id) {
            $data = [
                'spent_hours' => 50,
            ];
            $response = $this
                ->withHeader('Authorization', 'Bearer ' . $this->authToken)
                ->withHeader('Accept', 'application/json')
                ->get('/api/timesheets/' . $id);

            $response->assertJsonFragment($data)->assertStatus(ResponseAlias::HTTP_OK);
        }
    }

    final public function test_timesheet_delete(): void
    {
        $this->prepareTestEnv();
        $data = [
            'id' => Timesheet::query()->latest('id')->first()->id,
        ];
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->post('/api/timesheets/delete', $data);

        $response->assertStatus(ResponseAlias::HTTP_NO_CONTENT);
    }

    final public function test_timesheet_cascade_delete(): void
    {
        $user = User::query()->where(['email' => 'test_timesheet_user@test.com'])->first();
        $project = Project::query()->where(['name' => 'test timesheet project'])->first();
        $userId = $user->id;
        $projectId = $project->id;
        $userProject = UserProject::query()->where(['user_id' => $userId, 'project_id' => $projectId])->first();

        $user->delete();
        $project->delete();

        $existsUserProjects = UserProject::query()->where('id', $userProject)->exists();
        $existsTimesheets = Timesheet::query()->where('user_projects_id', $userProject)->exists();
        $this->assertNotTrue($existsUserProjects);
        $this->assertNotTrue($existsTimesheets);

    }

    final public function test_timesheets_list(): void
    {
        $this->prepareTestEnv();
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->authToken)
            ->withHeader('Accept', 'application/json')
            ->get('/api/timesheets');

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    private function prepareTestEnv(): void
    {
        $user = User::query()->whereNotNull('email_verified_at')->first();
        $this->authToken = $user->createToken('auth_token_for_php_unit_tests')->plainTextToken;
    }

    private function getTestTimesheetIds(): array
    {
        return Timesheet::query()->latest('id')->limit(2)->get()->pluck('id')->toArray();
    }

    private function createTestDataForTimesheet(): array
    {
        $user = User::query()->create([
            'name' => 'test timesheet user name',
            'lastname' => 'test user lastname',
            'date_of_birth' => '2010-01-01',
            'sex' => 'M',
            'email' => 'test_timesheet_user@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $project = Project::query()->create(
            [
                'name' => 'test timesheet project',
                'departments_id' => Department::query()->first()->id,
                'start_date' => '2010-01-01',
                'end_date' => '2010-01-01',
                'project_statuses_id' => ProjectStatus::query()->first()->id,
            ]
        );

        return [
            'user_id' => $user->id,
            'project_id' => $project->id,
        ];
    }
}
