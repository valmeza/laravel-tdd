<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function index() 
    {
        $data['projects'] = Project::all();

        return view('projects.index', $data);
    }

    public function show(Project $project)
    {
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
        $attributes['owner_id'] = auth()->id();

        // dd($attributes);

        // persist
        Project::create($attributes);

        // redirect
        return redirect(route('projects'));
    }
}
