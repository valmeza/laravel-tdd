<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project) 
    {
        if(auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        request()->validate([
            'body' => 'required'
        ]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task) 
    {
        $task->update([

            'body' => request('body'),
            // you could do request('completed') BUT this can cause issues if a request
            // checkbox is not checked so ->has('completed') will take care of that
            'completed' => request()->has('completed')

        ]);

        return redirect(route('projects.show', $project->id));
    }

}
