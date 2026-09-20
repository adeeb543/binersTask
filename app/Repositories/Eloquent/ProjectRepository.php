<?php
namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllByUser(int $userId): Collection
    {
        return Project::where('user_id', $userId)->with('files')->latest()->get();
    }

    public function findByIdAndUser(int $id, int $userId): ?Project
    {
        return Project::where('id', $id)->where('user_id', $userId)->with('files')->first();
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data): bool
    {
        return $project->update($data);
    }

    public function delete(Project $project): bool
    {
        return $project->delete();
    }
}
