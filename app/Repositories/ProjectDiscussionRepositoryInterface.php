<?php

namespace App\Repositories;

use App\Models\ProjectDiscussion;

interface ProjectDiscussionRepositoryInterface
{
    public function getByProjectId(int $projectId);

    // البحث بالمعرفين معاً لضمان الأمان
    public function findByProjectAndId(int $projectId, int $discussionId): ?ProjectDiscussion;

    public function create(array $data): ProjectDiscussion;

    // الحذف بالمعرفين معاً
    public function deleteByProjectAndId(int $projectId, int $discussionId): bool;
}
