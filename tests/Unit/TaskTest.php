<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

use App\Models\Task;
use App\Models\Project;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    function it_belongs_to_a_project()
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    #[Test]
    function it_has_a_path()
    {
        $task = Task::factory()->create();

        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }
}
