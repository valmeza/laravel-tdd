<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */
    public function guest_may_not_manage_projects()
    {
        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path() . '/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project() 
    {        
        // laravel by default handles the exception but for testing we want to know what the exception was
        $this->withoutExceptionHandling(); 
        
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [

            'title' => $this->faker->title,
            'description' => $this->faker->sentence,
            'notes' => 'General notes'
        ];

        // after successful post, redirect to the correct view
        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        // if I make a simple get request -> then assert that we see this new project we created 
        // in this case project title

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->patch($project->path(), $attributes = ['title' => 'Changed', 'description' => 'Changed', 'notes' => 'Changed'])
            ->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->patch($project->path(), $attributes = ['notes' => 'Changed'])
        ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }
    
    /** @test */
    public function a_user_can_view_their_project() 
    {
        $project = ProjectFactory::create();

        // assert that we can see a title and description
        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);

    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        // create-> build up the attributes and save to the db  
        // make-> will just build the attributes but wont save to db --- returns an object not an array
        // raw-> will build up the attributes but will store it as an array not and object
        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    /** @test */
    public function an_authenticated_user_may_not_view_the_projects_of_others()
    {
        $this->signIn();

        // $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        // if the project is does not belong to that user
        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_may_not_update_the_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        // if the project is does not belong to that user
        $this->patch($project->path())->assertStatus(403);
    }
}
