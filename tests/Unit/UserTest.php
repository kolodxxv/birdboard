<?php

namespace Tests\Unit;


use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_has_projects()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
