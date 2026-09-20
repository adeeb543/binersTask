<?php
namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function getAllByUser(int $userId): Collection;
    public function findByIdAndUser(int $id, int $userId): ?Project;
    public function create(array $data): Project;
    public function update(Project $project, array $data): bool;
    public function delete(Project $project): bool;
}
