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

        $this->post('/projects', $attributes);

        $this->assertDatabaseHas('projects', $attributes);


        // if I make a simple get request -> then assert that we see this new project we created 
        // in this case project title
        $this->get('/projects')->assertSee($attributes['title']);
    }
}
