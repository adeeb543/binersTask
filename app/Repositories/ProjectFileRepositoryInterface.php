<?php
namespace App\Repositories;

use App\Models\ProjectFile;

interface ProjectFileRepositoryInterface
{
    public function create(array $data): ProjectFile;
    public function findByIdAndUser(int $fileId, int $userId): ?ProjectFile;
    public function delete(ProjectFile $file): bool;
}
