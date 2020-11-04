<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project() 
    {
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
        $this->post('/projects', [])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->post('/projects', [])->assertSessionHasErrors('description');
    }

}
