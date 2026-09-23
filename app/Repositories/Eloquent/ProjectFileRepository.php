<?php
namespace App\Repositories\Eloquent;

use App\Models\ProjectFile;
use App\Repositories\ProjectFileRepositoryInterface;

class ProjectFileRepository implements ProjectFileRepositoryInterface
{
    public function create(array $data): ProjectFile
    {
        return ProjectFile::create($data);
    }

    public function findByIdAndUser(int $fileId, int $userId): ?ProjectFile
    {
        return ProjectFile::where('id', $fileId)
            ->whereHas('project', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->first();
    }

    public function delete(ProjectFile $file): bool
    {
        return $file->delete();
    }
}
