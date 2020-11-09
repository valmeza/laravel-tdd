<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function index() 
    {
        $data['projects'] = auth()->user()->projects;

        return view('projects.index', $data);
    }

    public function show(Project $project)
    {
        // prevent anyone who is not the owner of a project
        if(auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        return view('projects.show', compact('project'));
    }

    public function create() 
    {
        return view('projects.create');
    }

    public function store() 
    {
        // validate
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3'
            // 'owner_id' => 'required'
        ]);

        // do this to prevent people from interfering with request data and possibly 
        // change the owner 
        // so we are no longer doing authentication in the validation level
        // instead we are doing it in the middleware level
        // $attributes['owner_id'] = auth()->id();

        // persist
        $project = auth()->user()->projects()->create($attributes);

        // redirect
        return redirect(route('projects.show', $project->id));
    }

    public function update(Project $project) 
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        $project->update([

            'notes' => request('notes')
        ]);

        return redirect(route('projects.show', $project->id));
    }
}
