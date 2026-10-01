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

    // دالة جديدة لجلب المشروع بالـ ID فقط مع علاقاته الأساسية
    public function findById(int $id): ?Project
    {
        return Project::with('files')->find($id);
    }

   // public function findByIdAndUser(int $id, int $userId): ?Project
   // {
     //   return Project::where('id', $id)->where('user_id', $userId)->with('files')->first();
   // }

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

    public function getPaginated($perPage = 10)
    {
        return Project::latest()->paginate($perPage);
    }

    public function findByIdWithRelations($id, array $relations = [])
    {
        return Project::with($relations)->findOrFail($id);
    }

    public function updateStatus($id, string $status)
    {
        $project = Project::findOrFail($id);
        $project->update([
            'status' => $status
        ]);

        return $project;
    }
}
