<?php

namespace App\Repositories\Eloquent;

use App\Models\ProjectFile;
use App\Repositories\ProjectFileRepositoryInterface;

class ProjectFileRepository implements ProjectFileRepositoryInterface
{
    public function findByProjectAndId(int $projectId, int $fileId): ?ProjectFile
    {
        return ProjectFile::where('project_id', $projectId)
            ->where('id', $fileId)
            ->with('project')
            ->first();
    }

    public function create(array $data): ProjectFile
    {
        return ProjectFile::create($data);
    }

   public function deleteByProjectAndId(int $projectId, int $fileId): bool
    {
        $file = $this->findByProjectAndId($projectId, $fileId);

        return $file ? $file->delete() : false;
    }
}
