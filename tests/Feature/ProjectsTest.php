<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */
    public function only_authenticated_users_can_create_projects()
    {
        // $this->withoutExceptionHandling();

        // $attributes = Project::factory()->raw(['owner_id' => null]);
        $attributes = Project::factory()->raw();

        // if you have a project but you are not signed in then
        // you should be redirected to the login page

        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project() 
    {
        $this->actingAs(User::factory()->create());
        
        $this->withoutExceptionHandling(); // laravel by default handles the exception but for testing we want to know what the exception was

        $attributes = [

            'title' => $this->faker->title,
            'description' => $this->faker->paragraph,
        ];

        // after successful post, redirect to the correct view
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);


        // if I make a simple get request -> then assert that we see this new project we created 
        // in this case project title
        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(User::factory()->create());

        // create-> build up the attributes and save to the db  
        // make-> will just build the attributes but wont save to db --- returns an object not an array
        // raw-> will build up the attributes but will store it as an array not and object
        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(User::factory()->create());

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
    
    /** @test */
    public function a_user_can_view_a_project() 
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        // assert that we can see a title and description
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);

    }
}
