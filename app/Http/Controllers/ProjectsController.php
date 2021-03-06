<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
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
        // if(auth()->user()->isNot($project->owner)) {
        //     abort(403);
        // }

        // using policies does the same as above ^^^
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function create() 
    {
        return view('projects.create');
    }

    public function store() 
    {
        // do this to prevent people from interfering with request data and possibly 
        // change the owner 
        // so we are no longer doing authentication in the validation level
        // instead we are doing it in the middleware level
        // $attributes['owner_id'] = auth()->id();

        // persist
        $project = auth()->user()->projects()->create($this->formValidation());

        // redirect
        return redirect(route('projects.show', $project->id));
    }

    public function edit(Project $project) 
    {
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request) 
    {
        return redirect($request->save()->path());
    }

    protected function formValidation()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
            // 'owner_id' => 'required'
        ]);
    }
}
