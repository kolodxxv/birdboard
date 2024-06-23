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
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph

        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    #[Test]
    public function a_user_can_view_their_project()
    {
        $this->be(User::factory()->create());

        $this->withoutExceptionHandling();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    #[Test]
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        // Create an authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

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
        $user = User::factory()->create();
        $this->actingAs($user);

        $attributes = Project::factory()->raw(['title' => '' ]);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    #[Test]
    public function a_project_requires_a_description()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $attributes = Project::factory()->raw(['description' => '' ]);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

}
