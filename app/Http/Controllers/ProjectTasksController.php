<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\task;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);

        request()->validate([
            'body' => 'required'
        ]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        request()->validate([
            'body' => 'required'
        ]);

        $task->update(['body' => request('body')]);

        if(request()->has('completed')) {

            $task->complete();

        }

        return redirect(route('projects.show', $project->id));
    }

}
