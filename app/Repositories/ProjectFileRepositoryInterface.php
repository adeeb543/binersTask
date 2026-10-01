<?php
namespace App\Repositories;

use App\Models\ProjectFile;

interface ProjectFileRepositoryInterface
{
    public function findByProjectAndId(int $projectId, int $fileId): ?ProjectFile;
    public function create(array $data): ProjectFile;
    public function deleteByProjectAndId(int $projectId, int $fileId): bool;
}
