<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    protected function signIn($user = null)
    {
        return $this->actingAs($user ?: User::factory()->create());
    }
}
