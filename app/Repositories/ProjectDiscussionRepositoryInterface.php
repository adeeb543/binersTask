<?php

namespace App\Repositories;

use App\Models\ProjectDiscussion;

interface ProjectDiscussionRepositoryInterface
{
    public function getByProjectId(int $projectId);
    public function create(array $data): ProjectDiscussion;
    public function delete(int $id);
}
