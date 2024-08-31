<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    final public function run(): void
    {
        $this->call(DepartmentsSeeder::class);
        $this->call(ProjectStatusSeeder::class);
        $this->call(FirstUserSeeder::class);
    }
}
