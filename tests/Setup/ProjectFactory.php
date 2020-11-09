<?php

namespace Tests\Setup;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory
{

    protected $user;
    protected $taskCount = 0;

    public function withTasks($count)
    {
        $this->tasksCount = $count;

        return $this;
    }

    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function create()
    {
        $project = Project::factory()->create([

            //if we have a user use it or set one up from scratch
            'owner_id' => $this->user ?? User::factory()->create()->id
        ]);

        Task::factory()->create([
            'project_id' => $project->id
        ]);

        return $project;   
    }
}