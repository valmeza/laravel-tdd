<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_may_not_add_tasks_to_projects()
    {
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Joe Biden'])
            ->assertStatus(403);

        // if we are forbidden to add a task that is not ours be sure not to save anything to the db
        $this->assertDatabaseMissing('tasks', ['body' => 'Joe Biden']);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_tasks()
    {
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks()->first()->path(), ['body' => 'Changed.'])
            ->assertStatus(403);

        // if we are forbidden to update a task that is not ours be sure not to save anything to the db
        $this->assertDatabaseMissing('tasks', ['body' => 'Changed.']);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        //create but make sure project belongs to an authenticated user
        $project = ProjectFactory::create();

        // if you make a post request to the given end point it will
        // add a task to the given project
        $this->actingAs($project->owner)
            ->post($project->path(). '/tasks', ['body' => 'Joe Biden']);

        // now if we try to view that project
        // we should see the tasks
        $this->get($project->path())
            ->assertSee('Joe Biden');
    }

    /** @test */
    public function a_task_can_be_updated()
    {

        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks()->first()->path(), [
                'body' => 'This is updated'
        ]);

        // assert that in the db we have those exact fields
        $this->assertDatabaseHas('tasks', [
            'body' => 'This is updated'
        ]);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $project = ProjectFactory::create();

        $attributes = Task::factory()->raw(['body' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }

}
