<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Console\Commands\StoreUsers;
use App\Models\User;
use Mockery\MockInterface;

class StoreUsersTest extends TestCase
{
    /**
     * Store User console command test.
     *
     * @return void
     */
    public function test_store_user_console_command()
    {
        $this->artisan('StoreUsers')
        ->expectsOutput('Users Saved')
        ->assertExitCode(0);
    }

    public function test_save_users_method()
    {
        $userIds = [
            1,2,3
        ];

        $users = collect()->push(
            $this->mock(
                User::class,
                function (MockInterface $mock) use ($userIds) {
                    $mock->shouldReceive('offsetGet')
                        ->with('first_name')
                        ->andReturnSelf();
                    $mock->shouldReceive('offsetGet')
                        ->with('last_name')
                        ->andReturnSelf();
                    $mock->shouldReceive('offsetGet')
                        ->with('email')
                        ->andReturnSelf();
                }
            )
        );

        resolve(StoreUsers::class)->saveUsers($users);
    }
}
