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
                'description' => 'required'
            ]
        );

        /*auth with middleware*/
        auth()->user()->projects()->create($attributes);


//    persist
//        Project::create($attributes);
//    redirect
        return redirect('/projects');
    }

    public function show(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }
//        $project = Project::findOrFail(request('project'));
        return view('projects.show', compact('project'));

    }
}
