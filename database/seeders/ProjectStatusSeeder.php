<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    final public function run(): void
    {
        ProjectStatus::query()->firstOrCreate([
            'id' => 1
        ], [
            'name' => 'New'
        ]);

        ProjectStatus::query()->firstOrCreate([
            'id' => 2
        ], [
            'name' => 'In Progress'
        ]);

        ProjectStatus::query()->firstOrCreate([
            'id' => 3
        ], [
            'name' => 'Finished'
        ]);
    }
}
