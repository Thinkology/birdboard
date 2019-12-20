<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    //
    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function store()
    {

//    validate
        $attributes = request()->validate([
                'title' => 'required',
                'description' => 'required',
                'notes' => 'min:3'
            ]
        );

        /*auth with middleware*/
        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    public function update(Project $project)
    {

        $this->authorize('update', $project);

        $project->update(request(['notes']));

        return redirect($project->path());
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));

    }

    public function create()
    {
        return view('projects.create');
    }
}
