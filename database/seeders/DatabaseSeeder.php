<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(
            [
                'name' => 'Cool Manager',
                'email' => 'manager@test.com',
                'role' => User::ROLE_MANAGER
            ]
        );
    }
}
