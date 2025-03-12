<?php

namespace Luinuxscl\PostPilot;

use Luinuxscl\PostPilot\Models\Project;
use Luinuxscl\PostPilot\Services\ProjectService;

class PostPilot
{
    protected $projectService;
    
    public function __construct()
    {
        $this->projectService = app(ProjectService::class);
    }
    
    /**
     * Crear un nuevo proyecto.
     *
     * @param array $data
     * @return Project
     */
    public function createProject(array $data): Project
    {
        return $this->projectService->create($data);
    }
    
    /**
     * Obtener el proyecto predeterminado.
     *
     * @return Project|null
     */
    public function getDefaultProject()
    {
        return Project::where('is_default', true)->first();
    }
}
