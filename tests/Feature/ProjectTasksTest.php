<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        // $this->withOutExceptionHandling();

        $this->signIn();

        //create but make sure project belongs to an authenticated user
        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        // if you make a post request to the given end point it will
        // add a task to the given project
        $this->post($project->path(). '/tasks', ['body' => 'Joe Biden']);

        // now if we try to view that project
        // we should see the tasks
        $this->get($project->path())
            ->assertSee('Joe Biden');
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
