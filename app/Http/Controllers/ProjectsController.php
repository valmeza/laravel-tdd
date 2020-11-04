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
        // if(auth()->id() !== $project->owner_id) {
        //     abort(403);
        // }

        return view('projects.show', compact('project'));
    }

    public function store() 
    {
        // validate
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            // 'owner_id' => 'required'
            ]);

        // do this to prevent people from interfering with request data and possibly 
        // change the owner 
        // so we are no longer doing authentication in the validation level
        // instead we are doing it in the middleware level
        // $attributes['owner_id'] = auth()->id();

        // persist
        auth()->user()->projects()->create($attributes);

        // redirect
        return redirect(route('projects'));
    }
}
