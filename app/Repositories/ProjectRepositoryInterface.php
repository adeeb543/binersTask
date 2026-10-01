<?php
namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function getAllByUser(int $userId): Collection;
    public function findById(int $id): ?Project;
    public function create(array $data): Project;
    public function update(Project $project, array $data): bool;
    public function delete(Project $project): bool;

    public function getPaginated($perPage = 10);
    public function findByIdWithRelations($id, array $relations = []);
    public function updateStatus($id, string $status);
}
