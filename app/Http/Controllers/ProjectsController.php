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
            'description' => 'required'
            ]);

        // persist
        Project::create($attributes );

        // redirect
        return redirect(route('projects'));
    }
}
