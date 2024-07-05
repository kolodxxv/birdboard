<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Project;
use App\Models\User;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    #[Test]
    public function guests_cannot_manage_projects()
    {

        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        
    }

    #[Test]
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph

        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    #[Test]
    public function a_user_can_view_their_project()
    {
        $this->signIn();

        $this->withoutExceptionHandling();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    #[Test]
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        // Create a project 
        $project = Project::factory()->create();

        // Attempt to access the project path
        $response = $this->get($project->path());

        // Assert that the response status code is 403 (Forbidden)
        $response->assertStatus(403);
        
    }

    #[Test]
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '' ]);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    #[Test]
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '' ]);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

}
