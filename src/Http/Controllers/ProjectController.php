<?php

namespace Luinuxscl\PostPilot\Http\Controllers;

use Illuminate\Http\Request;
use Luinuxscl\PostPilot\Models\Project;
use Luinuxscl\PostPilot\Http\Requests\StoreProjectRequest;
use Luinuxscl\PostPilot\Services\ProjectService;
use Illuminate\Routing\Controller;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function store(StoreProjectRequest $request)
    {
        return response()->json($this->projectService->create($request->validated()), 201);
    }
}
