<?php

namespace App\Repositories\Eloquent;

use App\Models\ProjectDiscussion;
use App\Repositories\ProjectDiscussionRepositoryInterface;

class ProjectDiscussionRepository implements ProjectDiscussionRepositoryInterface
{
    public function getByProjectId(int $projectId)
    {
        return ProjectDiscussion::with(['sender', 'project'])
            ->where('project_id', $projectId)
            ->latest()
            ->get();
    }

    public function create(array $data): ProjectDiscussion
    {
        return ProjectDiscussion::create($data);
    }
}
