<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Timesheet;
use App\Models\User;
use App\Models\UserProject;
use Illuminate\Database\Seeder;
use Random\RandomException;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    final public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $user = User::query()->firstOrCreate([
                'name' => 'test ',
                'lastname' => 'user ' . $i,
                'date_of_birth' => '2010-01-01',
                'sex' => 'M',
                'email' => "test_user_$i@mail.com",
                'password' => 'password',
            ]);

            $project = Project::query()->firstOrCreate(
                [
                    'name' => 'test project ' . $i,
                    'departments_id' => Department::query()->inRandomOrder()->first()->id,
                    'start_date' => '2010-01-01',
                    'end_date' => '2010-01-01',
                    'project_statuses_id' => ProjectStatus::query()->inRandomOrder()->first()->id,
                ]
            );

            $userProject = UserProject::query()->firstOrCreate(
                [
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                ]
            );

            Timesheet::query()->firstOrCreate(
              [ 'user_projects_id' => $userProject->id,
                  'title' => 'test timesheet ' . $i,
                  'date' => '2010-01-01',
                  'spent_hours' => random_int(0, 10),
                  ]
            );
        }
    }
}
