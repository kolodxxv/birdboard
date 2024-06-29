<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Project;
use App\Models\Task;

class ProjectTasksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    #[Test]
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        // $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');
    }

    #[Test]
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}

