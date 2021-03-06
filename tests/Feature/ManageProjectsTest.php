<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
//    use WithFaker, RefreshDatabase;

    use WithFaker;


    /** @test */
    public function guests_cannot_manage_projects()
    {
        $project = factory('App\Project')->create();

        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path() . '/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->get('/projects')->assertRedirect('login');
    }


    /** @test */
    public function a_user_can_create_a_project()
    {


        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => $this->faker->sentence
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())->assertSee($attributes['notes']);
    }

    /** @test */
    public function guests_cannot_delete_projects()
    {
        $project = app(ProjectFactory::class)->create();

        $this->delete($project->path())
            ->assertRedirect("/login");

        $this->signIn();

        $this->delete($project->path())->assertStatus(403);

//        $this->assertDatabaseMissing('projects',$project->only('id') );


    }

    /** @test */
    public function a_user_can_delete_a_project()
    {
        $this->withoutExceptionHandling();
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect("/projects");

        $this->assertDatabaseMissing('projects',$project->only('id') );


    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $this->withoutExceptionHandling();
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = [
                'title' => 'Changed',
                'description' => 'Changed',
                'notes' => 'Changed'])
            ->assertRedirect($project->path());


        $this->get($project->path().'/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);

    }

    /** @test */
    public function a_user_can_update_a_projects_general_notes()
    {

        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['notes' => 'Changed']);

        $this->assertDatabaseHas('projects', $attributes);

    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }


    /** @test */
    public function a_user_can_view_their_project()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();
        $this->get($project->path())->assertStatus(403);

    }

    /** @test */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();
        $this->patch($project->path())->assertStatus(403);

    }


}
