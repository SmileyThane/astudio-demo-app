<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FirstUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    final public function run(): void
    {
        User::query()->forceCreate([
            'id' => 1,
            'name' => 'first',
            'lastname' => 'user',
            'date_of_birth' => '2010-01-01',
            'sex' => 'M',
            'email_verified_at' => '2010-01-01',
            'email' => 'first_user@mail.com',
            'password' => 'Qwerty!23456',
        ]);
    }
}
