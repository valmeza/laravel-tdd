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

    public function store() 
    {
        // validate

        // persist
        Project::create(request(['title', 'description']));

        // redirect
        return redirect(route('projects'));
    }
}
