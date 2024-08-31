<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    final public function run(): void
    {
        Department::query()->firstOrCreate([
            'id' => 1
        ], [
            'name' => 'Department 1'
        ]);

        Department::query()->firstOrCreate([
            'id' => 2
        ], [
            'name' => 'Department 2'
        ]);
    }
}
