<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {

        /*only_the_owner_of_a_project_may_add_tasks*/
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        //    validate
        request()->validate(['body' => 'required']);

        $project->addTask(request('body'));
        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        /*only_the_owner_of_a_project_may_add_tasks*/
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        //    validate
        request()->validate(['body' => 'required']);

        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed')
        ]);
        return redirect($project->path());
    }
}
