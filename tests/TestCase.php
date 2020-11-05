<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($user = null)
    {
        // sign in as the current user or if null create a new one
        return $this->actingAs($user ?: User::factory()->create());
    }
}
