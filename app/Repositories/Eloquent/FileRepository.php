<?php
namespace App\Repositories\Eloquent;

use App\Models\ProjectFile;
use App\Repositories\FileRepositoryInterface;

class FileRepository implements FileRepositoryInterface
{
    public function create(array $data): ProjectFile
    {
        return ProjectFile::create($data);
    }

    public function findByIdAndUser(int $fileId, int $userId): ?ProjectFile
    {
        // نتأكد أن الملف يتبع لمشروع يملكه هذا المستخدم حصرياً
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
