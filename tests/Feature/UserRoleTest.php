<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_create_user_with_role_client()
    {
        $user = User::create(
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'role' => User::ROLE_CLIENT,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]
        );

        $user->refresh();

        $this->assertEquals(User::ROLE_CLIENT, $user->role);
    }

    public function test_can_create_user_with_role_manager()
    {
        $user = User::create(
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'role' => User::ROLE_MANAGER,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]
        );


        $user->refresh();

        $this->assertEquals(User::ROLE_MANAGER, $user->role);
    }

    public function test_cannot_create_user_with_incorrect_role()
    {
        $this->expectException(QueryException::class);

        User::create(
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'role' => 'incorrect_role',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]
        );
    }
}
