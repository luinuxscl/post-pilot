<?php

namespace Luinuxscl\PostPilot\Services;

use Luinuxscl\PostPilot\Models\Project;

class ProjectService
{
    public function create(array $data): Project
    {
        if ($data['is_default']) {
            Project::where('is_default', true)->update(['is_default' => false]);
        }

        return Project::create($data);
    }
}
