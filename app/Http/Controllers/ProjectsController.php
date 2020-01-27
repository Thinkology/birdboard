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

    /**
     * Persist a new project
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {

        /*auth with middleware*/
        $project = auth()->user()->projects()->create($this->validateRequest());

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the project
     *
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Project $project)
    {

        $this->authorize('update', $project);

        $project->update($this->validateRequest());

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

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect('/projects');

    }

    /**
     * Validate the request attributes
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
                'title' => 'sometimes|required',
                'description' => 'sometimes| required',
                'notes' => 'nullable'
            ]
        );
    }
}
