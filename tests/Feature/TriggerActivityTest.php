<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = app(ProjectFactory::class)->create();
        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    /** @test */
    public function updating_a_project()
    {

        $project = app(ProjectFactory::class)->create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);

    }

    /** @test */
    public function creating_a_new_task()
    {

        $project = app(ProjectFactory::class)->create();

        $project->addTask('Some task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
        });

    }

    /** @test */
    public function completing_a_task()
    {

        $project = app(ProjectFactory:: class)->withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'updated',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);

    }

    /** @test */
    public function incompleting_a_task()
    {

        $project = app(ProjectFactory:: class)->withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'updated',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);


        $this->patch($project->tasks[0]->path(), [
            'body' => 'updated',
            'completed' => false
        ]);

        $project->refresh();

        $this->assertCount(4, $project->activity);

        $this->assertEquals('incompleted_task', $project->activity->last()->description);

    }

    /** @test */
    public function deleting_a_task()
    {
        $this->withoutExceptionHandling();
        $project = app(ProjectFactory::class)->withtasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);

    }
}
