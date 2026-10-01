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

    public function findByProjectAndId(int $projectId, int $discussionId): ?ProjectDiscussion
    {
        return ProjectDiscussion::where('project_id', $projectId)
            ->where('id', $discussionId)
            ->with('project')
            ->first();
    }

    public function create(array $data): ProjectDiscussion
    {
        return ProjectDiscussion::create($data);
    }

    public function deleteByProjectAndId(int $projectId, int $discussionId): bool
    {
        $discussion = $this->findByProjectAndId($projectId, $discussionId);

        return $discussion ? $discussion->delete() : false;
    }
}
