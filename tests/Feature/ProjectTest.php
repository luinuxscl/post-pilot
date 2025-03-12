<?php

namespace Luinuxscl\PostPilot\Tests\Feature;

use Luinuxscl\PostPilot\Models\Project;
use Luinuxscl\PostPilot\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_project()
    {
        $projectData = [
            'slug' => 'test123',
            'name' => 'Test Project',
            'editorial_line' => 'This is a test editorial line',
            'target_audience' => 'Test audience',
            'is_default' => true,
        ];

        $response = $this->postJson(route('postpilot.projects.store'), $projectData);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'slug' => 'test123',
                'name' => 'Test Project',
            ]);

        $this->assertDatabaseHas('projects', [
            'slug' => 'test123',
            'name' => 'Test Project',
        ]);
    }

    /** @test */
    public function it_can_set_project_as_default()
    {
        // Create a first default project
        $projectOne = Project::create([
            'slug' => 'first01',
            'name' => 'First Project',
            'is_default' => true,
        ]);

        // Create a second project as default
        $projectTwoData = [
            'slug' => 'second2',
            'name' => 'Second Project',
            'is_default' => true,
        ];

        $response = $this->postJson(route('postpilot.projects.store'), $projectTwoData);
        $response->assertStatus(201);

        // First project should no longer be default
        $this->assertDatabaseHas('projects', [
            'id' => $projectOne->id,
            'is_default' => false,
        ]);

        // Second project should be default
        $this->assertDatabaseHas('projects', [
            'slug' => 'second2',
            'is_default' => true,
        ]);
    }
}
