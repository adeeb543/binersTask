<?php
namespace App\Services;

use App\Repositories\ProjectRepositoryInterface;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectService
{
    protected ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getUserProjects(int $userId): Collection
    {
        return $this->projectRepository->getAllByUser($userId);
    }

    public function createProject(array $data, int $userId): Project
    {
        return DB::transaction(function () use ($data, $userId) {
            $data['user_id'] = $userId;
            return $this->projectRepository->create($data);
        });
    }

    public function getProjectDetails(int $id, int $userId): Project
    {
        $project = $this->projectRepository->findByIdAndUser($id, $userId);

        if (! $project) {
            throw ValidationException::withMessages([
                'project' => ['المشروع غير موجود أو ليس لديك صلاحية للوصول إليه.'],
            ]);
        }

        return $project;
    }

    public function updateProject(int $id, array $data, int $userId): Project
    {
        $project = $this->getProjectDetails($id, $userId);

        DB::transaction(function () use ($project, $data) {
            $this->projectRepository->update($project, $data);
        });

        return $project->fresh();
    }

    public function deleteProject(int $id, int $userId): void
    {
        $project = $this->getProjectDetails($id, $userId);

        DB::transaction(function () use ($project) {
            $this->projectRepository->delete($project);
        });
    }
}
