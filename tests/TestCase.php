<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($user = null)
    {
        $user = $user ?: User::factory()->create();

        // sign in as the current user or if null create a new one
        $this->actingAs($user);

        return $user;
    }
}
