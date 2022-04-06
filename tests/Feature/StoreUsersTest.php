<?php

namespace Tests\Feature;

use Tests\TestCase;

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
}
