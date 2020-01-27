<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

//    use WithFaker;


    /** @test */
    public function a_project_can_have_tasks()
    {


        $project = app(ProjectFactory::class)
            ->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', ['body' => 'Test Task']);

        $this->get($project->path())
            ->assertSee('Test Task');
    }

    /** @test */
    public function a_task_can_be_updated()
    {

        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'updated'
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'updated'
        ]);
    }

    /** @test */
    public function a_task_can_be_completed()
    {

        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'updated',
                'completed' => true
            ]);

        $this->assertDatabaseHas('tasks', ['body' => 'updated', 'completed' => true]);
    }

    /** @test */
    public function a_task_can_be_marked_as_incomplete()
    {

        $this->withoutExceptionHandling();
        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'updated',
                'completed' => true
            ]);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'updated',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'updated',
            'completed' => false
        ]);
    }

    /** @test */
    public function a_task_requires_a_body()
    {

        $project = app(ProjectFactory::class)
            ->create();

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . "/tasks", $attributes)
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {

        $project = factory('App\Project')->create();
        $this->post($project->path() . "/tasks")->assertRedirect('login');

    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {

        $this->signIn();

        $project = factory('App\Project')->create();

        $this->post($project->path() . "/tasks", ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);


    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_a_task()
    {

        $this->signIn();

        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks[0]->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);


    }
}
