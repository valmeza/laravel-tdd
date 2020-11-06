<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase;


    // another way to test the test below
    /** @test */
    public function guest_may_not_manage_projects()
    {
        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }


    // /** @test */
    // public function guest_may_not_create_projects()
    // {
    //     // $this->withoutExceptionHandling();

    //     // $attributes = Project::factory()->raw(['owner_id' => null]);
    //     $attributes = Project::factory()->raw();

    //     // if you have a project but you are not signed in then
    //     // you should be redirected to the login page

    //     $this->post('/projects', $attributes)->assertRedirect('login');
    // }

    // /** @test */
    // public function guest_may_not_view_projects()
    // {
    //     $this->get('/projects')->assertRedirect('login');
    // }

    // /** @test */
    // public function guest_may_not_view_a_single_project()
    // {
    //     $project = Project::factory()->create();

    //     $this->get($project->path())->assertRedirect('login');
    // }

    /** @test */
    public function a_user_can_create_a_project() 
    {        
        $this->withoutExceptionHandling(); // laravel by default handles the exception but for testing we want to know what the exception was

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [

            'title' => $this->faker->title,
            'description' => $this->faker->paragraph,
        ];

        // after successful post, redirect to the correct view
        $response = $this->post('/projects', $attributes);

        $response->assertRedirect(Project::where($attributes)->first()->path());

        $this->assertDatabaseHas('projects', $attributes);

        // if I make a simple get request -> then assert that we see this new project we created 
        // in this case project title
        $this->get('/projects')->assertSee($attributes['title']);
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
    public function a_user_can_view_their_project() 
    {
        //sign in a user that is created
        $this->signIn();

        $this->withoutExceptionHandling();

        // be explicit of the id of the owner that is signed in
        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        // assert that we can see a title and description
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);

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
}
